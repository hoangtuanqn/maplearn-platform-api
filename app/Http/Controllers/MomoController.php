<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Invoice;
use App\Models\Payment;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class MomoController extends BaseApiController
{
    //
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
                $urlCallback = env("APP_URL_FRONT_END") . "/invoices/return/momo";
                break;
            default:
                $price = $invoice->invoices()->sum('total_price');
                $urlCallback = env("APP_URL_FRONT_END") . "/payments/return/momo";
                break;
        }

        $result = PaymentService::createInvoiceMomo($price, $invoice->transaction_code, $urlCallback);
        if (!$result['success']) {
            return $this->errorResponse(null, $result['message'], 400);
        }

        if (isset($result['url_payment'])) {
            $invoice->update([
                'payment_method' => 'momo'
            ]);
            $invoice['url_payment'] = $result['url_payment'] ?? null;
            return $this->successResponse($invoice, 'Tạo liên kết thanh toán thành công');
        }
        return $this->errorResponse(null, $result['message']);

        // return $this->errorResponse(null, 'Không tạo được URL thanh toán MoMo', 400);
    }

    public function handleReturn(Request $request, $type = 'invoice')
    {
        $result = PaymentService::handleReturnMomo($request);
        $transaction = $result['transaction_code'];

        $model = $type === 'invoice' ? Invoice::class : Payment::class;
        $invoice = $model::where('transaction_code', $transaction)->first();
        if (!$invoice || ! $invoice->isValid()) {
            return $this->errorResponse(null, 'Hóa đơn không tồn tại hoặc đã được xử lý', 404);
        }

        if ($result['success']) {
            $invoice->update([
                'status' => 'paid',
                'payment_method' => 'momo',
            ]);
            return $this->successResponse($result, 'Thanh toán thành công!');
        } else {
            $invoice->update([
                'status' => 'failed',
                'payment_method' => 'momo',
            ]);
            return $this->errorResponse(null, $result['message'], 400);
        }
    }
}
