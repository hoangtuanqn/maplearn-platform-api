<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GradeLevelController;
use Illuminate\Support\Facades\Route;

Route::get("/grade-levels/courses", [GradeLevelController::class, 'getCoursesByGradeLevel'])->middleware('auth.optional.jwt');
Route::apiResource('grade-levels', GradeLevelController::class);
Route::get("/admin/dashboard", [DashboardController::class, 'getDashboardData'])->middleware(['auth.jwt', 'check.role:admin']);
