<?php

namespace App\Observers;

use App\Models\CardTopup;
use App\Models\Invoice;

class CardTopupObserver
{
    public function updated(CardTopup $cardTopup): void
    {
        if ($cardTopup->status === 'success') {
            $invoice = Invoice::where('id', $cardTopup->invoice_id)->where('status', 'pending')->first();
            if ($invoice) {
                $remaining = $invoice->total_price - $cardTopup->amount;
                if ($remaining <= 0) {
                    $invoice->update(['status' => 'paid']);
                    if ($remaining < 0) {
                        // Tiền còn dư sẽ cộng vô tài khoản người dùng để khấu trừ cho lần sau
                        $surplus = abs($remaining);
                        $invoice->user()->increment('money', $surplus);
                    }
                } else {
                    $invoice->update(['total_price' => $remaining]);
                }
            }
        }
    }
}
