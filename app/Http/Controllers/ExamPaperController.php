<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\ExamPaper;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class ExamPaperController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $limit = min((int)($request->limit ?? 20), 100); // Giới hạn tối đa 100 items

        $posts = QueryBuilder::for(ExamPaper::class)
            ->where('status', true)
            ->orderByDesc('id')
            ->paginate($limit);

        return $this->successResponse($posts, 'Lấy danh sách đề thi thành công!');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ExamPaper $exam)
    {
        return $this->successResponse($exam, 'Lấy thông tin đề thi thành công!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ExamPaper $exam)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExamPaper $exam)
    {
        //
    }
}
