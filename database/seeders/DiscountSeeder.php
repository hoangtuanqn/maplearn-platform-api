<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseDiscount;
use Illuminate\Support\Arr;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        for ($i = 1; $i <= 50; $i++) {
            $type = Arr::random(['percentage', 'fixed']);

            CourseDiscount::create([
                'course_id'   => Course::inRandomOrder()->first()->id, // Random id từ bảng course
                'type'        => $type,
                'value'       => $type === 'percentage'
                    ? rand(5, 50) // 5% - 50%
                    : rand(100, 200) * 1000, // 100.000đ - 200.000đ
                'start_date'  => now()->subDays(rand(1, 15)),
                'end_date'    => now()->addDays(rand(1, 30)),
                'usage_count' => rand(0, 10),
                'usage_limit' => rand(15, 100),
                'is_active'   => true,
            ]);
        }
    }
}
