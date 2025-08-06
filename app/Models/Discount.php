<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * * Giảm giá khóa học thông qua mã giảm giá
 */
class Discount extends Model
{
    /** @use HasFactory<\Database\Factories\DiscountFactory> */
    use HasFactory;
    protected $table = 'discounts';
    protected $fillable = [
        'code',
        'type',
        'value',
        'start_date',
        'end_date',
        'usage_limit',
        'user_limit',
        'conditions',
        'stackable',
        'visibility',
        'is_active',
    ];
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'conditions' => 'array',
        'stackable' => 'boolean',
        'is_active' => 'boolean',
    ];
    // Cách sử dụng method này: $discount->getDiscountedPrice($course->price);
    public function getDiscountedPrice(float $originalPrice): float
    {
        if ($this->type === 'percentage') {
            return $originalPrice - ($originalPrice * ($this->value / 100));
        } elseif ($this->type === 'fixed') {
            return max(0, $originalPrice - $this->value);
        }
        return $originalPrice; // No discount applied
    }

    // Kiểm tra tính hợp lệ của mã giảm giá
    public function isValid(): bool
    {
        $now = now();
        return $this->is_active &&
            (!$this->start_date || $this->start_date <= $now) &&
            (!$this->end_date || $this->end_date >= $now);
    }
    public function isStackable(): bool
    {
        return $this->stackable;
    }
    public function isPublic(): bool
    {
        return $this->visibility === 'public';
    }
    public function isPrivate(): bool
    {
        return $this->visibility === 'private';
    }
    public function conditions(): array
    {
        return $this->conditions ?? [];
    }
}
