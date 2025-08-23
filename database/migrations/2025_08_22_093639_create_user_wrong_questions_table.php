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
        Schema::create('user_wrong_questions', function (Blueprint $table) {
            $table->increments('id'); // PK

            // FK -> users.id: học sinh
            $table->unsignedInteger('user_id');

            // FK -> exam_questions.id: câu hỏi đã từng làm sai
            $table->unsignedInteger('exam_question_id');

            // Tổng số lần user làm sai câu này
            $table->unsignedInteger('wrong_count')->default(0);

            // Số lần liên tiếp làm đúng gần đây khi ôn lại
            $table->unsignedInteger('correct_streak')->default(0);

            // Thời điểm lần đầu/ gần nhất user làm sai câu này
            $table->timestamp('first_wrong_at')->nullable();
            $table->timestamp('last_wrong_at')->nullable();

            // Lần cuối làm đúng câu này
            $table->timestamp('last_correct_at')->nullable();

            // Trạng thái ôn: đang cần ôn/hoãn/đã nắm
            $table->enum('status', ['active', 'snoozed', 'mastered'])->default('active');


            $table->timestamps();

            // Unique 1 user - 1 câu
            $table->unique(['user_id', 'exam_question_id'], 'uq_user_question');

            // Index phục vụ truy vấn danh sách cần ôn
            $table->index(['user_id', 'status'], 'idx_user_due_status');


            // FKs
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->foreign('exam_question_id')
                ->references('id')->on('exam_questions')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_wrong_questions');
    }
};
