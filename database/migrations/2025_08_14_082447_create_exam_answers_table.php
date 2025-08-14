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

        // Danh sách các câu trả lời ABCD trong đề thi
        Schema::create('exam_answers', function (Blueprint $table) {
            $table->increments('id');
            // $table->foreignId('exam_question_id')->constrained('exam_questions')->cascadeOnDelete();
            $table->unsignedInteger('exam_question_id'); // ID của câu hỏi
            $table->text('content'); // Nội dung đáp án
            $table->boolean('is_correct')->default(false); // Câu trả lời này có đúng hay không. Nếu là dạng Đúng/Sai thì content ghi là: "Đúng" và is_correct = true
            $table->timestamps();

            $table->foreign('exam_question_id')->references('id')->on('exam_questions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_answers');
    }
};
