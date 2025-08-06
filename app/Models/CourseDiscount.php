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
    //  Schema::create('course_discounts', function (Blueprint $table) {
    //         $table->id();
    //         $table->unsignedInteger('course_id'); // Khóa học áp dụng giảm giá
    //         $table->enum('type', ['percentage', 'fixed']); // Loại giảm giá: phần trăm hay cố định
    //         $table->decimal('value', 10, 2); // Giá trị giảm giá => 1000.000.00đ hoặc 100.00%
    //         $table->unsignedInteger('usage_limit')->default(0); // Tối đa bao nhiêu lượt dùng
    //         $table->unsignedInteger('usage_count')->default(0); // Số lượt đã dùng
    //         $table->dateTime('start_date')->nullable(); // Ngày bắt đầu áp dụng giảm giá
    //         $table->dateTime('end_date')->nullable(); // Ngày kết thúc áp dụng giảm giá
    //         $table->boolean('is_active')->default(true); // Trạng thái hoạt động của giảm giá
    //         $table->timestamps();
    //     });
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
