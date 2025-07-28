<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::prefix('profile')->name('account.')->group(function () {
    Route::post('/update', [AccountController::class, 'register']);
});
