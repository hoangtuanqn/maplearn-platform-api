<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    /** @use HasFactory<\Database\Factories\CartItemFactory> */
    use HasFactory;
    protected $table = 'cart_items';
    protected $fillable = [
        'user_id',
        'course_id',
        'price_snapshot',
    ];

    protected $casts = [
        'price_snapshot' => 'double',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
