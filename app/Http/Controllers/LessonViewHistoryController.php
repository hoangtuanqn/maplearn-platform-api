<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\CourseLesson;
use App\Models\LessonViewHistory;
use Illuminate\Http\Request;

class LessonViewHistoryController extends BaseApiController
{
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
        $user = $request->user();
        $data = $request->validate([
            'lesson_id' => 'required|exists:lessons,id',
        ]);

        // Kiểm tra người dùng đã mua khóa học này chưa
        $lesson = CourseLesson::where('id', $data['lesson_id'])->with('chapter.course')->first();
        if (!$lesson || !$lesson->chapter || !$lesson->chapter->course) {
            return $this->errorResponse(null, 'Không tìm thấy bài học hoặc khóa học!', 404);
        }

        $courseId = $lesson->chapter->course->id;
        $hasPurchased = $user->purchasedCourses()->where('courses.id', $courseId)->exists();
        if (!$hasPurchased) {
            return $this->errorResponse(null, 'Bạn chưa mua khóa học này!', 403);
        }
        // Tạo mới dữ liệu history
        LessonViewHistory::create([
            'user_id' => $user->id,
            'lesson_id' => $data['lesson_id'],
            'progress' => 0,
            'is_completed' => false
        ]);

        return $this->successResponse(null, 'Lịch sử xem bài học đã được tạo!', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(LessonViewHistory $lesson)
    {
        return $this->successResponse($lesson, 'Lịch sử xem bài học đã được tìm thấy!', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LessonViewHistory $lesson)
    {
        // Cập nhật giây xem
        $data = $request->validate([
            'progress' => 'required|integer|min:0',
        ]);
        $data['is_completed'] = false;
        $courseLesson = CourseLesson::find($lesson->lesson_id);
        if ($courseLesson->duration - 60 > $data['progress']) {
            $data['is_completed'] = true;
        }

        $lesson->update($data);

        return $this->successResponse($lesson, 'Lịch sử xem bài học đã được cập nhật!', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LessonViewHistory $lesson)
    {
        //
    }
}
