<?php

namespace Database\Seeders;

use App\Models\CourseChapter;
use App\Models\CourseLesson;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseLessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Faker dữ liệu trên mỗi course chaper sẽ có 5 video

        $chapers = CourseChapter::all();
        foreach ($chapers as $chaper) {
            for ($i = 1; $i <= 5; $i++) {
                CourseLesson::create([
                    'chapter_id' => $chaper->id,
                    'title' => "Bài học video $i trong chương",
                    'content' => "Đây là mô tả cho bài học video $i của chương {$chaper->id}.",
                    'video_url' => "/video.mp4",
                    'duration' => rand(300, 900), // Thời lượng ngẫu nhiên từ 5 đến 15 phút
                    'position' => $i,
                ]);
            }
        }
    }
}
