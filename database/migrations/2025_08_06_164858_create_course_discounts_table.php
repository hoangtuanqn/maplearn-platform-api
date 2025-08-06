<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * * Giảm giá trực tiếp cho khóa học
     *
     */
    public function up(): void
    {
        Schema::create('course_discounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('course_id'); // Khóa học áp dụng giảm giá
            $table->enum('type', ['percentage', 'fixed']); // Loại giảm giá: phần trăm hay cố định
            $table->decimal('value', 10, 2); // Giá trị giảm giá => 1000.000.00đ hoặc 100.00%
            $table->unsignedInteger('usage_count')->default(0); // Số lượt đã dùng
            $table->unsignedInteger('usage_limit')->default(0); // Tối đa bao nhiêu lượt dùng
            $table->dateTime('start_date')->nullable(); // Ngày bắt đầu áp dụng giảm giá
            $table->dateTime('end_date')->nullable(); // Ngày kết thúc áp dụng giảm giá
            $table->boolean('is_active')->default(true); // Trạng thái hoạt động của giảm giá
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_discounts');
    }
};
