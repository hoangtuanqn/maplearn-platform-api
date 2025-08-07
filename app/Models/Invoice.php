<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'transaction_code',
        'payment_method',
        'total_price',
        'status',
    ];
    protected $appends = [
        'course_count',
    ];
    protected $casts = [
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
}
