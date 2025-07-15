<?php

use App\Http\Controllers\CourseCategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentController;

Route::apiResource('course-categories', CourseCategoryController::class)->middlewareFor(['store', 'update', 'destroy'], 'auth.jwt');
