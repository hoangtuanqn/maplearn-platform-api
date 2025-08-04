<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\CourseUserFavorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class CourseUserFavoriteController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $limit = min($request->get('limit', 10), 100);
        $user = Auth::user();

        $query = $user->favoriteCourses()->with(['subject', 'gradeLevel']);

        // Sử dụng QueryBuilder
        $courses = QueryBuilder::for($query)
            ->allowedSorts(['id', 'title']) // bạn có thể cho phép sắp xếp theo các cột
            // ->allowedFilters([
            //     AllowedFilter::partial('title'),
            //     AllowedFilter::exact('subject_id'),
            //     AllowedFilter::exact('grade_level_id'),
            // ])
            ->paginate($limit) // hoặc sử dụng ->jsonPaginate() nếu cần JSON API chuẩn
            ->appends($request->query()); // để giữ lại query trên link phân trang

        // Thêm is_favorite
        $courses->getCollection()->transform(function ($course) {
            $course->is_favorite = true;
            return $course;
        });

        return $this->successResponse($courses, "Danh sách khóa học yêu thích có phân trang");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $courseId)
    {
        $user = $request->user();
        if (!$user->favoriteCourses->contains($courseId)) {
            $user->favoriteCourses()->attach($courseId);
        }
        return $this->successResponse(null, "Thêm khóa học yêu thích thành công");
    }

    /**
     * Display the specified resource.
     */
    public function show(CourseUserFavorite $courseUserFavorite)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CourseUserFavorite $courseUserFavorite)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $courseId)
    {
        $user = $request->user();

        $user->favoriteCourses()->detach($courseId);

        return $this->successResponse(null, "Đã xóa khỏi danh sách yêu thích");
    }
    // Kiểm tra đã yêu thích chưa
    public function isFavorite(Request $request, $courseId)
    {
        $user = $request->user();

        $isFavorite = $user->favoriteCourses->contains($courseId);

        return response()->json(['favorite' => $isFavorite]);
    }
}
