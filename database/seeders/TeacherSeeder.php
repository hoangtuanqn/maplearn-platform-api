<?php

namespace Database\Seeders;

use App\Models\Teacher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teachers =
            [
                'user_id'   => 1,
                'bio' => 'Giáo viên Toán với hơn 10 năm kinh nghiệm giảng dạy.',
                'degree' => 'Thạc sĩ Toán học',

            ];
        for ($i = 0; $i < 7; $i++) {
            Teacher::create([
                'user_id' => $i + 1,
                'bio' => $teachers['bio'],
                'degree' => $teachers['degree'],
            ]);
        }
        //
    }
}
