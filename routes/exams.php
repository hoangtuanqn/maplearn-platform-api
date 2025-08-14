<?php

use App\Http\Controllers\DocumentCategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ExamCategoryController;
use App\Http\Controllers\ExamPaperController;

Route::apiResource('exam-categories', ExamCategoryController::class)->middlewareFor(['store', 'update', 'destroy'], 'auth.jwt');
Route::apiResource('exams', ExamPaperController::class)->middlewareFor(['store', 'update', 'destroy'], 'auth.jwt');
// Route::get('/documents/same-category/{slug}', [DocumentController::class, 'getSameCategoryDocuments']);
// Route::post('/documents/{document}/download', [DocumentController::class, 'increaseDownload']);
// Route::apiResource('category-documents', DocumentCategoryController::class)->middlewareFor(['store', 'update', 'destroy'], 'auth.jwt');
