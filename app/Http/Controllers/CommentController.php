<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Comment;
use App\Models\Course;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends BaseApiController
{
    /**
     * Danh sách bình luận theo type và slug (course hoặc post)
     */
    public function index(Request $request)
    {
        $type = $request->type;
        $slug = $request->slug;

        // Validate
        if (!in_array($type, ['post', 'course'])) {
            return $this->errorResponse(null, 'Loại nội dung không hợp lệ', 400);
        }

        if (!$slug) {
            return $this->errorResponse(null, 'Thiếu slug nội dung', 400);
        }

        // Lấy model theo type
        $modelClass = match ($type) {
            'post' => Post::class,
            'course' => Course::class,
        };

        $record = $modelClass::where('slug', $slug)->select('id')->first();

        if (!$record) {
            return $this->errorResponse(null, 'Nội dung không tồn tại', 404);
        }

        // Lấy danh sách bình luận
        $limit = (int)($request->limit ?? 10);

        $comments = Comment::query()
            ->select(['id', 'description', 'user_id', 'reply_id', 'created_at'])
            ->where('type', $type)
            ->where('type_id', $record->id)
            ->whereNull('reply_id') // chỉ lấy bình luận cha
            ->with([
                'creator:id,full_name,role,avatar',
                'replies' => function ($q) {
                    $q->select(['id', 'description', 'reply_id', 'created_at', 'user_id'])
                        ->with('creator:id,full_name,role,avatar');
                }
            ])
            ->orderByDesc('id')
            ->paginate($limit);

        return $this->successResponse($comments, 'Lấy danh sách bình luận thành công!');
    }

    /**
     * Thêm bình luận mới
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:post,course',
            'slug' => 'required|string',
            'description' => 'required|string|max:1000',
            'reply_id' => 'nullable|exists:comments,id'
        ]);

        $modelClass = match ($request->type) {
            'post' => Post::class,
            'course' => Course::class,
        };

        $record = $modelClass::where('slug', $request->slug)->first();

        if (!$record) {
            return $this->errorResponse(null, 'Nội dung không tồn tại', 404);
        }

        $comment = Comment::create([
            'type' => $request->type,
            'type_id' => $record->id,
            'description' => $request->description,
            'reply_id' => $request->reply_id,
            'user_id' => Auth::id(),
        ]);

        return $this->successResponse($comment, 'Đã đăng bình luận thành công!', 201);
    }

    /**
     * Xem chi tiết 1 bình luận
     */
    public function show(Comment $comment)
    {
        $comment->load('creator:id,full_name,role,avatar', 'replies.creator:id,full_name,role,avatar');

        return $this->successResponse($comment, 'Chi tiết bình luận');
    }

    /**
     * Cập nhật bình luận
     */
    public function update(Request $request, Comment $comment)
    {
        if ($comment->user_id !== Auth::id()) {
            return $this->errorResponse(null, 'Không có quyền chỉnh sửa bình luận này', 403);
        }

        $request->validate([
            'description' => 'required|string|max:1000'
        ]);

        $comment->update([
            'description' => $request->description
        ]);

        return $this->successResponse($comment, 'Cập nhật bình luận thành công!');
    }

    /**
     * Xóa bình luận
     */
    public function destroy(Comment $comment)
    {
        if ($comment->user_id !== Auth::id()) {
            return $this->errorResponse(null, 'Không có quyền xóa bình luận này', 403);
        }

        $comment->delete();

        return $this->successResponse(null, 'Xóa bình luận thành công!');
    }
}
