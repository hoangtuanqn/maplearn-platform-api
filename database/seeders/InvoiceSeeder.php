<?php

namespace Database\Seeders;

use App\Models\Course;
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

            $courses = Course::inRandomOrder()->limit(5)->get();
            $invoice = Invoice::create([
                'user_id' => 8,
                'transaction_code' => strtoupper(Str::random(10)), // Tạo mã giao dịch duy nhất
                'payment_method' => 'transfer',
                'total_price' => $courses->sum('final_price'),
                'status' => Arr::random(['pending', 'paid', 'failed', 'expired']),
            ]);

            foreach ($courses as $course) {
                $invoice->items()->create([
                    'invoice_id' => $invoice->id,
                    'course_id' => $course->id,
                    'price_snapshot' => $course->final_price,
                ]);
            }
        }
    }
}
