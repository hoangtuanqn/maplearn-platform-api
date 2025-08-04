<?php

namespace Database\Seeders;

use App\Models\CourseUserFavorite;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseUserFavoriteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        for ($i = 1; $i <= 81; $i++) {
            CourseUserFavorite::create([
                'user_id' => 8,
                'course_id' => $i,
            ]);
        }
    }
}
