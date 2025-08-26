<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\DocumentCategory;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class DocumentCategoryController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $limit = (int)($request->limit ?? 10); // Giới hạn tối đa 100 items

        $categories = QueryBuilder::for(DocumentCategory::class)
            ->select(['id', 'name', 'description', 'status', 'created_at', 'updated_at'])
            // ->whereHas('documents') // * 👈 Chỉ lấy category có ít nhất 1 document
            ->allowedFilters([
                AllowedFilter::partial('name'),      // tìm kiếm theo tên danh mục
                AllowedFilter::exact('status'),      // lọc theo trạng thái (true/false)
            ])
            ->allowedSorts(['id', 'created_at', 'name']) // cho phép sắp xếp theo các trường này
            ->allowedIncludes(['documents'])             // include tài liệu của danh mục
            ->defaultSort('-id')                         // mặc định sắp xếp theo id giảm dần
            ->paginate($limit)
            ->appends($request->query());

        return $this->successResponse($categories, 'Lấy danh sách danh mục tài liệu thành công!');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'boolean',
        ]);

        $category = DocumentCategory::create($data);

        return $this->successResponse($category, 'Tạo danh mục thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        $category = DocumentCategory::findOrFail($id);

        // Nếu có query string 'include' thì thêm vào response
        if ($request->has('include')) {
            $includes = explode(',', $request->get('include'));
            $category->setAppends($includes);
        }

        return $this->successResponse($category, 'Lấy thông tin danh mục thành công!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DocumentCategory $documentCategory)
    {
        $data = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'status' => 'boolean',
        ]);

        $documentCategory->update($data);

        return $this->successResponse($documentCategory, 'Cập nhật danh mục thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DocumentCategory $documentCategory)
    {
        $documentCategory->delete();

        return $this->successResponse(null, 'Xóa danh mục thành công!');
    }
}
