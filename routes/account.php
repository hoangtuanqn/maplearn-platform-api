<?php

use App\Http\Controllers\AccountController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::prefix('profile')->name('account.')->middleware('auth.jwt')->group(function () {
    Route::post('/update', [AccountController::class, 'update']);
});
