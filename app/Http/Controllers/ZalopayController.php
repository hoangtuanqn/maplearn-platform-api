<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ZalopayController extends BaseApiController
{
    public function createPayment(Request $request, $transaction_code)
    {
        $invoice = Invoice::where('transaction_code', $transaction_code)->where('status', 'pending')->where('due_date', '>', now())->first();
        if (!$invoice || !$invoice->isValid()) {
            return $this->errorResponse(null, 'Hóa đơn không tồn tại hoặc đã được xử lý', 404);
        }
        $app_id = env('ZALOPAY_APP_ID');
        $key1 = env('ZALOPAY_KEY1');
        $endpoint = env('ZALOPAY_ENDPOINT');

        $transId = $invoice->transaction_code . "_" . Str::random(4);
        $amount = $invoice->total_price;
        $app_user = $invoice->user_id;
        $embed_data = json_encode(["redirecturl" => env("APP_URL_FRONT_END") . "/invoices/return/zalopay"]);
        $items = json_encode(['']);

        $data = [
            "appid" => (int)$app_id,
            "appuser" => $app_user,
            "apptime" => round(microtime(true) * 1000), // milliseconds
            "amount" => $amount,
            "apptransid" => $transId,
            "embeddata" => $embed_data,
            "item" => $items,
            "description" => "Thanh toán đơn hàng #" . $transId,
            "bankcode" => "zalopayapp"
        ];

        // Tạo chữ ký
        $raw_data = $data["appid"] . "|" . $data["apptransid"] . "|" . $data["appuser"] . "|" . $data["amount"] . "|" . $data["apptime"] . "|" . $data["embeddata"] . "|" . $data["item"];
        $data["mac"] = hash_hmac("sha256", $raw_data, $key1);

        // Gửi request HTTP POST
        $response = Http::asForm()->post($endpoint, $data);

        $result = $response->json();

        if (isset($result['orderurl'])) {
            $invoice->update([
                'payment_method' => 'zalopay'
            ]);
            $invoice['url_payment'] = $result['orderurl'];

            // return redirect()->away($result['orderurl']);
            return $this->successResponse($invoice, 'Tạo liên kết thanh toán thành công');
        } else {
            return $this->errorResponse(null, 'Không thể tạo liên kết thanh toán', 400);
        }
    }

    // Return zalo pay
    // Xử lý redirect từ ZaloPay về Merchant (Laravel style)
    public function paymentReturn(Request $request)
    {
        $key2 = env('ZALOPAY_KEY2');

        $validated = $request->validate([
            'appid'          => 'required',
            'apptransid'     => 'required',
            'pmcid'          => 'required',
            'bankcode'       => 'nullable',
            'amount'         => 'required',
            'discountamount' => 'required',
            'status'         => 'required',
            'checksum'       => 'required',
        ]);

        $checksumData = implode('|', [
            $validated['appid'],
            $validated['apptransid'],
            $validated['pmcid'],
            $validated['bankcode'],
            $validated['amount'],
            $validated['discountamount'],
            $validated['status'],
        ]);

        $calculatedChecksum = hash_hmac('sha256', $checksumData, $key2);

        if ($calculatedChecksum !== $validated['checksum']) {
            return $this->errorResponse(null, 'Checksum không hợp lệ', 400);
        }

        $transaction_code = explode("_", $validated['apptransid'])[0];
        $invoice =  Invoice::where('transaction_code', $transaction_code)->first();
        if (!$invoice || !$invoice->isValid()) {
            return $this->errorResponse(null, 'Hóa đơn không tồn tại hoặc đã được xử lý', 404);
        }
        $invoice->update([
            'status' =>  $validated['status'] == 1 ? 'paid' : 'failed',
            'payment_method' => 'zalopay',
        ]);

        if ($validated['status'] == 1) {
            return $this->successResponse($invoice, 'Thanh toán thành công');
        } else {
            return $this->errorResponse($invoice, 'Thanh toán thất bại', 400);
        }
    }
}
