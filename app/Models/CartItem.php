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
        'id',
        'user_id',
        'course_id',
        'price_snapshot',
        'is_active', // Trạng thái hoạt động của mục giỏ hàng
    ];

    protected $casts = [
        'price_snapshot' => 'double',
        'is_active' => 'boolean', // Chuyển đổi sang kiểu boolean
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
