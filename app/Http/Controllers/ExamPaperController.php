<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\ExamAttempt;
use App\Models\ExamPaper;
use App\Traits\AuthorizesOwnerOrAdmin;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use PhpParser\Node\Expr;
use Spatie\QueryBuilder\QueryBuilder;

class ExamPaperController extends BaseApiController
{
    use AuthorizesRequests, AuthorizesOwnerOrAdmin;
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

    public function startExam(Request $request, ExamPaper $exam)
    {
        $user = $request->user();
        if (!ExamAttempt::where('exam_paper_id', $exam->id)->where('user_id', $user->id)->where('status', 'in_progress')->exists()) {
            // Chưa có bài làm nào, tạo mới
            ExamAttempt::create([
                'exam_paper_id' => $exam->id,
                'user_id' => $user->id,
                'status' => 'in_progress',
                'details' => (['answers' => [], 'start' => now()->timestamp, 'questionActive' => 0]), // Khởi tạo chi tiết bài làm là mảng rỗng
                'started_at' => now(),
            ]);
        } else {
            return $this->errorResponse(null, 'Bạn đang trong quá trình làm bài thi này rồi!');
        }
    }

    // Xem chi tiết thông tin bài thi (bài thi cuối cùng, thi gần nhất)
    public function detailResultExam(Request $request, ExamPaper $exam)
    {
        $user = $request->user();
        $this->authorize('admin-teacher-owner', $exam);
        $exam['results'] = ExamAttempt::where('exam_paper_id', $exam->id)
            ->where('user_id', $user->id)
            ->whereIn('status', ['submitted', 'detected'])
            ->latest()
            ->first();
        return $this->successResponse($exam, 'Lấy thông tin bài thi thành công!');
    }

    /// Submit bài làm
    public function submitExam(Request $request, ExamPaper $exam)
    {
        // Validate input
        $data = $request->validate([
            'data' => 'required|array',
        ]);

        $attempt = ExamAttempt::where('exam_paper_id', $exam->id)
            ->where('user_id', $request->user()->id)
            ->where('status', 'in_progress')
            ->first();

        if (!$attempt) {
            return $this->errorResponse(null, 'Không tìm thấy dữ liệu bài thi!');
        }

        $answers = $data['data'];

        $paper = $exam->load('questions.answers');
        $questions = $paper->questions;

        $scores = 0; // Điểm của người dùng

        // Duyệt qua câu trả lời của user
        foreach ($answers['answers'] as $key => $value) {
            $question = $questions[$key - 1] ?? null;
            if (!$question) {
                continue;
            }

            $isCorrect = false;

            switch ($question->type) {
                case "single_choice":
                case "numeric_input":
                case "true_false":
                    // $value có thể là mảng -> lấy phần tử đầu tiên
                    $userAnswer = is_array($value) ? $value[0] : $value;
                    $isCheck = $question->answers
                        ->where('content', $userAnswer)
                        ->where('is_correct', 1)
                        ->first();

                    if ($isCheck) {
                        $isCorrect = true;
                        $scores += $question->marks ?? 0;
                    }

                    $answers['answers'][$key] = [
                        'value' => $userAnswer,
                        'is_correct' => $isCorrect,
                    ];
                    break;

                case "multiple_choice":
                    $answersInCorrect = $question->answers->where('is_correct', 1);
                    if (is_array($value) && count($value) === count($answersInCorrect)) {
                        $allCorrect = true;
                        foreach ($answersInCorrect as $answerInCorrect) {
                            if (!in_array($answerInCorrect->content, $value)) {
                                $allCorrect = false;
                                break;
                            }
                        }
                        if ($allCorrect) {
                            $isCorrect = true;
                            $scores += $question->marks ?? 0;
                        }
                    }

                    $answers['answers'][$key] = [
                        'value' => $value,
                        'is_correct' => $isCorrect,
                    ];
                    break;

                case "drag_drop":
                    $answersInCorrect = $question->answers->where('is_correct', 1);
                    if (is_array($value) && count($value) === count($answersInCorrect)) {
                        $i = 0;
                        $allCorrect = true;
                        foreach ($answersInCorrect as $answerInCorrect) {
                            if ($answerInCorrect->content != $value[$i++]) {
                                $allCorrect = false;
                                break;
                            }
                        }
                        if ($allCorrect) {
                            $isCorrect = true;
                            $scores += $question->marks ?? 0;
                        }
                    }

                    $answers['answers'][$key] = [
                        'value' => $value,
                        'is_correct' => $isCorrect,
                    ];
                    break;
            }
        }
        // dd($answers);
        // bỏ key không cần thiết
        unset($answers['questionActive']);

        // Cập nhật attempt
        $attempt->status = 'submitted';
        $attempt->score = $scores;
        $attempt->details = $answers; // lưu JSON chuẩn
        $attempt->save();

        return $this->successResponse([
            'scores' => $scores,
        ], 'Bài làm đã được nộp thành công');
    }
}
