<?php

namespace Database\Seeders;

use App\Models\CourseCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Category::factory(5)->create();
        $categories = [
            '2K8 - Xuất phát sớm lớp 12',
            '2K9 - Xuất phát sớm lớp 11',
            '2K10 - Xuất phát sớm lớp 10',
            'Học tốt sách giáo khoa',
            'Khóa học Trung học cơ sở',
        ];

        foreach ($categories as $category) {
            CourseCategory::create([
                'name' => $category,
                'status' => 1,
                'created_by' => 1
            ]);
        }
    }
}
