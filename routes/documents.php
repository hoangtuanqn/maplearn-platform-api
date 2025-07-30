<?php

use App\Http\Controllers\DocumentCategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentController;

Route::apiResource('documents', DocumentController::class)->middlewareFor(['store', 'update', 'destroy'], 'auth.jwt');
Route::post('/documents/{document}/download', [DocumentController::class, 'increaseDownload']);
Route::apiResource('category_documents', DocumentCategoryController::class)->middlewareFor(['store', 'update', 'destroy'], 'auth.jwt');

