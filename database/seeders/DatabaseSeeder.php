<?php

namespace Database\Seeders;


// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        ]);
    }
}
