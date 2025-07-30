<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $limit = min((int)($request->limit ?? 10), 100); // Giới hạn tối đa 100 items

        // $subjects = QueryBuilder::for(Subject::class)
        //     ->allowedFilters(['name'])
        //     ->select(['id', 'name'])
        //     ->where('status', true)
        //     // ->orderByDesc('id')
        //     ->paginate($limit);

        // return $this->successResponse($subjects, 'Lấy danh sách môn học thành công!');
        $subjects = Subject::where('status', true)->get();
        return $this->successResponse($subjects, 'Lấy danh sách môn học thành công!');
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
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        if (Subject::where('name', $validated['name'])->exists()) {
            return $this->errorResponse('Môn học đã tồn tại!', 422);
        }
        $subject = Subject::create($validated);
        return $this->successResponse($subject, 'Tạo môn học thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subject $subject)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subject $subject)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject)
    {
        //
    }
}
