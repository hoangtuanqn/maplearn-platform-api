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
        Schema::create('exam_attempts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('exam_paper_id');
            $table->unsignedInteger('user_id');
            $table->decimal('score', 5, 2)->default(0.00); // Điểm bài thi
            $table->integer('violation_count')->default(0);   // Số lần vi phạm
            $table->integer('time_spent')->default(0); // Thời gian làm bài (tính bằng giây)
            $table->timestamps();

            $table->foreign('exam_paper_id')->references('id')->on('exam_papers')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_attempts');
    }
};
