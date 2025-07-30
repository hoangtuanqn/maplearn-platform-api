<?php

use App\Http\Controllers\SubjectController;
use Illuminate\Support\Facades\Route;

Route::apiResource('subjects', SubjectController::class)->middlewareFor(['store', 'update', 'destroy'], 'auth.jwt');
