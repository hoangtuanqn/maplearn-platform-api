<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Invoice;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seender Faker

        for ($i = 0; $i < 100; $i++) {
            Invoice::create([
                'user_id' => 8,
                'transaction_code' => strtoupper(Str::random(10)), // Tạo mã giao dịch duy nhất
                'payment_method' => 'transfer',
                'total_price' => rand(1000, 10000) * 100, // Giá trị ngẫu nhiên từ 10.00 đến 100.00
                'status' => Arr::random(['pending', 'paid', 'failed', 'expired']),
            ]);
        }
    }
}
