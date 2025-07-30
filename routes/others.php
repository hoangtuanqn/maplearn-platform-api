<?php

use App\Http\Controllers\DocumentCategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\GradeLevelController;

Route::apiResource('grade-levels', GradeLevelController::class);
