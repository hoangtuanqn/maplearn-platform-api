<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\CourseController;
use Illuminate\Support\Facades\Route;

Route::apiResource('courses', CourseController::class)->middlewareFor(['store', 'update', 'destroy'], 'auth.jwt');
