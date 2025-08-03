<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseTeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        for ($i = 0; $i < 250; $i++) {
            DB::table('course_teacher')->insertOrIgnore([
                'course_id' => rand(1, 80),
                'teacher_id' => rand(1, 12),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
