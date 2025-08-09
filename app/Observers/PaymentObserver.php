<?php

namespace App\Observers;

use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Support\Facades\Log;

class PaymentObserver
{

    public function creating(Payment $paymment)
    {
        $paymment->transaction_code = strtoupper(uniqid()); // Tạo mã giao dịch duy nhất
        $paymment->status = 'pending'; // Mặc định trạng thái là 'pending'
    }

    /**
     * Handle the Payment "created" event.
     */
    public function created(Payment $payment): void
    {
        //
    }

    /**
     * Handle the Payment "updated" event.
     */
    public function updated(Payment $payment): void
    {
        switch ($payment->status) {

            case "paid":
                foreach ($payment->invoices as $invoice) {
                    $invoice->update([
                        'status' => 'paid',
                        'paid_at' => now(),
                        'payment_method' => $payment->payment_method,
                    ]);
                }
                break;
            case "failed":
                foreach ($payment->invoices as $invoice) {
                    $invoice->update([
                        'status' => 'failed',
                        'payment_method' => $payment->payment_method,
                    ]);
                }
                break;
        }
    }

    // Xử lý trước khi xóa
    public function deleting(Payment $payment): void
    {
        Invoice::where('payment_id', $payment->id)->update(['payment_id' => null]);
    }

    /**
     * Handle the Payment "deleted" event.
     */
    public function deleted(Payment $payment): void
    {
        //
    }

    /**
     * Handle the Payment "restored" event.
     */
    public function restored(Payment $payment): void
    {
        //
    }

    /**
     * Handle the Payment "force deleted" event.
     */
    public function forceDeleted(Payment $payment): void
    {
        //
    }
}
