<?php

namespace App\Observers;

use App\Models\CourseLesson;
use Illuminate\Support\Str;

class CourseLessonObserver
{
    public function creating(CourseLesson $course)
    {
        if (empty($course->slug)) {
            $slugBase = Str::slug($course->name);
            $randomSuffix = Str::random(12);
            // Gán slug
            $course->slug = $slugBase . '-' . $randomSuffix;
        }
    }
}
