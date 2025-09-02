<?php

use App\Http\Controllers\CourseChapterController;
use App\Http\Controllers\CourseController;
use Illuminate\Support\Facades\Route;

// Lấy chương học theo slug
Route::get('/chapters/{slug}', [CourseChapterController::class, 'show']);

// Data được cắt gọn để gửi cho AI
Route::get('/courses/ai-data', [CourseController::class, 'aiData']);
Route::post('/courses/ai-data', [CourseController::class, 'aiDataByIds']);

// Recommended courses
Route::get('/courses/recommended', [CourseController::class, 'recommended']);
Route::prefix("/courses")->middleware('auth.jwt')->group(function () {
    Route::get('/{slug}/study', [CourseController::class, 'detailCourse']);
});
Route::apiResource('courses', CourseController::class)->middleware('auth.optional.jwt')->middlewareFor(['store', 'update', 'destroy'], 'auth.jwt');
