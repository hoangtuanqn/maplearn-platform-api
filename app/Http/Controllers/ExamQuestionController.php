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
}
