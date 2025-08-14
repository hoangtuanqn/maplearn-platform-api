<?php

namespace Database\Seeders;

use App\Models\ExamCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ExamCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'ĐGNL HSA',
            'ĐGNL V-ACT',
            'ĐGTD TSA',
            'Tốt nghiệp THPT',
            'Thi cuối kì 1',
            'Thi cuối kì 2',
            'Thi giữa kì 1',
            'Thi giữa kì 2'
        ];

        foreach ($categories as $category) {
            ExamCategory::create([
                'name' => $category,
            ]);
        }
    }
}
