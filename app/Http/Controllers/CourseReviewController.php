<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Course;
use App\Models\CourseReview;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class CourseReviewController extends BaseApiController
{
    /**
     * Hiển thị danh sách đánh giá khóa học
     */
    public function index(Request $request, Course $course)
    {
        $limit = (int)($request->limit ?? 10);
        $reviews = QueryBuilder::for(CourseReview::class)
            ->where('course_id', $course->id)
            ->latest()
            ->paginate($limit);
        $reviews->getCollection()->transform(function ($review) {
            $review->load(['user:id,avatar,full_name']); // Load user relation
            return $review;
        });
        return $this->successResponse($reviews, "Lấy dữ liệu thành công");
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
    public function show(CourseReview $courseReview) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CourseReview $courseReview)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CourseReview $courseReview)
    {
        //
    }
}
