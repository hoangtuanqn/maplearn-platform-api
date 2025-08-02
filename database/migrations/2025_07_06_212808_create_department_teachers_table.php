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
        Schema::create('department_teacher', function (Blueprint $table) {
            $table->unsignedInteger('teacher_id');
            $table->unsignedInteger('department_id');

            // Tạo khóa chính kép
            $table->primary(['teacher_id', 'department_id']); // Đảm bảo không có giáo viên nào được phân vào 1 khoa cùng một lúc

            // Ràng buộc khóa ngoại
            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('department_teacher');
    }
};
