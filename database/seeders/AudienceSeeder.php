<?php

namespace Database\Seeders;

use App\Models\Audience;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AudienceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Audience::factory(5)->create();
        $audiences = ['2k7', '2k8', '2k9', '2k10'];

        foreach ($audiences as $audience) {
            Audience::create([
                'name' => $audience,
                'status' => 1
            ]);
        }
    }
}
