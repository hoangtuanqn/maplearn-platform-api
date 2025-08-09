<?php

namespace App\Observers;

use App\Mail\InvoicePaidMail;
use App\Models\Invoice;
use Illuminate\Support\Facades\Mail;

class InvoiceObserver
{
    public function creating(Invoice $invoice)
    {
        // Due date là 3 ngày kể từ lúc tạo
        if (empty($invoice->due_date)) {
            $invoice->due_date = now()->addDays(3);
        }
        $invoice->transaction_code = strtoupper(uniqid()); // Tạo mã giao dịch duy nhất
        $invoice->status = 'pending'; // Mặc định trạng thái là 'pending'
    }

    // Gửi email khi tạo hóa đơn
    public function created(Invoice $invoice)
    {
        Mail::to($invoice->user->email)
            ->send(new InvoicePaidMail($invoice));
    }

    // Sau khi đã update
    public function updated(Invoice $invoice)
    {
        // Chỉ xử lý khi status thay đổi thành 'paid'
        if ($invoice->isDirty('status') && $invoice->status === 'paid') {
            // 1. Gửi email xác nhận
            Mail::to($invoice->user->email)
                ->send(new InvoicePaidMail($invoice));


            // 2. Gắn khóa học vào tài khoản user
            $courseIds = $invoice->items->pluck('course_id')->toArray();
            // syncWithoutDetaching là thêm những khóa chưa có trong $courseIds (ko xóa nhưng course id đã có trong bảng)
            // sync là xóa những cái k có trong $courseIds luôn, chỉ add những cái đó (	Cập nhật danh sách ID trong bảng pivot, xóa hết các ID không có trong mảng mới và thêm các ID mới vào.)
            $invoice->user->purchasedCourses()->syncWithoutDetaching($courseIds);
        }
        // Các khóa học trong invoice sẽ được add vô tài khoản người thanh toán hóa đơn
        // $invoice->user->purchasedCourses()->attach($invoice->courses);
    }
}
