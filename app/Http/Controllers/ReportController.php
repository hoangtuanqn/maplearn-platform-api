<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Course;
use App\Models\Document;
use App\Models\Post;
use App\Models\Report;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Chỉ có admin hoặc người đăng mới dc xem
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'reportable_id' => 'required|integer',
            'reportable_type' => 'required|string|in:document,post,course',
            'reason' => 'required|string|max:255',
            'message' => 'nullable|string|max:500',
        ]);


        // Tùy theo reportable_type, bạn lấy model phù hợp
        $modelClass = match ($data['reportable_type']) {
            'document' => \App\Models\Document::class,
            'post' => \App\Models\Post::class,
            'course' => \App\Models\Course::class,
            default => null,
        };
        $userId = $request->user()->id;
        $exists = Report::where('reportable_id', $data['reportable_id'])
            ->where('reportable_type', $modelClass)
            ->where('reported_by', $userId)
            ->whereDate('created_at', Carbon::today())
            ->exists();

        if ($exists) {
            return $this->errorResponse('Bạn đã báo cáo mục này hôm nay rồi.', 429);
        }



        if (!$modelClass) {
            return $this->errorResponse('Loại báo cáo không hợp lệ', 422);
        }

        $reportable = $modelClass::find($data['reportable_id']);
        if (!$reportable) {
            return $this->errorResponse('Không tìm thấy nội dung cần báo cáo', 404);
        }
        if ($request->user()->id === $reportable->created_by) {
            return $this->errorResponse('Bạn không thể báo cáo nội dung do chính mình tạo', 403);
        }


        $report = new Report([
            'reason' => $data['reason'],
            'message' => $data['message'],
            'reported_by' => $userId,
            'handled_by' => $reportable->created_by ?? null, // an toàn nếu không có created_by
        ]);

        $report->reportable()->associate($reportable);
        $report->save();

        return $this->successResponse($report, 'Báo cáo thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Report $report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $report)
    {
        //
    }
}
