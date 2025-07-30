<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Spatie\QueryBuilder\QueryBuilder;

class TagController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Cách sử dụng: http://localhost:8000/api/v1/tags?filter[name]=tuan
        $tags = QueryBuilder::for(Tag::class)
            ->allowedFilters(['name'])
            ->allowedSorts(['created_at'])->get();
        return $this->successResponse($tags, 'Lấy danh sách nhãn thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Tag $tag)
    {
        return $this->successResponse($tag, 'Xem chi tiết nhãn thành công!');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Tag $tag)
    {
        Gate::authorize('create', $tag);
        $tag = Tag::create($request->validate([
            'name' => 'required|string|max:255',
        ]));
        return $this->successResponse($tag, 'Tạo nhãn mới thành công', Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tag $tag)
    {
        Gate::authorize('update', $tag);
        $tag->update($request->validate([
            'name' => 'sometimes|required|string|max:255',
        ]));
        return $this->successResponse($tag, 'Cập nhật nhãn thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        Gate::authorize('delete', $tag);
        $tag->delete();
        return $this->noContentResponse();
    }
}
