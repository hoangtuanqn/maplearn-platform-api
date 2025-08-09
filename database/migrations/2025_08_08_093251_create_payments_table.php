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
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');

            $table->string('transaction_code')->unique();
            $table->enum('payment_method', ['transfer', 'vnpay', 'momo', 'zalopay'])->default('transfer'); // 'transfer', 'vnpay', 'momo', 'zalopay'
            $table->enum('status', ['pending', 'paid', 'failed'])->default('pending');

            $table->timestamp('paid_at')->nullable(); // thời điểm thanh toán thành công
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
