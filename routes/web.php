<?php

use App\Http\Controllers\Auth\FacebookController;
use App\Http\Controllers\Auth\GoogleController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::get('/google', [GoogleController::class, 'redirectToGoogle']);
    Route::get('/google/callback', [GoogleController::class, 'handleGoogleCallback']);
    Route::get('/facebook', [FacebookController::class, 'redirectToFacebook']);
    Route::get('/facebook/callback', [FacebookController::class, 'handleFacebookCallback']);
});
