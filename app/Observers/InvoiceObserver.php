<?php

namespace App\Observers;

use App\Models\Invoice;

class InvoiceObserver
{
    public function creating(Invoice $post)
    {
        // Due date là 3 ngày kể từ lúc tạo
        if (empty($post->due_date)) {
            $post->due_date = now()->addDays(3);
        }
        $post->transaction_code = strtoupper(uniqid()); // Tạo mã giao dịch duy nhất
        $post->status = 'pending'; // Mặc định trạng thái là 'pending'
    }
}
