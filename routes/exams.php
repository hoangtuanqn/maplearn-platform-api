<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExamAttemptController;
use App\Http\Controllers\ExamCategoryController;
use App\Http\Controllers\ExamPaperController;
use App\Http\Controllers\ExamQuestionController;

Route::apiResource('exam-categories', ExamCategoryController::class)->middlewareFor(['store', 'update', 'destroy'], 'auth.jwt');
Route::apiResource('exams', ExamPaperController::class)->middleware('auth.optional.jwt')->middlewareFor(['store', 'update', 'destroy'], 'auth.jwt');
Route::prefix('exams')->middleware('auth.jwt')->group(function () {
    // Lấy danh sách câu hỏi đề thi
    Route::get('/questions/{exam}', [ExamQuestionController::class, 'index']);

    // Url bắt đầu làm bài (lưu lại data)
    Route::post('/{exam}/start', [ExamPaperController::class, 'startExam']);
    // Url nộp bài
    Route::post('/{exam}/submit', [ExamPaperController::class, 'submitExam']);

    // Url lấy kết quả thi
    Route::get('/{exam}/results', [ExamPaperController::class, 'detailResultExam']);
    // Lấy kết quả thi dựa trên id attempts
    Route::get('/{exam}/{id?}/results', [ExamPaperController::class, 'detailResultExam']);


    // Đánh dấu bài thi gian lận
    Route::post('/{exam}/detect-cheat', [ExamAttemptController::class, 'detectedCheat']);

    // Lấy lịch sử làm bài thi
    Route::get("/{exam}/attempts", [ExamAttemptController::class, 'index']);

    // Kiểm tra xếp hạng của người dùng
    Route::get("/{exam}/check-ranking", [ExamAttemptController::class, 'checkUserRanking']);
});

// Ko cần login
Route::prefix('exams')->group(function () {
    // Bảng ranking (Xếp hạng)
    Route::get("/{exam}/ranking", [ExamAttemptController::class, 'ranking']);
});
