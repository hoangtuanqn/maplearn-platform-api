<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\OAuthController;
use App\Http\Controllers\Auth\ResetPasswordController;

Route::prefix('auth')->name('auth.')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/verify-2fa', [AuthController::class, 'verify2fa']);
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink']);
    Route::post('/reset-password', [ResetPasswordController::class, 'resetPassword']);

    // OAuth
    Route::get('/{provider}', [OAuthController::class, 'redirect']);
    Route::get('/{provider}/callback', [OAuthController::class, 'callback']);

    // Authenticated
    Route::middleware('auth.jwt')->group(function () {
        Route::post('/me', [AuthController::class, 'me']);
        Route::post('/refresh', [AuthController::class, 'refresh']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});
