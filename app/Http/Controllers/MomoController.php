<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class MomoController extends BaseApiController
{
    //
    public function createPayment(Request $request, $transaction_code)
    {
        $invoice = Invoice::where('transaction_code', $transaction_code)->where('status', 'pending')->where('due_date', '>', now())->first();
        if (!$invoice || !$invoice->isValid()) {
            return $this->errorResponse(null, 'Hóa đơn không tồn tại hoặc đã được xử lý', 404);
        }
        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";

        $partnerCode = env("MOMO_PARTNER_CODE");
        $accessKey = env("MOMO_ACCESS_KEY");
        $secretKey = env("MOMO_SECRET_KEY");
        $orderInfo = "Thanh toán qua MoMo";
        $amount =  $invoice->total_price;
        $orderId = $invoice->transaction_code . "_" . Str::random(4);
        $requestId = $orderId . time() . rand(1, 10000);
        $requestType = "payWithMethod";
        $returnUrl =  env("APP_URL_FRONT_END") . "/invoices/return/momo";
        $notifyurl =  env("APP_URL_FRONT_END") . "/invoices/notify/momo";

        // Encode extraData đúng chuẩn base64
        $extraData = base64_encode(json_encode(["merchantName" => "MoMo Partner"]));

        // Tạo chữ ký theo đúng định dạng MoMo yêu cầu
        $rawHash = "accessKey=$accessKey&amount=$amount&extraData=$extraData&ipnUrl=$notifyurl&orderId=$orderId&orderInfo=$orderInfo&partnerCode=$partnerCode&redirectUrl=$returnUrl&requestId=$requestId&requestType=$requestType";
        $signature = hash_hmac("sha256", $rawHash, $secretKey);

        // Dữ liệu gửi đi
        $data = [
            'partnerCode' => $partnerCode,
            'partnerName' => 'Mapstudy.edu.vn - Định vị tri thức - dẫn lối tư duy',
            'storeId' => $partnerCode . '_1',
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $returnUrl,
            'ipnUrl' => $notifyurl,
            'lang' => 'vi',
            'requestType' => $requestType,
            'autoCapture' => true,
            'extraData' => $extraData,
            'signature' => $signature,
            'orderGroupId' => ''
        ];

        $response = Http::post($endpoint, $data);
        $jsonResult = json_decode($response->getBody(), true);
        if (isset($jsonResult['payUrl'])) {
            $invoice->update([
                'payment_method' => 'momo'
            ]);
            $invoice['url_payment'] = $jsonResult['payUrl'] ?? null;
            return $this->successResponse($invoice, 'Tạo liên kết thanh toán thành công');
        }
        return $this->errorResponse(null, 'Không tạo được URL thanh toán MoMo');

        // return $this->errorResponse(null, 'Không tạo được URL thanh toán MoMo', 400);
    }

    public function handleReturn(Request $request)
    {
        $accessKey = env("MOMO_ACCESS_KEY");
        $secretKey = env("MOMO_SECRET_KEY");

        // Lấy tất cả dữ liệu từ MoMo gửi về qua query string
        $data = $request->only([
            'partnerCode',
            'orderId',
            'requestId',
            'amount',
            'orderInfo',
            'orderType',
            'transId',
            'resultCode',
            'message',
            'payType',
            'responseTime',
            'extraData',
            'signature'
        ]);

        // Tạo rawHash theo đúng thứ tự MoMo yêu cầu
        $rawHash = "accessKey={$accessKey}&amount={$data['amount']}&extraData={$data['extraData']}&message={$data['message']}&orderId={$data['orderId']}&orderInfo={$data['orderInfo']}&orderType={$data['orderType']}&partnerCode={$data['partnerCode']}&payType={$data['payType']}&requestId={$data['requestId']}&responseTime={$data['responseTime']}&resultCode={$data['resultCode']}&transId={$data['transId']}";

        // Tính lại chữ ký
        $calculatedSignature = hash_hmac("sha256", $rawHash, $secretKey);

        // So sánh chữ ký
        if ($data['signature'] !== $calculatedSignature) {
            return $this->errorResponse(null, 'Chữ ký không hợp lệ. Dữ liệu có thể đã bị thay đổi.', 400);
        }

        // Kiểm tra trạng thái giao dịch
        $transaction_code = explode("_", $data['orderId'])[0];
        $invoice = Invoice::where('transaction_code', $transaction_code)->first();
        if (!$invoice || !$invoice->isValid()) {
            return $this->errorResponse(null, 'Hóa đơn không tồn tại hoặc đã được xử lý', 404);
        }
        if ($data['resultCode'] == '0') {
            $invoice->update([
                'status' => 'paid',
                'payment_method' => 'momo',
            ]);
            return $this->successResponse($data, 'Thanh toán thành công!');
        } else {
            $invoice->update([
                'status' => 'failed',
                'payment_method' => 'momo',
            ]);
            return $this->errorResponse(null, 'Thanh toán thất bại!', 400);
        }
    }
}
