<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Invoice;
use Illuminate\Http\Request;

class VnpayController extends BaseApiController
{
    public function createPayment(Request $request, $transaction_code)
    {
        $invoice = Invoice::where('transaction_code', $transaction_code)->where('status', 'pending')->where('due_date', '>', now())->first();
        if (!$invoice || !$invoice->isValid()) {
            return $this->errorResponse(null, 'Hóa đơn không tồn tại hoặc đã được xử lý', 404);
        }
        $vnp_TmnCode = env('VNPAY_TMN_CODE');
        $vnp_HashSecret = env('VNPAY_HASH_SECRET');
        $vnp_Url = env('VNPAY_URL');
        $vnp_ReturnUrl = env("APP_URL_FRONT_END") . "/invoices/return/vnpay";

        $vnp_TxnRef = $invoice->transaction_code; //Mã giao dịch thanh toán tham chiếu của merchant
        $vnp_Amount = $invoice->total_price; // Số tiền thanh toán
        $vnp_Locale = 'vn'; //Ngôn ngữ chuyển hướng thanh toán
        $vnp_BankCode = ""; //Mã phương thức thanh toán
        $vnp_IpAddr = $request->ip(); //IP Khách hàng thanh toán
        $startTime = date("YmdHis");
        $expire = date('YmdHis', strtotime('+15 minutes', strtotime($startTime)));
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount * 100,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => $startTime,
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => "Thanh toan GD:" . $vnp_TxnRef,
            "vnp_OrderType" => "other",
            "vnp_ReturnUrl" => $vnp_ReturnUrl,
            "vnp_TxnRef" => $vnp_TxnRef,
            "vnp_ExpireDate" => $expire
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $invoice->update([
            'payment_method' => 'vnpay'
        ]);
        $invoice['url_payment'] = $vnp_Url;
        return $this->successResponse($invoice, 'Tạo liên kết thanh toán thành công');
    }

    public function paymentReturn(Request $request)
    {
        $vnp_HashSecret = env('VNPAY_HASH_SECRET');
        $inputData = array();
        $vnp_SecureHash = $request->vnp_SecureHash;
        foreach ($request->all() as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }


        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        $transaction_code = $inputData['vnp_TxnRef'] ?? null;
        if (!$transaction_code) {
            return $this->errorResponse(null, 'Mã giao dịch không hợp lệ', 400);
        }
        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

        $status = $inputData['vnp_ResponseCode'] ?? null;
        // dd($secureHash == $vnp_SecureHash);
        if ($secureHash == $vnp_SecureHash) {

            if ($status == '00') {
                // Xử lý thành công
                $invoice = Invoice::where('transaction_code', $transaction_code)->first();
                if (!$invoice || !$invoice->isValid()) {
                    return $this->errorResponse(null, 'Hóa đơn không tồn tại', 404);
                }
                $invoice->update([
                    'status' => 'paid',
                    'payment_method' => 'vnpay',
                ]);
                return $this->successResponse($invoice, 'Thanh toán thành công');
            } else {
                // Xử lý thất bại
                Invoice::where('transaction_code', $transaction_code)
                    ->update([
                        'status' => 'failed',
                        'payment_method' => 'vnpay',
                    ]);
                return $this->errorResponse(null, 'Thanh toán thất bại: ' . $status, 400);
            }
        } else {
            Invoice::where('transaction_code', $transaction_code)
                ->update([
                    'status' => 'failed',
                    'payment_method' => 'vnpay',
                ]);
            return $this->errorResponse(null, 'Mã bảo mật không hợp lệ', 400);
        }
    }
}
