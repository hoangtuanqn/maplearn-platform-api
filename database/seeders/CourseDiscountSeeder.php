<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseDiscount;
use Illuminate\Support\Arr;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseDiscountSeeder extends Seeder
{
    /**
     * Giảm giá vào khóa học trực tiếp
     */
    public function run(): void
    {
        for ($i = 1; $i <= 200; $i++) {
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
