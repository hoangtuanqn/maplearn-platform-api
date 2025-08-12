<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Services\PaymentService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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
            'payment_method' => 'required|string|in:transfer,vnpay,momo,zalopay',
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


        $payment->load('invoices');

        $total = $payment->invoices()->sum('total_price');
        // // Trừ số tiền đang có trong tài khoản
        // if ($user->money > 0) {
        //     $total = max(0, $total - $user->money);
        //     $payment->total_price = $total;

        //     // Nếu số tiền cuối = 0 thì có nghĩa là đã trả hết
        //     if ($total == 0) {
        //         $payment->status = 'paid';
        //     }
        //     $payment->save();
        // }



        switch ($request->payment_method) {
            case 'vnpay':
                $result = PaymentService::createInvoiceVNPAY($total, $payment->transaction_code, env("APP_URL_FRONT_END") . "/payments/return/vnpay");
                break;
            case 'momo':
                $result = PaymentService::createInvoiceMOMO($total, $payment->transaction_code, env("APP_URL_FRONT_END") . "/payments/return/momo");
                break;
            case 'zalopay':
                $result   = PaymentService::createInvoiceZALOPAY($total, $payment->transaction_code, env("APP_URL_FRONT_END") . "/payments/return/zalopay");
                break;
                // default:
                //     return $this->errorResponse(null, 'Phương thức thanh toán không hợp lệ', 400);
        }
        // Trả về URL THANH TOÁN
        $payment['url_payment'] = $result['url_payment'] ?? null;
        return $this->successResponse($payment, 'Tạo payment thành công', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {

        // Hiển thị payment gồm nhiều invoice bên trong
        $payment->load([
            'invoices.items.course'
        ]);
        return $this->successResponse($payment, 'Lấy dữ liệu payments thành công', 200);
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
