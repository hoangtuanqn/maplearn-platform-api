<?php

namespace Database\Seeders;

use App\Models\CourseReview;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 10; $i++) {
            CourseReview::create([
                'course_id' => 81,
                'user_id' => rand(1, 18),
                'rating' =>  rand(1, 5),
                'comment' => $faker->sentence(20),
            ]);
        }
    }
}
