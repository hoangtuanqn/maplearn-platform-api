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
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id'); // PRIMARY KEY

            // KHỚP VỚI users.id (increments → unsignedInteger)
            $table->unsignedInteger('user_id');
            $table->enum('type', ['course', 'post']);
            $table->unsignedInteger('type_id');
            $table->text('description');

            // KHỚP VỚI comments.id (cũng là increments → unsignedInteger)
            $table->unsignedInteger('reply_id')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // FOREIGN KEYS
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('reply_id')->references('id')->on('comments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
