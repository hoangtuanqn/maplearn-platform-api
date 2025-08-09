<?php
// routes/web.php

use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\MomoController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VnpayController;
use App\Http\Controllers\ZalopayController;
use App\Models\Payment;

Route::apiResource('/payments', PaymentController::class)->middleware('auth.jwt');
Route::prefix('payment')->group(function () {

    Route::middleware(('auth.jwt'))->group(function () {
        // Route::post('/{invoice}', [InvoiceController::class, 'checkInvoice']);
        // Tạo hóa đơn bên VNPAY
        Route::prefix('vnpay')->group(function () {
            Route::get('/create/{transaction_code}/{type?}', [VnpayController::class, 'createPayment']);
        });
        // Tạo hóa đơn bên MoMo
        Route::prefix('momo')->group(function () {
            Route::get('/create/{transaction_code}/{type?}', [MomoController::class, 'createPayment']);
        });
        // Tạo hóa đơn bên Zalopay
        Route::prefix('zalopay')->group(function () {
            Route::get('/create/{transaction_code}/{type?}', [ZalopayController::class, 'createPayment']);
        });
    });
    // Ko cần xác thực người dùng
    Route::get('/momo/return/{type?}', [MomoController::class, 'handleReturn']);
    Route::get('/vnpay/return/{type?}', [VnpayController::class, 'paymentReturn']);
    Route::get('/zalopay/return/{type?}', [ZalopayController::class, 'paymentReturn']);

    // Route::get("/test", function () {
    //     // return response()->json(['message' => 'Test route']);
    //     return response()->json(Payment::where('transaction_code', '6897C498D3026')->first()->update([
    //         'status' => 'paid',
    //     ]));
    // });
});
