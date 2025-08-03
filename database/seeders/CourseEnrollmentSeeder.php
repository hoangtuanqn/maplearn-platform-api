<?php

namespace Database\Seeders;

use App\Models\CourseEnrollment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseEnrollmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 100; $i++) {
            CourseEnrollment::create([
                'user_id' => rand(1, 18),
                'course_id' => rand(1, 81),
            ]);
        }
    }
}
