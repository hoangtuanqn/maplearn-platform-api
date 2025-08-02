<?php

namespace Database\Seeders;

use App\Models\DepartmentTeacher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentTeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'teacher_id' => 1,
                'department_id' => 1, // Toán
            ],
            [
                'teacher_id' => 2,
                'department_id' => 3, // Hóa
            ],
            [
                'teacher_id' => 3,
                'department_id' => 2, // Lý
            ],
            [
                'teacher_id' => 4,
                'department_id' => 2, // Lý
            ],
            [
                'teacher_id' => 5,
                'department_id' => 2, // Lý
            ],
            [
                'teacher_id' => 6,
                'department_id' => 2, // Lý
            ],

        ];
        foreach ($data as $item) {
            DepartmentTeacher::create($item);
        }
    }
}
