<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentController;

Route::apiResource('documents', DocumentController::class)->middlewareFor(['store', 'update', 'destroy'], 'auth.jwt');
Route::post('/documents/{document}/view', [DocumentController::class, 'increaseView']);
