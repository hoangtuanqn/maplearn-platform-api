<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Spatie\QueryBuilder\QueryBuilder;
use App\Filters\GradeLevelSlugFilter;
use App\Filters\SubjectSlugFilter;
use Spatie\QueryBuilder\AllowedFilter;

class DocumentController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $limit = (int)($request->limit ?? 10);
        // dd($limit);
        $documents = QueryBuilder::for(Document::class)
            ->allowedFilters([
                'title',
                'category_id',
                AllowedFilter
                    ::custom('grade_level', new GradeLevelSlugFilter),
                AllowedFilter::custom('subject', new SubjectSlugFilter),
            ])
            ->select([
                'id',
                'title',
                'source',
                'download_count',
                'tags_id',
                'grade_level_id',
                'subject_id',
                'category_id',
                'created_at',
                'created_by'
            ])
            ->allowedSorts(['created_at', 'download_count'])
            ->where('status', true)
            ->orderByDesc('id')
            ->paginate($limit);

        return $this->successResponse($documents, 'Lấy danh sách tài liệu thành công!');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', Document::class);

        // Lấy toàn bộ dữ liệu gửi lên
        $data = $request->all();

        if (isset($data['tags_id']) && !is_array($data['tags_id'])) {
            return $this->errorResponse("Tags ID phải là 1 mảng");
        }
        if (is_array($data['tags_id'])) {
            // Loại bỏ những ID tags trùng nhau
            $data['tags_id'] = array_unique($data['tags_id']);
        }

        // Validate
        $validated = validator($data, [
            'title' => 'required|string',
            'category_id' => 'required|exists:document_categories,id',
            'source' => 'nullable|string',
            'tags_id' => 'nullable|array',
            'tags_id.*' => 'exists:tags,id',
        ])->validate();

        // Thêm các giá trị mặc định
        $validated['views'] = 0;
        $validated['status'] = true;
        $validated['created_by'] = $request->user()->id;

        // Tạo document
        $document = Document::create($validated);

        return $this->successResponse($document, 'Tạo tài liệu mới thành công!', Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Document $document)
    {
        $document->load(['category']);
        return $this->successResponse($document, 'Lấy chi tiết tài liệu thành công!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Document $document)
    {
        Gate::authorize('update', $document);
        $document->update($request->validate([
            'title' => 'sometimes|required|string',
            'content' => 'sometimes|required|string',
            'category_id' => 'sometimes|required|exists:document_categories,id',
            'source' => 'sometimes|nullable|string',
            'tags_id' => 'sometimes|nullable|array',
            'tags_id.*' => 'exists:tags,id',
        ]));
        return $this->successResponse($document->append('tags'), 'Cập nhật tài liệu thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Document $document)
    {
        Gate::authorize('delete', $document);
        $document->delete();
        return $this->noContentResponse();
    }

    /**
     * Tăng lượt tải tài liệu
     */
    public function increaseDownload(Document $document)
    {
        $document->increment('download_count');
        return $this->successResponse('Cập nhật lượt tải xuống thành công!');
    }
}
