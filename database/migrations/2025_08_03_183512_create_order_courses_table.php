<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_courses', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('order_id'); // Khóa ngoại tới bảng orders
            $table->unsignedInteger('course_id'); // Khóa ngoại tới bảng courses
            $table->decimal('price', 10, 2); // giá tại thời điểm thanh toán
            $table->timestamps();
            // Khóa ngoại tới bảng orders
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            // Khóa ngoại tới bảng courses
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_courses');
    }
};
