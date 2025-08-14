<?php

namespace Database\Seeders;

use App\Models\CardTopup;
use App\Models\Invoice;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CardTopupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 100; ++$i) {
            $amount = [10, 20, 50, 100, 200, 300, 500, 1000];
            CardTopup::create([
                'user_id' => 8,
                'invoice_id' => Invoice::inRandomOrder()->where('user_id', 8)->first()->id,
                'network' => 'Viettel',
                'amount' => $amount[array_rand($amount)] * 1000,
                'serial' => str_pad(rand(1, 9999999999999), 13, '0', STR_PAD_LEFT),
                'code' => str_pad(rand(1, 999999999999999), 15, '0', STR_PAD_LEFT),
                'status' => 'pending',
                'response_message' => null,
                'request_id' => rand(111111111111, 999999999999999),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
