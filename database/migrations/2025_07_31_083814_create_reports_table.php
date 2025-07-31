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
        Schema::create('reports', function (Blueprint $table) {
            $table->increments('id');
            // Đây là phần quan trọng để sử dụng morphTo
            $table->morphs('reportable'); // => tạo reportable_type + reportable_id
            $table->text('reason')->nullable(); // tiêu đề lý do
            $table->text('message')->nullable(); // nội dung mô tả
            $table->enum('status', ['pending', 'resolved', 'rejected'])->default('pending');
            $table->integer('reported_by')->unsigned();
            $table->integer('handled_by')->unsigned();
            $table->foreign('reported_by')->references('id')->on('users')->onDelete('cascade'); // người báo cáo
            $table->foreign('handled_by')->references('id')->on('users')->onDelete('cascade'); // người xử lý
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
