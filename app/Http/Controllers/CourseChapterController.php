<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Course;
use App\Models\CourseChapter;
use Illuminate\Http\Request;

class CourseChapterController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $slug)
    {
        // Lấy slug của chương học từ route
        // Eager load lessons qua quan hệ
        $course = Course::with('chapters.lessons')->where('id', 1)->firstOrFail();

        $course->chapters->each(function ($chapter) {
            $chapter->lessons->each->makeHidden(['video_url', 'content', 'created_at', 'updated_at']);
        });
        return $this->successResponse($course->chapters, 'Lấy danh sách chương thành công');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CourseChapter $courseChapter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CourseChapter $courseChapter)
    {
        //
    }
}
