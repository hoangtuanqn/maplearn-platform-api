<?php

use App\Http\Controllers\DocumentCategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\GradeLevelController;
use App\Http\Controllers\ReportController;

Route::apiResource('grade-levels', GradeLevelController::class);
Route::apiResource('reports', ReportController::class)->middlewareFor(['store', 'update', 'destroy'], 'auth.jwt');
