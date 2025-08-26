<?php

namespace App\Http\Controllers;

use App\Filters\Course\CategoryCourseSlugFilter;
use App\Filters\Course\CustomRatingFilter;
use App\Filters\Course\IsDiscountedFilter;
use App\Filters\Course\PriceFilter;
use App\Filters\Course\TeacherFilter;
use App\Filters\GradeLevelSlugFilter;
use App\Filters\SubjectSlugFilter;
use App\Http\Controllers\Api\BaseApiController;
use App\Models\Course;
use App\Models\CourseUserFavorite;
use App\Sorts\Course\EnrollmentCountSort;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
                'grade_level_id',
                'thumbnail',
                'price',
                'subject_id',
                'category_id',
                'department_id',

            ])
            ->allowedSorts(['created_at', 'download_count', 'reviews_count', AllowedSort::custom('enrollment_count', new EnrollmentCountSort)])
            ->allowedFilters([
                'id',
                'name',
                'name',
                'category_id',
                'reviews_count',
                AllowedFilter::custom('grade_level', new GradeLevelSlugFilter),
                AllowedFilter::custom('category', new CategoryCourseSlugFilter),
                AllowedFilter::custom('subject', new SubjectSlugFilter),
                AllowedFilter::custom('rating', new CustomRatingFilter),
                AllowedFilter::custom('price_range', new PriceFilter),
                AllowedFilter::custom('teachers', new TeacherFilter),
                AllowedFilter::custom('is_discounted', new IsDiscountedFilter),
            ])
            ->where('status', true)
            // ->orderByDesc('id')
            ->paginate($limit);
        $courses->getCollection()->transform(function ($course) {
            return $course->makeHidden(['lesson_count', 'duration', 'reviews_count']);
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
        $course->loadCount('enrollments');

        // Sau đó load các quan hệ khác
        $course->load([
            'teachers',
            'teachers.user:id,full_name,avatar',
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
        $userId = Auth::id();
        $favCourseIds = CourseUserFavorite::where('user_id', $userId)
            ->pluck('course_id');

        if ($favCourseIds->isNotEmpty()) {
            $favoriteCourses = Course::whereIn('id', $favCourseIds)->get();


            // Lấy các chủ đề, cấp học,... từ các khóa yêu thích
            $subjectIds = $favoriteCourses->pluck('subject_id')->unique();
            $gradeLevels = $favoriteCourses->pluck('grade_level_id')->unique();
            $categoryIds = $favoriteCourses->pluck('category_id')->unique();


            // Lấy danh sách khóa học đã mua (để tránh đề xuất khóa học đã mua)
            $purchasedCourseIds = Auth::user()->enrollments()->pluck('course_id');

            // Đề xuất các khóa học tương tự nhưng chưa yêu thích (và người dùng chưa mua khóa học đó)
            $recommendCourses = Course::whereNotIn('id', $favCourseIds)->whereNotIn('id', $purchasedCourseIds)
                ->where('status', true)
                ->where(function ($query) use ($subjectIds, $gradeLevels, $categoryIds) {
                    $query->whereIn('subject_id', $subjectIds)
                        ->orWhereIn('grade_level_id', $gradeLevels)
                        ->orWhereIn('category_id', $categoryIds);
                })
                ->inRandomOrder()
                ->limit(8)
                ->get();
        } else {
            // Nếu chưa có khóa yêu thích → đề xuất ngẫu nhiên
            $recommendCourses = Course::where('status', true)
                ->inRandomOrder()
                ->limit(8)
                ->get();
        }
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
        // $courses->transform(function ($course) {
        //     /*
        //     "department": [],
        //     "subject": [],
        //     "category": [],
        //     "grade_level": null,
        //     "is_favorite": false,
        //     "is_cart": false,
        //     "is_enrolled": false,
        //     department
        //     */
        //     return $course->makeHidden(['grade_level', 'subject', 'category', 'grade_level', 'is_favorite', 'is_cart', 'is_enrolled', 'rating', 'department']);
        // });

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
            return $course->makeHidden(['grade_level', 'subject', 'category', 'grade_level', 'is_favorite', 'is_cart', 'is_enrolled', 'rating', 'department', 'lesson_count', 'duration']);
        });

        return $this->successResponse($courses, 'Lấy dữ liệu khóa học thành công!');
    }
}
