<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GradeLevelController;

Route::get("/grade-levels/courses", [GradeLevelController::class, 'getCoursesByGradeLevel'])->middleware('auth.optional.jwt');
Route::apiResource('grade-levels', GradeLevelController::class);
