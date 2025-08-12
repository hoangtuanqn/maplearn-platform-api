<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\CardTopup;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CardTopupController extends BaseApiController
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
        // Dữ liệu gửi lên trông như này:
        // {"cards":[{"telco":"GATE","amount":"200000","serial":"23213123","code":"23232323"},{"telco":"VINAPHONE","amount":"50000","serial":"2323","code":"2321323"}]}
        $validated = $request->validate([
            'cards' => 'required|array|min:1',
            'cards.*.telco' => 'required|string|max:50',
            'cards.*.amount' => 'required|integer|min:1000',
            'cards.*.serial' => 'required|string|max:100',
            'cards.*.code' => 'required|string|max:100',
        ]);
        $user = $request->user();
        return $this->successResponse($validated, "Chức năng nạp thẻ cào hiện đang tạm thời bị vô hiệu hóa. Vui lòng thử lại sau!", 503);
        // DB::transaction(function () use ($validated, $user) {
        //     // 1️⃣ Tạo hóa đơn
        //     $invoice = Invoice::create([
        //         'user_id' => $user->id,
        //         'total_amount' => array_sum(array_column($validated['cards'], 'amount')),
        //         'status' => 'pending',
        //     ]);

        //     // 2️⃣ Lưu các thẻ cào
        //     foreach ($validated['cards'] as $card) {
        //         CardTopup::create([
        //             'invoice_id' => $invoice->id,
        //             'network' => $card['telco'],
        //             'amount' => $card['amount'],
        //             'serial' => $card['serial'],
        //             'code' => $card['code'],
        //             'status' => 'pending',
        //         ]);
        //     }
        // });
        // return $this->successResponse($invoice, "Đã gửi thẻ thành công!");
    }

    /**
     * Display the specified resource.
     */
    public function show(CardTopup $cardTopup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CardTopup $cardTopup)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CardTopup $cardTopup)
    {
        //
    }
}
