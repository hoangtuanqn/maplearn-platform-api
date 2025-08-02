<?php

namespace App\Observers;

use App\Models\CourseCategory;
use Illuminate\Support\Str;

class CourseCategoryObserver
{
    public function creating(CourseCategory $courseCategory)
    {
        if (empty($courseCategory->slug)) {
            $slugBase = Str::slug($courseCategory->name);
            // // Thêm mã ngẫu nhiên 12 ký tự
            // $randomSuffix = Str::random(12);
            // Gán slug
            $courseCategory->slug = $slugBase;
        }
    }


    /**
     * Handle the CourseCategory "created" event.
     */
    public function created(CourseCategory $courseCategory): void
    {
        //
    }

    /**
     * Handle the CourseCategory "updated" event.
     */
    public function updated(CourseCategory $courseCategory): void
    {
        //
    }

    /**
     * Handle the CourseCategory "deleted" event.
     */
    public function deleted(CourseCategory $courseCategory): void
    {
        //
    }

    /**
     * Handle the CourseCategory "restored" event.
     */
    public function restored(CourseCategory $courseCategory): void
    {
        //
    }

    /**
     * Handle the CourseCategory "force deleted" event.
     */
    public function forceDeleted(CourseCategory $courseCategory): void
    {
        //
    }
}
