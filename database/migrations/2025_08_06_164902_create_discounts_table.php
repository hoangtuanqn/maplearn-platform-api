<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * * Giảm giá khóa học thông qua mã giảm giá
     */
    public function up(): void
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique(); // Mã giảm giá
            $table->enum('type', ['percentage', 'fixed']); // % hay cố định
            $table->decimal('value', 10, 2); // Giá trị giảm => 1000.000.00đ hoặ 100.00%

            $table->dateTime('start_date')->nullable(); // Ngày bắt đầu
            $table->dateTime('end_date')->nullable(); // Ngày kết thúc

            $table->unsignedInteger('usage_limit')->nullable();  // Tổng lượt dùng
            $table->unsignedInteger('user_limit')->nullable();   // Số người dùng tối đa

            $table->json('conditions')->nullable(); // Lớp, combo, đơn đầu tiên, v.v.

            $table->boolean('stackable')->default(false); // Cho phép cộng dồn với auto discount?
            $table->enum('visibility', ['public', 'private'])->default('private'); // Gợi ý hay không?

            $table->boolean('is_active')->default(true); // Trạng thái hoạt động
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discounts');
    }
};
