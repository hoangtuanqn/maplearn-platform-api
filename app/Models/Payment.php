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
    public $timestamps = false;
    public function getRouteKeyName()
    {
        return 'transaction_code';
    }

    protected $fillable = [
        'user_id',
        'course_id',
        'amount',
        'payment_method',
        'transaction_code',
        'status',
        'paid_at'
    ];
    protected $casts = [
        'amount' => 'float',
        'paid_at' => 'datetime',
    ];



    public function course()
    {
        return $this->belongsTo(Course::class);
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
