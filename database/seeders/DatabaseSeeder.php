<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            SubjectSeeder::class,
            CourseCategorySeeder::class,
            PostSeeder::class,
            DocumentCatogorySeeder::class,
            GradeLevelSeeder::class,
            DocumentSeeder::class,

            ExamCategorySeeder::class,
            ExamPaperSeeder::class,
            ExamQuestionSeeder::class,

            CourseSeeder::class,
            CourseChapterSeeder::class,
            CourseLessonSeeder::class,

        ]);
    }
}
