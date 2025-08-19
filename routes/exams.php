<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExamAttemptController;
use App\Http\Controllers\ExamCategoryController;
use App\Http\Controllers\ExamPaperController;
use App\Http\Controllers\ExamQuestionController;

Route::apiResource('exam-categories', ExamCategoryController::class)->middlewareFor(['store', 'update', 'destroy'], 'auth.jwt');
Route::apiResource('exams', ExamPaperController::class)->middleware('auth.optional.jwt')->middlewareFor(['store', 'update', 'destroy'], 'auth.jwt');
Route::prefix('exams')->group(function () {
    // Route::apiResource('questions', ExamQuestionController::class)->middleware('auth.jwt');
    Route::get('/questions/{exam}', [ExamQuestionController::class, 'index'])->middleware('auth.jwt');
    // Url bắt đầu làm bài (lưu lại data)
    Route::post('/{exam}/start', [ExamPaperController::class, 'startExam'])->middleware('auth.jwt');
    // Url nộp bài
    Route::post('/{exam}/submit', [ExamPaperController::class, 'submitExam'])->middleware('auth.jwt');

    // Url lấy kết quả thi
    Route::get('/{exam}/results', [ExamPaperController::class, 'detailResultExam'])->middleware('auth.jwt');


    // Đánh dấu bài thi gian lận
    Route::post('/{exam}/detect-cheat', [ExamAttemptController::class, 'detectedCheat'])->middleware('auth.jwt');
});
