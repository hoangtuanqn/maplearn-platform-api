<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\ExamAttempt;
use App\Models\UserWrongQuestion;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class UserWrongQuestionController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     */
    // Lấy danh sách các câu hỏi đã làm sai
    public function index(Request $request)
    {
        $limit = min((int)($request->limit ?? 10), 100);
        $user = $request->user();

        $examAttempt = ExamAttempt::where('user_id', $user->id)
            ->where('exam_paper_id', 39)
            ->latest()
            ->first();

        $studentAnswer = $examAttempt ? $examAttempt->details['answers'] : [];

        $questionsWrong = QueryBuilder::for(UserWrongQuestion::class)
            ->where('user_id', $user->id)
            ->with([
                'question' => function ($query) {
                    $query->select('id', 'exam_paper_id', 'type', 'explanation', 'content')
                        ->with([
                            'examPaper' => function ($query) {
                                $query->select('id', 'title', 'subject_id', 'difficulty')
                                    ->with('subject:id,name');
                            },
                            'answersCorrect', // quan hệ đáp án đúng
                            'answers'
                        ]);
                }
            ])
            ->orderBy('last_wrong_at', 'desc')
            ->paginate($limit);

        // ✅ Thêm your_choice thủ công
        $questionsWrong->getCollection()->transform(function ($item) use ($studentAnswer) {
            $item->question->your_choice = $studentAnswer[$item->question->id]['value'] ?? null;
            return $item;
        });

        return $this->successResponse($questionsWrong, "Lấy danh sách câu hỏi sai thành công");
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
    public function show(UserWrongQuestion $userWrongQuestion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserWrongQuestion $userWrongQuestion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserWrongQuestion $userWrongQuestion)
    {
        //
    }
}
