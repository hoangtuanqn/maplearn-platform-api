<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

abstract class CardTopupService
{
    public static $messages = [
        1 => 'Thẻ thành công đúng mệnh giá',
        2 => 'Thẻ thành công sai mệnh giá',
        3 => 'Mã thẻ hoặc seri không đúng định dạng, vui lòng kiểm tra lại!',
        4 => 'Hệ thống bảo trì',
        99 => 'Gửi thẻ thành công, chờ xử lý',
        100 => 'Gửi thẻ thất bại - Có lý do đi kèm ở phần thông báo trả về',
    ];
    // Gửi thẻ cào qua cho đối tác
    public static function cardToPartner($cardData, $type = 'charging')
    {
        // $cardData sẽ nhận vô telco, code, serial, amount
        $telco = $cardData['telco'];
        $code = $cardData['code'];
        $serial = $cardData['serial'];
        $amount = $cardData['amount'];
        // dd($amount);
        $request_id = $type === 'charging' ? rand(1111111, time()) : $cardData['request_id'];
        $partner_id = env('CARD_PARTNER_ID');
        $partner_key = env('CARD_PARTNER_KEY');
        $partner_url = env('CARD_PARTNER_URL');
        $sign = md5($partner_key . $code . $serial);

        // Logic để gửi thẻ cào đến đối tác
        // Retry
        $response = Http::retry(3, 2000)->post($partner_url . '/chargingws/v2', [
            'telco' => $telco,
            'code' => $code,
            'serial' => $serial,
            'amount' => $amount,
            'request_id' => $request_id,
            'partner_id' => $partner_id,
            'sign' => $sign,
            'command' => $type
        ]);
        /**
         * Mã lỗi:
         *  1: Thẻ thành công đúng mệnh giá
         *  2: Thẻ thành công sai mệnh giá
         *  3: Thẻ lỗi
         *  4: Hệ thống bảo trì
         * 99: Thẻ chờ xử lý
         *  100: Gửi thẻ thất bại - Có lý do đi kèm ở phần thông báo trả về
         */
        $responseData = $response->json();
        $responseData['message'] = self::$messages[$responseData['status']] ?? 'Lỗi không xác định';
        return $responseData;
    }
}
