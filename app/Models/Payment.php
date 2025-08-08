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

    protected $fillable = [
        'user_id',
        'payment_method',
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
}
