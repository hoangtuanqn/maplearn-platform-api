<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Course;
use App\Models\CourseChapter;
use App\Models\CourseLesson;
use App\Traits\AuthorizesOwnerOrAdmin;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CourseLessonController extends BaseApiController
{
    use AuthorizesRequests, AuthorizesOwnerOrAdmin;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'chapter_id' => 'required|exists:course_chapters,id',
            'title'       => 'required|string|max:255',
            'content'     => 'nullable|string',
            'video_url'   => 'nullable|url',
            'position'    => 'required|integer|min:1',
            'duration'    => 'nullable|integer|min:0', // duration in seconds
            'is_free'   => 'boolean',
        ]);

        $chapter = CourseChapter::find($data['chapter_id']);
        if (!$chapter) {
            return $this->errorResponse(null, 'Chương học không tồn tại!', 404);
        }

        $lesson = $chapter->lessons()->create([
            'title' => $data['title'],
            'content' => $data['content'] ?? '',
            'video_url' => $data['video_url'] ?? null,
            'position' => $data['position'],
            'duration' => $data['duration'] ?? 0,
            'is_free' => $data['is_free'] ?? false,
        ]);
        return $this->successResponse($lesson, 'Thêm bài học vào chương thành công', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(CourseLesson $courseLesson)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CourseLesson $courseLesson)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CourseLesson $lesson)
    {
        Gate::authorize('admin-teacher');
        $lesson->delete();
        return $this->successResponse(null, 'Xóa bài học thành công!', 200);
    }
}
