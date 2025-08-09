<?php

namespace App\Models;

use App\Observers\PaymentObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy(PaymentObserver::class)]
class Payment extends Model
{
    /** @use HasFactory<\Database\Factories\PaymentFactory> */
    use HasFactory;
    public function getRouteKeyName()
    {
        return 'transaction_code';
    }

    protected $fillable = [
        'user_id',
        'payment_method',
        'transaction_code',
        'status',
        'paid_at'
    ];
    protected $casts = [
        'paid_at' => 'datetime',
    ];
    // Quan hệ với bảng invoice
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
    public function isValid()
    {
        // Kiểm tra các invoice bên trong đều phải là hợp lệ
        return $this->invoices->every(fn($invoice) => $invoice->isValid());
        // return true;
    }

    // Quan hệ  hasManyThrough
    public function users()
    {
        return $this->hasManyThrough(
            User::class,     // Model đích
            Invoice::class,  // Model trung gian
            'payment_id',    // Khóa ngoại trên bảng invoices trỏ tới payment
            'id',            // Khóa chính trên bảng users
            'id',            // Khóa chính trên bảng payments
            'user_id'        // Khóa ngoại trên bảng invoices trỏ tới user
        );
    }
}
