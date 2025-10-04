<?php

use App\Http\Controllers\Admin\CourseController as AdminCourseController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\CourseChapterController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseLessonController;
use App\Http\Controllers\CourseReviewController;
use App\Http\Controllers\LessonViewHistoryController;
use App\Http\Controllers\StudentStatsController;
use Illuminate\Support\Facades\Route;

// Lấy chương học theo slug
Route::apiResource('chapters', CourseChapterController::class)->middleware('auth.optional.jwt')->middlewareFor(['store', 'update', 'destroy'], 'auth.jwt');

// Data được cắt gọn để gửi cho AI
Route::get('/courses/ai-data', [CourseController::class, 'aiData']);
Route::post('/courses/ai-data', [CourseController::class, 'aiDataByIds']);

// Bắt login
Route::prefix("/courses")->middleware('auth.jwt')->group(function () {
    Route::get('/{course}/study/{lesson}', [CourseController::class, 'getLesson']);
    Route::get('/{slug}/study', [CourseController::class, 'detailCourse']);

    // Trả thông tin thống kê số học sinh đăng ký trong 7 ngày gần nhất
    Route::get('/{course}/stats-enrollments', [CourseController::class, 'statsEnrollmentsLast7Days']);

    // get thông tin chứng chỉ sau khi hoàn thành khóa học
    Route::get('/{course}/certificate', [CourseController::class, 'getCertificateInfo']);

    // Admin: Lấy thông tin những người đăng ký khóa học
    Route::get('/{course}/enrollments', [CourseController::class, 'getRegistrations'])->middleware('check.role:admin,teacher');

    // gửi email khi hoàn thành khóa học
    Route::post('/{course}/send-completion-email', [LessonViewHistoryController::class, 'sendCourseCompletionEmail']);

    // demo tính năng hoàn thành khóa học
    Route::post('/{course}/complete-demo', [CourseController::class, 'completeDemoCourse']);
});
Route::prefix('courses')->group(function () {
    Route::post('/recommended', [CourseController::class, 'recommended']);
    Route::get('/{course}/reviews', [CourseReviewController::class, 'index']);
});
Route::apiResource('courses', CourseController::class)->middleware('auth.optional.jwt')->middlewareFor(['store', 'update', 'destroy'], 'auth.jwt');
Route::apiResource('lessons', CourseLessonController::class)->middleware('auth.jwt');

Route::apiResource('lesson-history', LessonViewHistoryController::class)->middleware('auth.jwt');

Route::get("/certificates/{certificate}/", [CertificateController::class, 'getInfoCertificate']);
Route::apiResource('courses-admin', AdminCourseController::class)->middleware(['auth.jwt', 'check.role:admin,teacher']);
Route::prefix('courses-admin')->middleware(['auth.jwt', 'check.role:admin,teacher'])->group(function () {
    Route::get('/{course}/student/{id}/stats', [StudentStatsController::class, 'getInfoStats']);
    /// get lịch sử học của học sinh bất kỳ
    Route::get('/{course}/student/{user}/histories', [LessonViewHistoryController::class, 'getHistoriesLearning']);
    // get tất cả học sinh của khóa học (ko phân trang)
    Route::get('/{course}/students', [AdminCourseController::class, 'getAllStudents']);
});
