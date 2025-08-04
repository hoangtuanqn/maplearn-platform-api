<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\GradeLevel;
use Illuminate\Http\Request;

class GradeLevelController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gradeLevels = GradeLevel::all();
        return $this->successResponse($gradeLevels, 'Lấy danh sách khối lớp thành công!');
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
    public function show(GradeLevel $gradeLevel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GradeLevel $gradeLevel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GradeLevel $gradeLevel)
    {
        //
    }

    // Lấy danh sách môn trong từng level học (VD: Lớp 12 thì có khóa học nào, lớp 11 thì có khóa học nào)
    // Mỗi danh mục 8 khóa học
    public function getCoursesByGradeLevel()
    {

        // Chỉ lấy các khóa học đang active
        $gradeLevels = GradeLevel::with(['courses' => function ($query) {
            $query->select([
                'id',
                'name',
                'slug',
                'thumbnail',
                'price',
                'department_id',
                'grade_level_id',
            ])->where('status', true)->orderBy('id', 'desc')->take(8); // Giới hạn 8 khóa học mỗi khối lớp
        }])->get();

        return $this->successResponse($gradeLevels, 'Lấy danh sách khóa học theo khối lớp thành công!');
    }
}
