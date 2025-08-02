<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\CourseCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Spatie\QueryBuilder\QueryBuilder;

class CourseCategoryController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $limit = min((int)  ($request->limit ?? 10), 100);
        $tags = QueryBuilder::for(CourseCategory::class)
            ->allowedFilters(['name'])
            ->allowedSorts(['created_at'])
            ->where('status', true)
            ->orderByDesc('id')
            ->paginate($limit);
        return $this->successResponse($tags, 'Lấy danh sách danh mục khóa học thành công!');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', CourseCategory::class);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $validated['created_by'] = $request->user()->id;
        $course_category = CourseCategory::create($validated);
        return $this->successResponse($course_category, 'Tạo danh mục khóa học mới thành công!', Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(CourseCategory $course_category)
    {
        return $this->successResponse($course_category, 'Xem chi tiết danh mục thành công!');

        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CourseCategory $course_category)
    {
        Gate::authorize('update', $course_category);
        $course_category->update($request->validate([
            'name' => 'sometimes|required|string|max:255',
            'status' => 'sometimes|boolean',
        ]));
        return $this->successResponse($course_category, 'Cập nhật danh mục khóa học thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CourseCategory $course_category)
    {
        Gate::authorize('delete', $course_category);
        $course_category->delete();
        return $this->noContentResponse();
    }
}
