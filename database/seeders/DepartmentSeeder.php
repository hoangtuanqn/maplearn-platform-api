<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            ['name' => 'Tổ Toán'],
            ['name' => 'Tổ Ngữ Văn'],
            ['name' => 'Tổ Vật Lý'],
            ['name' => 'Tổ Hóa Học'],
            ['name' => 'Tổ Sinh Học'],
            ['name' => 'Tổ Lịch Sử'],
            ['name' => 'Tổ Địa Lý'],
            ['name' => 'Tổ Giáo Dục Công Dân'],
            ['name' => 'Tổ Ngoại Ngữ'],
        ];

        foreach ($departments as $department) {
            Department::create($department);
        }
    }
}
