<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    /** @use HasFactory<\Database\Factories\InvoiceItemFactory> */
    use HasFactory;
    protected $fillable = [
        'invoice_id',
        'course_id',
        'price_snapshot',
    ];
    protected $casts = [
        'price_snapshot' => 'float',
    ];
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
