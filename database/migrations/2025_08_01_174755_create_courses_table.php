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
        // Người tạo khóa học sẽ là admin
        Schema::create('courses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('intro_video')->nullable(); // Video giới thiệu khóa học
            $table->decimal('price', 10, 2)->default(0.00); // Giá khóa học
            // Có phép bỏ bài hay không, hay phải học tuần tự các bài
            $table->boolean('is_sequential')->default(false); // true: tuần tự, false: có thể nhảy cóc
            // $table->integer('audience_id')->unsigned();
            $table->unsignedInteger('grade_level_id')->unsigned(); // Đối tượng học phù hợp
            $table->unsignedInteger('subject_id')->unsigned(); // Môn học (Toán, lý, hóa, ...)
            $table->unsignedInteger('category_id')->unsigned(); // Danh mục khóa học
            $table->unsignedInteger('department_id')->unsigned(); // Tổ phủ trách khóa học
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            // $table->integer('created_by')->unsigned(); // created_by là INT
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('grade_level_id')->references('id')->on('grade_levels')->onDelete('cascade');

            // Foreign keys
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            // $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
            // $table->foreign('audience_id')->references('id')->on('audiences')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('course_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
