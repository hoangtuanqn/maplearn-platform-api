<?php

use App\Http\Controllers\CourseReviewController;
use App\Http\Controllers\DocumentCategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\GradeLevelController;
use App\Http\Controllers\ReportController;

Route::get("/grade-levels/courses", [GradeLevelController::class, 'getCoursesByGradeLevel'])->middleware('auth.optional.jwt');
Route::apiResource('grade-levels', GradeLevelController::class);
Route::apiResource('reports', ReportController::class)->middlewareFor(['store', 'update', 'destroy'], 'auth.jwt');

// Lấy đánh giá khóa học
Route::get('/course-reviews/{slug}', [CourseReviewController::class, 'show'])->middleware('auth.optional.jwt');

// Lấy danh sách đánh giá
Route::post('/course-reviews/{id}/vote', [CourseReviewController::class, 'vote'])->middleware('auth.jwt');
Route::get('/course-reviews/{slug}/ratings/distribution', [CourseReviewController::class, 'getRatingDistribution']);
