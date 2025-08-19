<?php

namespace Database\Seeders;


// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\CourseDiscount;
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
            AudienceSeeder::class,
            DepartmentSeeder::class,
            CourseCategorySeeder::class,
            TagSeeder::class,
            PostSeeder::class,
            DocumentCatogorySeeder::class,
            SettingSeeder::class,
            CommentSeeder::class,
            GradeLevelSeeder::class,
            DocumentSeeder::class,
            TeacherSeeder::class,
            DepartmentTeacherSeeder::class,
            CourseSeeder::class,
            CourseReviewSeeder::class,
            CourseTeacherSeeder::class,
            CourseEnrollmentSeeder::class,
            CourseReviewVoteSeeder::class,
            CourseChapterSeeder::class,
            CourseLessonSeeder::class,
            CartItemSeeder::class,
            CourseDiscountSeeder::class,
            DiscountSeeder::class,
            InvoiceSeeder::class,
            CardTopupSeeder::class,
            ExamCategorySeeder::class,
            ExamPaperSeeder::class,
            ExamQuestionSeeder::class,
        ]);
    }
}
