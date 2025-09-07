<?php

use App\Http\Controllers\CourseChapterController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseLessonController;
use App\Http\Controllers\LessonViewHistoryController;
use Illuminate\Support\Facades\Route;

// Lấy chương học theo slug
Route::apiResource('chapters', CourseChapterController::class)->middleware('auth.jwt')->middlewareFor(['store', 'update', 'destroy'], 'auth.jwt');
// Route::get('/chapters/{slug}', [CourseChapterController::class, 'show']);
// Route::post('/chapters/{slug}', [CourseChapterController::class, 'store'])->middleware('auth.jwt');
// Data được cắt gọn để gửi cho AI
Route::get('/courses/ai-data', [CourseController::class, 'aiData']);
Route::post('/courses/ai-data', [CourseController::class, 'aiDataByIds']);

// Recommended courses
Route::prefix("/courses")->middleware('auth.jwt')->group(function () {
    Route::get('/{course}/study/{lesson}', [CourseController::class, 'getLesson']);
    Route::get('/{slug}/study', [CourseController::class, 'detailCourse']);
});
Route::get('/courses/recommended', [CourseController::class, 'recommended']);
Route::apiResource('courses', CourseController::class)->middleware('auth.optional.jwt')->middlewareFor(['store', 'update', 'destroy'], 'auth.jwt');
Route::apiResource('lessons', CourseLessonController::class)->middleware('auth.jwt');

Route::apiResource('lesson-history', LessonViewHistoryController::class)->middleware('auth.jwt');
