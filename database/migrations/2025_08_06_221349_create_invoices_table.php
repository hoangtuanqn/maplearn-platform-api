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
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            // Liên kết với bảng payment, 1 bảng payment có thể chứa nhiều invoice
            $table->unsignedInteger('payment_id')->nullable();
            $table->unsignedInteger('user_id');
            $table->string('transaction_code')->unique(); // Mã giao dịch
            $table->enum('payment_method', ['transfer', 'vnpay', 'momo', 'zalopay', 'card'])->default('transfer'); // hình thức thanh toán (transfer, paypal, vnpay, ...)
            $table->decimal('total_price', 10, 2);
            $table->enum('status', ['pending', 'paid', 'failed', 'expired'])->default('pending'); // pending | paid | failed | expired (Chờ xử lý | Đã thanh toán | Thất bại | Hết hạn thanh toán)

            $table->text('note')->nullable(); // Ghi chú thêm (nếu có)
            // Id đối tác thanh toán, zalopay, momo, vnpay, ...
            // $table->string('partner_id')->nullable();
            $table->timestamp('due_date');
            $table->timestamp('paid_at')->nullable(); // Thời điểm thanh toán thành công
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
