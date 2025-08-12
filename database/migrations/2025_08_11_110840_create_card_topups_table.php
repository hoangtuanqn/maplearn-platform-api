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
        Schema::create('card_topups', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('invoice_id');
            $table->string('network', 50); // Nhà mạng
            $table->decimal('amount', 10, 2);     // Mệnh giá
            $table->string('serial', 25); // Seri
            $table->string('code', 25);   // Mã thẻ
            $table->enum('status', ['pending', 'success', 'failed'])->default('pending');
            $table->string('request_id', 50)->unique(); // Mã giao dịch gửi sang cho đối tác
            $table->text('response_message')->nullable(); // Ghi chú từ API
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('card_topups');
    }
};
