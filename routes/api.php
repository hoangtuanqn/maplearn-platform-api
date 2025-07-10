<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\OAuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    Route::prefix('auth')->name('auth.')->group(function () {
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/verify-2fa', [AuthController::class, 'verify2fa']);

        Route::middleware(['auth.jwt'])->group(function () {
            // Lấy thông tin người dùng
            Route::post('/me', [AuthController::class, 'me']);
            // Refresh token khi access token hết hạn
            Route::post('/refresh', [AuthController::class, 'refresh']);
            Route::post('/logout', [AuthController::class, 'logout']);
        });
    });
    // Có đăng nhập là vào được
    Route::middleware(['auth.jwt'])->group(function () {
        Route::prefix('auth')->name('auth.')->group(function () {
            Route::post('/refresh', [AuthController::class, 'refresh']);
            Route::post('/logout', [AuthController::class, 'logout']);
        });
    });

    // APi Resources
    Route::apiResource('tags', TagController::class)->middlewareFor(['store', 'update', 'destroy'], 'auth.jwt');
    Route::apiResource('posts', PostController::class)->middlewareFor(['store', 'update', 'destroy'], 'auth.jwt');


    // Có đăng nhập + Có quyền Teacher, Admin
    Route::middleware(['auth.jwt', 'check.role'])->group(function () {});
    Route::get('/auth/{provider}', [OAuthController::class, 'redirect']);
    Route::get('/auth/{provider}/callback', [OAuthController::class, 'callback']);
});
