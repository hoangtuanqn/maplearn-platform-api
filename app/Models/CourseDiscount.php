<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * * Giảm giá trực tiếp cho khóa học
 *
 */
class CourseDiscount extends Model
{
    /** @use HasFactory<\Database\Factories\CourseDiscountFactory> */

    use HasFactory;
    protected $table = 'course_discounts';
    protected $fillable = [
        'course_id',
        'type',
        'value',
        'usage_limit',
        'usage_count',
        'start_date',
        'end_date',
        'is_active',
    ];
    protected $casts = [
        'course_id' => 'integer',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
    ];
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    // Giá tiền sau khi áp dụng giảm giá
    public function getDiscountedPrice(float $originalPrice): float
    {
        if ($this->type === 'percentage') {
            return $originalPrice - ($originalPrice * ($this->value / 100));
        } elseif ($this->type === 'fixed') {
            return max(0, $originalPrice - $this->value);
        }
        return $originalPrice; // No discount applied
    }
}
