<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Middleware\AuthenticateJwt;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::prefix('auth')->name('auth.')->middleware(['authJWT'])->group(function () {
        Route::post('/refresh', [AuthController::class, 'refresh'])->name('refresh');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });

    Route::middleware(['authJWT'])->group(function () {
        Route::prefix('auth')->name('auth.')->group(function () {
            Route::post('/refresh', [AuthController::class, 'refresh'])->name('refresh');
            Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        });
    });
    Route::apiResource('posts', PostController::class)->middlewareFor(['store', 'update', 'destroy'], 'authJWT');
});
