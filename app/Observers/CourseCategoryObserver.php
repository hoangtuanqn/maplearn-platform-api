<?php

namespace App\Observers;

use App\Helpers\CommonHelper;
use App\Models\CourseCategory;

class CourseCategoryObserver
{
    public function creating(CourseCategory $courseCategory)
    {
        if (empty($courseCategory->slug)) {
            $courseCategory->slug = CommonHelper::generateSlug($courseCategory->name);
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
