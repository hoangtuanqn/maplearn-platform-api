<?php

use App\Http\Controllers\DocumentCategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ExamCategoryController;
use App\Http\Controllers\ExamPaperController;
use App\Http\Controllers\ExamQuestionController;

Route::apiResource('exam-categories', ExamCategoryController::class)->middlewareFor(['store', 'update', 'destroy'], 'auth.jwt');
Route::apiResource('exams', ExamPaperController::class)->middlewareFor(['store', 'update', 'destroy'], 'auth.jwt');
Route::prefix('exams')->group(function () {
    // Route::apiResource('questions', ExamQuestionController::class)->middleware('auth.jwt');
    Route::get('questions/{exam}', [ExamQuestionController::class, 'index'])->middleware('auth.jwt');
});
