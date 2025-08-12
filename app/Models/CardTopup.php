<?php

namespace App\Models;

use App\Observers\CardTopupObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([CardTopupObserver::class])]
class CardTopup extends Model
{
    /** @use HasFactory<\Database\Factories\CardTopupFactory> */
    use HasFactory;
    protected $fillable = [
        'user_id',
        'invoice_id',
        'network',
        'amount',
        'serial',
        'code',
        'status',
        'request_id',
        'response_message'
    ];

    protected $casts = [
        'amount' => 'integer',
        'status' => 'string',
    ];
    protected $hidden = [
        'code'
    ];

    // Invoice
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
    // user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
