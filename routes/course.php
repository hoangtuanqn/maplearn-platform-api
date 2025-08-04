<?php

use App\Http\Controllers\CourseChapterController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseUserFavoriteController;
use Illuminate\Support\Facades\Route;

// Thêm khóa học và danh sách yêu thích
Route::middleware('auth.jwt')->prefix('courses')->group(function () {
    Route::get('/favorites', [CourseUserFavoriteController::class, 'index']);
    Route::post('/{courseId}/favorite', [CourseUserFavoriteController::class, 'store']);
    Route::delete('/{courseId}/favorite', [CourseUserFavoriteController::class, 'destroy']);
    Route::get('/{courseId}/favorite', [CourseUserFavoriteController::class, 'isFavorite']);
});
// Lấy chương học theo slug
Route::get('/chapters/{slug}', [CourseChapterController::class, 'show']);
Route::apiResource('courses', CourseController::class)->middleware('auth.optional.jwt')->middlewareFor(['store', 'update', 'destroy'], 'auth.jwt');
