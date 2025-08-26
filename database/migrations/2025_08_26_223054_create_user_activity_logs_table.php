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
        Schema::create('user_activity_logs', function (Blueprint $table) {
            $table->increments('id');

            // Liên kết tới user
            $table->unsignedInteger('user_id');

            // Loại hoạt động (login, logout, register, watch_video, do_exam, update_profile, ...)
            $table->string('action');

            // Mô tả chi tiết (ví dụ: "Xem video ID 123", "Làm đề thi ID 5")
            $table->text('description')->nullable();

            // Lưu IP hoặc device nếu cần
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();

            // Thời gian thực hiện (dùng luôn created_at)
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_activity_logs');
    }
};
