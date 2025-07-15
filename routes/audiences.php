<?php

use App\Http\Controllers\AudienceController;
use Illuminate\Support\Facades\Route;

Route::apiResource('audiences', AudienceController::class)->middlewareFor(['store', 'update', 'destroy'], 'auth.jwt');
