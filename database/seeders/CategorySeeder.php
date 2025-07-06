<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
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
            Category::create([
                'name' => $category,
                'status' => 1,
            ]);
        }
    }
}
