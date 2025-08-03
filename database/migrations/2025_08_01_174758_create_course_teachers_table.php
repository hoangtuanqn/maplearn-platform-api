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
        // Bảng quan hệ nhiều nhiều giữa khóa học và giáo viên
        Schema::create('course_teacher', function (Blueprint $table) {
            $table->unsignedInteger('course_id');
            $table->unsignedInteger('teacher_id');
            $table->timestamps();

            $table->primary(['course_id', 'teacher_id']);

            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_teacher');
    }
};
