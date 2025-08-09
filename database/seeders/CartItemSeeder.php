<?php

namespace Database\Seeders;

use App\Models\CartItem;
use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CartItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            $courseId = rand(1, 81); // Giả sử có 81 khóa học
            $course = Course::findOrFail($courseId);
            CartItem::updateOrCreate([
                'user_id' => rand(8, 10),
                'course_id' => $course->id,
                'price_snapshot' => $course->price,
            ]);
        }
    }
}
