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
        Schema::create('teachers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->unique();
            // $table->json('department_id')->nullable(); // ID
            $table->text('bio')->nullable(); // Thông tin mô tả giáo viên
            $table->string('degree', 100)->nullable(); // 	Học vị (cử nhân, thạc sĩ...)
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDeleteCascade();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
