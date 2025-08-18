<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\ExamPaper;
use App\Models\ExamQuestion;
use Illuminate\Http\Request;

class ExamQuestionController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, ExamPaper $exam)
    {
        // Lấy đề thi + answer
        $exam->load('questions.answers');
        return $this->successResponse($exam);
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
    public function show(ExamQuestion $question) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ExamQuestion $question)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExamQuestion $question)
    {
        //
    }

    /// Submit bài làm
    public function submitExam(Request $request, ExamPaper $exam)
    {
        // Validate input
        $data = $request->validate([
            'slug' => 'required|string',
            'data' => 'required|array',
        ]);

        $slug = $data['slug'];
        $answers = $data['data'];
        $paper = $exam->with('questions.answers')->firstOrFail();
        $questions = $paper->questions;

        $scores = 0; // Điểm của người dùng
        // dd($questions->toArray());
        // Câu trả lời của người dùng
        foreach ($answers['answers'] as $key => $value) {
            $question = $questions[$key - 1] ?? []; // Lấy câu hỏi theo key hiện tại
            // dd($question);
            // Dạng chọn 1 đáp án đúng
            switch ($question->type) {
                case "single_choice":
                case "numeric_input":
                case "true_false":
                    // $value là ở dạng mảng
                    $isCheck = $question->answers->where('content', $value[0])->where('is_correct', 1)->first();
                    if ($isCheck) {
                        $scores += $question->marks ?? 0;
                    }
                    break;
                case "multiple_choice":
                    $answersInCorrect = $question->answers->where('is_correct', 1);
                    if (count($value) === count($answersInCorrect)) {
                        foreach ($answersInCorrect as $answerInCorrect) {
                            // Chỉ  cần có 1 cái sai thì xem như sai hết

                            if (array_search($answerInCorrect->content, $value) === false) {
                                echo $answerInCorrect->content;
                                break 2;
                            }
                        }
                        $scores +=  $question->marks ?? 0;
                    }
                    break;
                case "drag_drop":
                    //  drag_drop phải theo đúng thứ tự
                    $answersInCorrect = $question->answers->where('is_correct', 1);
                    if (count($value) === count($answersInCorrect)) {
                        $i = 0;
                        foreach ($answersInCorrect as $answerInCorrect) {

                            if ($answerInCorrect->content != $value[$i++]) {
                                break 2;
                            }
                        }
                        $scores +=  $question->marks ?? 0;
                    }
                    break;
            }
        }

        return $this->successResponse([
            'scores' => $scores,
        ], 'Bài làm đã được nộp thành công');
    }
}
