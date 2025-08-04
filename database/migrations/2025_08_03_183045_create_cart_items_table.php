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
        Schema::create('cart_items', function (Blueprint $table) {
            $table->increments('id');

            // Gán kiểu giống với users.id và courses.id
            $table->unsignedInteger('user_id');   // Phải trùng kiểu với users.id
            $table->unsignedInteger('course_id'); // Phải trùng kiểu với courses.id

            $table->decimal('price_snapshot', 10, 2); // Giá tại thời điểm thêm vào giỏ
            // is active hay không
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Một người chỉ được thêm 1 khóa học vào giỏ 1 lần
            $table->unique(['user_id', 'course_id']);

            // Khóa ngoại – KHÔNG dùng foreignId nếu bạn dùng increments
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->foreign('course_id')
                ->references('id')->on('courses')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
