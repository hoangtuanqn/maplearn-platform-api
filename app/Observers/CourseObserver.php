<?php

namespace App\Observers;

use App\Models\Course;
use Illuminate\Support\Str;

class CourseObserver
{
    public function creating(Course $course)
    {
        if (empty($course->slug)) {
            $slugBase = Str::slug($course->name);
            $randomSuffix = Str::random(12);
            // Gán slug
            $course->slug = $slugBase . '-' . $randomSuffix;
        }
    }

    /**
     * Handle the Course "created" event.
     */
    public function created(Course $course): void
    {
        //
    }

    /**
     * Handle the Course "updated" event.
     */
    public function updated(Course $course): void
    {
        //
    }

    /**
     * Handle the Course "deleted" event.
     */
    public function deleted(Course $course): void
    {
        //
    }

    /**
     * Handle the Course "restored" event.
     */
    public function restored(Course $course): void
    {
        //
    }

    /**
     * Handle the Course "force deleted" event.
     */
    public function forceDeleted(Course $course): void
    {
        //
    }
}
