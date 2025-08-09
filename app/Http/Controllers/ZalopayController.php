<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Invoice;
use App\Models\Payment;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class ZalopayController extends BaseApiController
{
    public function createPayment(Request $request, $transaction_code, $type = 'invoice')
    {
        $model = $type === 'invoice' ? Invoice::class : Payment::class;

        $invoice = $model::where('transaction_code', $transaction_code)->first();
        if (!$invoice || !$invoice->isValid()) {
            return $this->errorResponse(null, 'Hóa đơn không tồn tại hoặc đã được xử lý', 404);
        }
        switch ($type) {
            case "invoice":
                $price = $invoice->total_price;
                $urlCallback = env("APP_URL_FRONT_END") . "/invoices/return/zalopay";
                break;
            default:
                $price = $invoice->invoices()->sum('total_price');
                $urlCallback = env("APP_URL_FRONT_END") . "/payments/return/zalopay";
                break;
        }


        $result = PaymentService::createInvoiceZaloPay($price, $invoice->transaction_code, $urlCallback);

        if (isset($result['url_payment'])) {
            $invoice->update([
                'payment_method' => 'zalopay'
            ]);
            $invoice['url_payment'] = $result['url_payment'];
            return $this->successResponse($invoice, 'Tạo liên kết thanh toán thành công');
        } else {
            return $this->errorResponse(null, $result['message'], 400);
        }
    }

    // Return zalo pay
    // Xử lý redirect từ ZaloPay về Merchant (Laravel style)
    public function paymentReturn(Request $request, $type = 'invoice')
    {
        $result = PaymentService::handleReturnZaloPay($request);
        $transaction_code = $result['transaction_code'] ?? null;
        $model = $type === 'invoice' ? Invoice::class : Payment::class;
        $invoice =  $model::where('transaction_code', $transaction_code)->first();

        if (!$invoice || !$invoice->isValid()) {
            return $this->errorResponse(null, 'Hóa đơn không tồn tại hoặc đã được xử lý', 404);
        }


        $invoice->update([
            'status' =>  $result['success'] == true ? 'paid' : 'failed',
            'payment_method' => 'zalopay',
        ]);

        if ($result['success'] == true) {
            return $this->successResponse($invoice, 'Thanh toán thành công');
        } else {
            return $this->errorResponse($invoice, 'Thanh toán thất bại', 400);
        }
    }
}
