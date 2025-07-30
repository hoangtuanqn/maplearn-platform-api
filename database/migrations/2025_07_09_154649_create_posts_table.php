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
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->string("slug")->unique();
            $table->string("title");
            $table->string("thumbnail");
            $table->longText("content");
            $table->integer('views')->default(0);
            $table->json('tags_id')->nullable(); // VD: [1, 3, 5]
            $table->boolean('status')->default(true);
            $table->integer('created_by')->unsigned();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
