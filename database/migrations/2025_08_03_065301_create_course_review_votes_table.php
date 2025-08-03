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
        Schema::create('course_review_votes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id'); // Sửa lại từ unsignedBigInteger => unsignedInteger
            $table->unsignedInteger('course_review_id'); // Cũng nên check kiểu ở course_reviews
            $table->boolean('is_like')->default(true); // true: like, false: dislike
            $table->timestamps();

            $table->unique(['user_id', 'course_review_id']);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('course_review_id')->references('id')->on('course_reviews')->onDelete('cascade');
            $table->index(['user_id', 'course_review_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_review_votes');
    }
};
