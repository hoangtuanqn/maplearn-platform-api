<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\InvoiceObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([InvoiceObserver::class])]

class Invoice extends Model
{
    /** @use HasFactory<\Database\Factories\InvoiceFactory> */
    use HasFactory;
    // key route = transaction_code
    function getRouteKeyName()
    {
        return 'transaction_code';
    }
    protected $fillable = [
        'user_id',
        'payment_id',
        'transaction_code',
        'payment_method',
        'total_price',
        'due_date',
        'note',
        'status',
    ];
    protected $appends = [
        'course_count',
    ];
    // protected $hidden = [
    //     'partner_id',
    // ];
    protected $casts = [
        'due_date' => 'datetime',
        'total_price' => 'double',

    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }
    public function getCourseCountAttribute()
    {
        return $this->items()->count();
    }


    // Check tính hợp lệ của hóa đơn này
    public function isValid()
    {
        return $this->status === 'pending' && $this->due_date > now();
    }

    // Quan hệ với bảng Payment
    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function cards()
    {
        return $this->hasMany(CardTopup::class);
    }
}
