<?php

namespace App\Http\Controllers;

use App\Filters\CategoryCourseSlugFilter;
use App\Filters\GradeLevelSlugFilter;
use App\Filters\SubjectSlugFilter;
use App\Http\Controllers\Api\BaseApiController;
use App\Models\Course;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class CourseController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $limit = min((int)($request->limit ?? 20), 100);
        // dd($limit);
        $courses = QueryBuilder::for(Course::class)
            ->allowedFilters([
                'title',
                'name',
                AllowedFilter::custom('grade_level', new GradeLevelSlugFilter),
                AllowedFilter::custom('category', new CategoryCourseSlugFilter),
                AllowedFilter::custom('subject', new SubjectSlugFilter),

            ])
            ->select([
                'id',
                'name',
                'slug',
                'grade_level_id',
                'thumbnail',
                'price',
                'subject_id',
                'category_id',
                'department_id',
            ])
            ->allowedSorts(['created_at', 'download_count'])
            ->where('status', true)
            ->orderByDesc('id')
            ->paginate($limit);

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
        //
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
}
