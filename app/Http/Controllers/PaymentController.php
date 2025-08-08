<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;

class PaymentController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Người dùng truyển lên 1 mảng ids invoice
        $request->validate([
            'invoice_ids' => 'required|array',
            'invoice_ids.*' => 'exists:invoices,id',
            'payment_method' => 'required|string|in:transfer,vnpay',
        ]);

        $user = Auth::user();
        $invoiceIds = $request->invoice_ids;
        // Check tất cả bắt buộc invoice này phải của user đó
        foreach ($invoiceIds as $invoiceId) {
            $invoice = Invoice::findOrFail($invoiceId);
            if ($invoice->user_id !== $user->id) {
                return $this->errorResponse(null, 'Phát hiện có hóa đơn không phải của bạn', 403);
            }
        }
        // Nếu người dùng này đã có payment từ trước thì xóa nó đi
        Payment::where('user_id', $user->id)->delete();


        // Tạo payment cho các invoice
        $payment = Payment::create([
            'user_id' => $user->id,
            'payment_method' => $request->payment_method,
            'status' => 'pending'
        ]);

        // Gán payment_id cho các invoice
        Invoice::whereIn('id', $invoiceIds)->update(['payment_id' => $payment->id]);

        return $this->successResponse($payment, 'Tạo payment thành công', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
