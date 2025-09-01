<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseChapter;
use Illuminate\Database\Seeder;

class CourseChapterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Giả sử bạn đã có một số Course trong cơ sở dữ liệu
        $courses = Course::all();

        foreach ($courses as $course) {
            // Tạo 8 chương cho mỗi khóa học
            for ($i = 1; $i <= 8; $i++) {
                CourseChapter::create([
                    'course_id' => $course->id,
                    'title'     => "Chương $i của khóa học {$course->title}",
                    'position'  => $i,
                ]);
            }
        }
    }
}
