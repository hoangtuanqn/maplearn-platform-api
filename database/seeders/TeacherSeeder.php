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
        $bio = ['Giáo viên Toán với hơn 10 năm kinh nghiệm giảng dạy.', 'Giáo viên Lý với chuyên môn sâu về cơ học.', 'Giáo viên Hóa với đam mê nghiên cứu các phản ứng hóa học.', 'Giáo viên Văn với khả năng phân tích văn bản xuất sắc.', 'Giáo viên Anh với kinh nghiệm giảng dạy quốc tế.'];
        $degree = ['Thạc sĩ Toán học', 'Tiến sĩ Vật lý', 'Thạc sĩ Hóa học', 'Cử nhân Văn học', 'Thạc sĩ Tiếng Anh'];

        for ($i = 0; $i < 12; $i++) {
            Teacher::create([
                'user_id' => $i + 1,
                'bio' => $bio[$i % count($bio)],
                'degree' => $degree[$i % count($degree)],
            ]);
        }
        //
    }
}
