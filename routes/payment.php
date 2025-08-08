<?php
// routes/web.php

use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\MomoController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VnpayController;
use App\Http\Controllers\ZalopayController;

Route::prefix('payment')->group(function () {
    Route::post('/{invoice}', [InvoiceController::class, 'checkInvoice']);
    Route::prefix('vnpay')->middleware('auth.jwt')->group(function () {
        // Tạo payment
        Route::post('/', [PaymentController::class, 'store']);
        // Tạo hóa đơn bên VNPAY
        Route::get('/create/{transaction_code}', [VnpayController::class, 'createPayment']);
    });
    Route::prefix('momo')->group(function () {
        // Tạo payment
        // Route::post('/', [PaymentController::class, 'store']);
        // Tạo hóa đơn bên MoMo
        Route::get('/create/{transaction_code}', [MomoController::class, 'createPayment']);
    });

    Route::prefix('zalopay')->group(function () {
        // Tạo payment
        // Route::post('/', [PaymentController::class, 'store']);
        // Tạo hóa đơn bên Zalopay
        Route::get('/create/{transaction_code}', [ZalopayController::class, 'createPayment']);
    });
    // Ko cần xác thực người dùng
    Route::get('/momo/return', [MomoController::class, 'handleReturn'])->name('payment.momo.return');
    Route::get('/vnpay/return', [VnpayController::class, 'paymentReturn'])->name('payment.vnpay.return');
    Route::get('/zalopay/return', [ZalopayController::class, 'paymentReturn'])->name('payment.zalopay.return');
});
