<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\LessonViewHistory;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class LessonViewHistoryController extends BaseApiController
{

    public function getHistoriesLearning(Request $request, Course $course)
    {
        // Lấy tất cả các id của lesson thuộc khóa học
        $lessonIds = $course->lessons()->pluck('course_lessons.id');
        // $histories = LessonViewHistory::whereIn('lesson_id', $lessonIds)
        //     ->orderBy('updated_at', 'desc')
        //     ->get();
        $limit = min($request->query('limit', 20), 100); // Giới hạn tối đa 100
        $histories = QueryBuilder::for(LessonViewHistory::class)
            ->allowedFilters(['user_id', 'lesson_id', 'is_completed'])
            ->with('user:id,full_name,avatar,email')
            ->with('lesson.chapter:id,title')
            ->whereIn('lesson_id', $lessonIds)
            ->orderBy('updated_at', 'desc')
            ->paginate($limit);

        // Lấy lịch sử xem bài học theo các lesson id, sắp xếp theo updated_at
        return $this->successResponse($histories, 'Lấy lịch sử học thành công!', 200);
    }
}
