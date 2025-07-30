<?php

use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentController;

Route::apiResource('comments', CommentController::class)->middlewareFor(['store', 'update', 'destroy'], 'auth.jwt');
