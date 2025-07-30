<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'title',
        'download_count',
        'source',
        'tags_id',
        'created_by',
        'category_id',
        'status',
    ];

    // Dùng Document::find(1)->makeVisible('tags_id'); để hiển thị lại ở 1 số chỗ nếu cần
    // Nó chỉ ẩn khi output, k ảnh hưởng khi dùng code trong PHP

    // 'category' => khi cần thi thêm vô appends
    protected $appends = ['tags', 'creator']; // tự động thêm vào JSON

    protected $hidden = [
        // 'category_id',
        'created_by',
        'tags_id',
        'deleted_at',
        'updated_at',
    ];

    protected $casts = [
        'download_count' => 'integer',
        'tags_id' => 'array',
        'status' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(DocumentCategory::class, 'category_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Lấy danh sách tag theo id
    public function getTagsAttribute()
    {
        return Tag::whereIn('id', $this->tags_id ?? [])->select('id', 'name', 'created_at')->get();
    }

    // Lấy thông tin người tạo
    public function getCreatorAttribute()
    {
        return $this->creator()->select('id', 'full_name')->first();
    }

    // Lấy thông tin category
    public function getCategoryAttribute()
    {
        return $this->category()->select('id', 'name')->first();
    }

    // Scope lấy document active
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }
}
