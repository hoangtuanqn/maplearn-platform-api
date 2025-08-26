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
        $isLike2 = $isLike;


        $existingVote = CourseReviewVote::where('user_id', $user->id)
            ->where('course_review_id', $id)
            ->first();

        if ($existingVote) {
            if ($existingVote->is_like == $isLike) {
                $isLike2 = null;

                // Nếu bấm lại cùng lựa chọn => xóa vote
                $existingVote->delete();
                // return $this->successResponse(null, 'Đã gỡ bỏ vote thành công!');
            } else {
                // Nếu thay đổi like ↔ dislike
                $existingVote->update(['is_like' => $isLike]);
                // return $this->successResponse(null, 'Đã cập nhật vote thành công!');
            }
        } else {

            // Chưa từng vote → tạo mới
            CourseReviewVote::create([
                'user_id' => $user->id,
                'course_review_id' => $id,
                'is_like' => $isLike,
            ]);
        }
        $courseReview = CourseReview::with(['user:id,full_name,avatar'])
            ->findOrFail($id)
            ->loadCount(['likes', 'dislikes']);

        return $this->successResponse([...$courseReview->toArray(), 'is_liked' => $isLike2], 'Đã thao tác thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $slug)
    {
        $limit = (int)($request->limit ?? 10); // Giới hạn tối đa 100 items
        $userId = $request->user()->id ?? null;
        // $userId = 8;
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
            ->allowedSorts(['id', 'rating']) // Cho phép sắp xếp theo id or rating
            ->allowedFilters([
                AllowedFilter::exact('user_id'),
                AllowedFilter::exact('rating'),
            ])
            ->select(['id', 'course_id', 'user_id', 'rating', 'comment', 'created_at'])
            ->withCount(['likes', 'dislikes'])
            ->paginate($limit);

        // Viết thêm thuộc tính user_vote: like => true, false => false, chưa vote => null
        // Lấy ra danh sách các review_id đã paginate
        $reviewIds = $courseReviews->pluck('id');

        // Lấy vote của user hiện tại cho các review đó
        $votes = CourseReviewVote::where('user_id', $userId)
            ->whereIn('course_review_id', $reviewIds)
            ->pluck('is_like', 'course_review_id'); // key = review_id, value = is_like

        // Gắn thủ công vào từng review
        $courseReviews->getCollection()->transform(function ($review) use ($votes) {
            $review->is_liked = $votes[$review->id] ?? null; // null nếu chưa vote
            return $review;
        });
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
                'percentage' => $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0,

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
