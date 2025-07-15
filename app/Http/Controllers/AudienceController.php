<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Audience;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Spatie\QueryBuilder\QueryBuilder;

class AudienceController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $audiences = QueryBuilder::for(Audience::class)
            ->allowedFilters(['name'])
            ->allowedSorts(['created_at'])
            ->orderByDesc('id')
            ->get();

        return $this->successResponse($audiences, 'Lấy danh sách đối tượng thành công!');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:audiences,name',
            'status' => 'sometimes|boolean',
        ]);

        $audience = Audience::create($validated);

        return $this->successResponse($audience, 'Tạo đối tượng mới thành công!', Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Audience $audience)
    {
        $audience->load('courses');

        // Cập nhật lại giá trị

        $courses = QueryBuilder::for($audience->courses()->orderByDesc('id')) // chú ý: gọi method(), không phải property
            ->allowedFilters(['id', 'title', 'subject_id', 'category_id'])  // các field được filter
            ->allowedSorts(['created_at'])
            ->get()
            ->map(function ($course) {
                return Arr::except($course->toArray(), ['description']); // ẩn field tại đây
            });
        $audience->setRelation('courses', $courses);
        return $this->successResponse($audience, 'Xem chi tiết đối tượng thành công!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Audience $audience)
    {
        Gate::authorize('update', $audience);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'status' => 'sometimes|boolean',
        ]);

        $audience->update($validated);

        return $this->successResponse($audience, 'Cập nhật đối tượng thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Audience $audience)
    {
        Gate::authorize('delete', $audience);
        $audience->delete();
        return $this->noContentResponse();
    }
}
