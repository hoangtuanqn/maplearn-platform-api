<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\OAuthController;
use App\Http\Controllers\Auth\ResetPasswordController;

Route::prefix('auth')->name('auth.')->group(function () {
    Route::post('/verify-email', [AuthController::class, 'verifyEmail']); // Xác minh email
    Route::post('/resend-verify-email', [AuthController::class, 'resendVerification'])->middleware('throttle:2,5'); // Gửi lại email xác minh, 5 phút 2 lần
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/verify-2fa', [AuthController::class, 'verify2fa']);
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink']);
    Route::post('/reset-password', [ResetPasswordController::class, 'resetPassword']);
    Route::post('/check-token-reset-password', [ResetPasswordController::class, 'checkToken']);

    // OAuth
    Route::get('/{provider}', [OAuthController::class, 'redirect'])->middleware('web');
    Route::get('/{provider}/callback', [OAuthController::class, 'callback']);

    // Authenticated
    Route::middleware('auth.jwt')->group(function () {
        Route::post('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });
    Route::post('/refresh', [AuthController::class, 'refresh']);
});
