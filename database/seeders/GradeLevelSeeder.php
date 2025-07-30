<?php

namespace Database\Seeders;

use App\Models\GradeLevel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GradeLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data  = [
            ['name' => 'DGTD', 'slug' => 'dg-td'],
            ['name' => 'DGNL', 'slug' => 'dg-nl'],
            ['name' => 'Lớp 12', 'slug' => 'lop-12'],
            ['name' => 'Lớp 11', 'slug' => 'lop-11'],
            ['name' => 'Lớp 10', 'slug' => 'lop-10'],
        ];
        foreach ($data as $value) {
            GradeLevel::create($value);
        }
    }
}
