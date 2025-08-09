<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Invoice;
use App\Models\Payment;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class VnpayController extends BaseApiController
{
    public function createPayment(Request $request, $transaction_code, $type = 'invoice')
    {
        $model = $type === 'invoice' ? Invoice::class : Payment::class;

        $invoice = $model::where('transaction_code', $transaction_code)->first();
        switch ($type) {
            case "invoice":
                $price = $invoice->total_price;
                $urlCallback = env("APP_URL_FRONT_END") . "/invoices/return/vnpay";
                break;
            default:
                $price = $invoice->invoices()->sum('total_price');
                $urlCallback = env("APP_URL_FRONT_END") . "/payments/return/vnpay";
                break;
        }
        if (!$invoice || !$invoice->isValid()) {
            return $this->errorResponse(null, 'Hóa đơn không tồn tại hoặc đã được xử lý', 404);
        }
        $createInvoice = PaymentService::createInvoiceVNPAY($price, $transaction_code, $urlCallback);
        $invoice->update([
            'payment_method' => 'vnpay'
        ]);
        $invoice['url_payment'] = $createInvoice['url_payment'];
        return $this->successResponse($invoice, 'Tạo liên kết thanh toán thành công');
    }

    public function paymentReturn(Request $request, $type = 'invoice')
    {
        $result = PaymentService::handleReturnVNPAY($request);
        $transaction_code = $result['transaction_code'] ?? null;
        $model = $type === 'invoice' ? Invoice::class : Payment::class;

        $invoice = $model::where('transaction_code', $transaction_code)->first();
        if (!$invoice || !$invoice->isValid()) {
            return $this->errorResponse(null, 'Hóa đơn không tồn tại', 404);
        }

        if ($result['success']) {
            // Xử lý thành công
            $invoice->update([
                'status' => 'paid',
                'payment_method' => 'vnpay',
            ]);
            return $this->successResponse($invoice, 'Thanh toán thành công');
        } else {
            // Xử lý thất bại
            $invoice->update([
                'status' => 'failed',
                'payment_method' => 'vnpay',
            ]);
            return $this->errorResponse(null, 'Thanh toán thất bại: ' . $result['message'], 400);
        }
    }
}
