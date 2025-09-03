<?php

namespace App\Http\Controllers;

use App\Filters\Course\PriceFilter;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Course;
use App\Models\CourseLesson;
use App\Models\LessonViewHistory;
use App\Sorts\Course\EnrollmentCountSort;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class CourseController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $limit = (int)($request->limit ?? 20);
        // dd($limit);
        // loại bỏ key lesson_count, duration
        $courses = QueryBuilder::for(Course::class)

            ->select([
                'id',
                'name',
                'description',
                'slug',
                'grade_level',
                'thumbnail',
                'price',
                'subject',
                'category',
                'user_id',
            ])
            ->allowedSorts(['created_at', 'download_count', AllowedSort::custom('enrollment_count', new EnrollmentCountSort)])
            ->allowedFilters([
                'id',
                'name',
                'name',
                'category',
                'grade_level',
                'subject',
                AllowedFilter::custom('price_range', new PriceFilter),
            ])
            ->where('status', true)
            // ->orderByDesc('id')
            ->paginate($limit);
        $courses->getCollection()->transform(function ($course) {
            return $course->makeHidden(['lesson_count', 'duration']);
        });
        return $this->successResponse($courses, 'Lấy danh sách khóa học thành công!');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

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
    public function show(Course $course)
    {
        // Dùng withCount trước
        // $course->loadCount('enrollments');

        // Sau đó load các quan hệ khác
        $course->load([
            'teacher:id,full_name,avatar,bio,degree',
        ]);

        return $this->successResponse($course, 'Lấy thông tin khóa học thành công!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        //
    }

    // Lấy 8 khóa học
    public function recommended()
    {
        // $userId = Auth::id();
        // $favCourseIds = CourseUserFavorite::where('user_id', $userId)
        //     ->pluck('course_id');

        // if ($favCourseIds->isNotEmpty()) {
        //     $favoriteCourses = Course::whereIn('id', $favCourseIds)->get();

        //     // Lấy các chủ đề, cấp học,... từ các khóa yêu thích
        //     $subjectIds = $favoriteCourses->pluck('subject_id')->unique();
        //     $gradeLevels = $favoriteCourses->pluck('grade_level_id')->unique();
        //     $categoryIds = $favoriteCourses->pluck('category_id')->unique();

        //     // Lấy danh sách khóa học đã mua (để tránh đề xuất khóa học đã mua)
        //     $purchasedCourseIds = Auth::user()->enrollments()->pluck('course_id');

        //     // Đề xuất các khóa học tương tự nhưng chưa yêu thích (và người dùng chưa mua khóa học đó)
        //     $recommendCourses = Course::whereNotIn('id', $favCourseIds)->whereNotIn('id', $purchasedCourseIds)
        //         ->where('status', true)
        //         ->where(function ($query) use ($subjectIds, $gradeLevels, $categoryIds) {
        //             $query->whereIn('subject_id', $subjectIds)
        //                 ->orWhereIn('grade_level_id', $gradeLevels)
        //                 ->orWhereIn('category_id', $categoryIds);
        //         })
        //         ->inRandomOrder()
        //         ->limit(8)
        //         ->get();
        // } else {
        //     // Nếu chưa có khóa yêu thích → đề xuất ngẫu nhiên
        //     $recommendCourses = Course::where('status', true)
        //         ->inRandomOrder()
        //         ->limit(8)
        //         ->get();
        // }
        $recommendCourses = Course::where('status', true)
            ->inRandomOrder()
            ->limit(8)
            ->get();
        return $this->successResponse($recommendCourses, 'Lấy danh sách khóa học đề xuất thành công!');
    }

    // Data được cắt gọn để gửi cho AI
    public function aiData()
    {
        $courses = QueryBuilder::for(Course::class)

            ->select([
                'id',
                'name',
                'description',
                'price',
                'created_at',
            ])
            ->where('status', true)
            ->orderByDesc('id')
            ->get();

        return $this->successResponse($courses, 'Lấy dữ liệu khóa học thành công!');
    }

    // Trả về dữ liệu khóa học với dữ liệu gửi lên [1,2, ...]
    public function aiDataByIds(Request $request)
    {
        $courseIds = $request->input('ids', []);
        if (empty($courseIds)) {
            return $this->errorResponse(null, 'Không có khóa học nào được chọn!', 400);
        }

        $courses = QueryBuilder::for(Course::class)
            ->whereIn('id', $courseIds)
            ->select([
                'id',
                'name',
                'slug',
                'thumbnail',
                'price',
            ])
            ->where('status', true)
            ->get();

        $courses->transform(function ($course) {
            return $course->makeHidden(['grade_level', 'subject', 'category', 'grade_level', 'is_favorite', 'is_enrolled', 'rating', 'lesson_count', 'duration']);
        });

        return $this->successResponse($courses, 'Lấy dữ liệu khóa học thành công!');
    }


    // Lấy thông tin khóa học sau khi đã mua thành công
    public function detailCourse(Request $request, string $slug)
    {
        $course = Course::where('slug', $slug)->firstOrFail();

        $user = $request->user();
        // Check người dùng đã mua khóa học này chưa
        $hasPurchased = $user->purchasedCourses()->where('courses.id', $course->id)->exists();
        if (!$hasPurchased) {
            return $this->errorResponse(null, 'Bạn chưa mua khóa học này!', 403);
        }
        // Người dùng đã học bao nhiêu bài
        $course->completed_lessons = $course->chapters->sum(function ($chapter) use ($user) {
            return LessonViewHistory::where('user_id', $user->id)
                ->where('is_completed', true)
                ->whereIn('lesson_id', $chapter->lessons->pluck('id'))
                ->count();
        });
        $course->percent_completed = $course->completed_lessons / ($course->lesson_count ?? 1) * 100;

        // Lấy chương khóa học (bên trong mỗi chương sẽ có lesson)
        $course->load('chapters.lessons');

        // Lặp qua từng lesson và check trong DB LessonViewHistory
        $lessonHistories = LessonViewHistory::where('user_id', $user->id)->get()->keyBy('lesson_id');
        foreach ($course->chapters as $chapter) {
            foreach ($chapter->lessons as $lesson) {
                $lessonHistory = $lessonHistories->get($lesson->id);
                // Kiểm tra đã hoàn thành chưa
                $lesson->successed = $lessonHistory && $lessonHistory->is_completed;
                // $lesson->viewed = $lessonHistory !== null;
                // $lesson->progress = $lessonHistory ? $lessonHistory->progress : 0;
            }
        }

        return $this->successResponse($course, 'Lấy thông tin khóa học thành công!');
    }

    public function getLesson(Request $request, Course $course, CourseLesson $lesson)
    {
        $user = $request->user();

        $hasPurchased = $user->purchasedCourses()->where('courses.id', $course->id)->exists();
        if (!$hasPurchased) {
            return $this->errorResponse(null, 'Bạn chưa mua khóa học này!', 403);
        }
        $lesson->load('chapter');
        // Get next lesson in current chapter
        $nextLessonInChapter = $lesson->chapter->lessons()->where('position', '>', $lesson->position)->first();

        if ($nextLessonInChapter) {
            $lesson->next_video = $nextLessonInChapter;
        } else {
            // If current lesson is last in chapter, get first lesson of next chapter
            $nextChapter = $course->chapters()->where('position', '>', $lesson->chapter->position)->first();
            if ($nextChapter) {
                $lesson->next_video = $nextChapter->lessons()->orderBy('position')->first();
            } else {
                $lesson->next_video = null; // No more lessons in course
            }
        }

        // Get previous lesson in current chapter
        $prevLessonInChapter = $lesson->chapter
            ->lessons()
            ->where('position', '<', $lesson->position)
            ->get()
            ->last();

        if ($prevLessonInChapter) {
            $lesson->prev_video = $prevLessonInChapter;
        } else {
            // If current lesson is first in chapter, get last lesson of previous chapter
            $prevChapter = $course->chapters()->where('position', '<', $lesson->chapter->position)->get()->last();
            if ($prevChapter) {
                $lesson->prev_video = $prevChapter->lessons()->get()->last();
            } else {
                $lesson->prev_video = null; // No previous lessons in course
            }
        }
        $lessonHistories = LessonViewHistory::where('user_id', $user->id)->get();
        $lesson->viewed = $lessonHistories->contains('lesson_id', $lesson->id);
        $lesson->progress = $lessonHistories->where('lesson_id', $lesson->id)->first()->progress ?? 0;
        return $this->successResponse($lesson, 'Lấy thông tin bài học thành công!');
    }
}
