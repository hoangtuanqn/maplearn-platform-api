<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        return $this->successResponse($payment, 'Lấy thông tin thanh toán thành công!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        // Chỉ update status
        $data = $request->validate([
            'status' => 'required|in:pending,paid,canceled',
        ]);
        $payment->status = $data['status'];
        $payment->save();
        return $this->successResponse($payment, 'Cập nhật trạng thái thanh toán thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
