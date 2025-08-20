<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\ExamAttempt;
use App\Models\ExamPaper;
use Illuminate\Http\Request;

class ExamAttemptController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Display the specified resource.
     */
    public function show(ExamAttempt $examAttempt)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ExamAttempt $examAttempt) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExamAttempt $examAttempt)
    {
        //
    }

    // phát hiện gian lận
    public function detectedCheat(Request $request, ExamPaper $exam)
    {
        $user = $request->user();
        // Lấy bài thi đang có status in_process
        $examAttempt = $user->examAttempts()
            ->where('exam_paper_id', $exam->id)
            ->where('status', 'in_progress')
            ->first();

        if (!$examAttempt) {
            return $this->errorResponse([], "Không tìm thấy dữ liệu đang làm bài thi của thí sinh!");
        }

        // Phân tích các lần làm bài để phát hiện gian lận

        $examAttempt->increment('violation_count');

        // Nếu vượt quá ngưỡng cho phép tự động đánh dấu bài thi và score = 0
        if ($examAttempt->violation_count > $exam->max_violation_attempts) {
            // Update status = canceled
            $examAttempt->update([
                'status' => 'detected',
     
                'note' => 'Thí sinh gian lận trong quá trình thi cử. Bài thi đã bị hủy.',
                'score' => 0,
            ]);
        }

        return $this->successResponse($examAttempt, "Đã đánh dấu bài thi gian lận!");
    }
}
