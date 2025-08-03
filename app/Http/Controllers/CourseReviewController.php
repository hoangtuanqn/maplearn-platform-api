<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Course;
use App\Models\CourseReview;
use App\Models\CourseReviewVote;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class CourseReviewController extends BaseApiController
{
    public function vote(Request $request, $id)
    {
        $user =  $request->user(); // đảm bảo đã login
        $isLike = $request->input('is_like'); // true / false

        $review = CourseReview::findOrFail($id);

        $existingVote = CourseReviewVote::where('user_id', $user->id)
            ->where('course_review_id', $id)
            ->first();

        if ($existingVote) {
            if ($existingVote->is_like == $isLike) {
                // Nếu bấm lại cùng lựa chọn => xóa vote
                $existingVote->delete();
                return response()->json(['message' => 'Vote đã được gỡ']);
            } else {
                // Nếu thay đổi like ↔ dislike
                $existingVote->update(['is_like' => $isLike]);
                return response()->json(['message' => 'Vote đã được cập nhật']);
            }
        }

        // Chưa từng vote → tạo mới
        CourseReviewVote::create([
            'user_id' => $user->id,
            'course_review_id' => $id,
            'is_like' => $isLike,
        ]);

        return response()->json(['message' => 'Đã vote thành công']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $slug)
    {
        $limit = min((int)($request->limit ?? 10), 100); // Giới hạn tối đa 100 items
        // Tìm khóa học theo slug
        $course = Course::where('slug', $slug)->first();

        if (!$course) {
            return response()->json(['message' => 'Khóa học không tồn tại'], 404);
        }

        // QueryBuilder để phân trang và sắp xếp

        // Gợi API search: http://localhost:8000/api/v1/course-reviews/sach-10-de-thuc-chien-ky-thi-danh-gia-nang-luc-v-act-2025-H9rBmUltRlF9?page=1&limit=5&sort=-id
        $courseReviews = QueryBuilder::for(CourseReview::class)
            ->where('course_id', $course->id)
            ->with(['user:id,full_name,avatar'])
            ->allowedSorts(['id', 'rating']) // Cho phép sắp xếp theo created_at hoặc rating
            ->allowedFilters([
                AllowedFilter::exact('user_id'),
                AllowedFilter::exact('rating'),
            ])
            ->select(['id', 'course_id', 'user_id', 'rating', 'comment', 'created_at'])
            ->withCount(['likes', 'dislikes'])
            ->paginate($limit);
        return $this->successResponse($courseReviews, 'Lấy đánh giá thành công!');
    }
    public function getRatingDistribution(Request $request, $slug)
    {
        // Lấy tất cả đánh giá theo slug khóa học
        $course = Course::where('slug', $slug)->firstOrFail();

        // Lấy các đánh giá theo course_id
        $reviews = CourseReview::where('course_id', $course->id)->get();

        $totalReviews = $reviews->count();

        $distribution = collect([5, 4, 3, 2, 1])->map(function ($star) use ($reviews, $totalReviews) {
            $count = $reviews->where('rating', $star)->count();
            return [
                'star' => $star,
                'count' => $count,
                'percentage' => $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0
            ];
        });

        return $this->successResponse($distribution, 'Lấy phân phối đánh giá thành công!');
    }

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
