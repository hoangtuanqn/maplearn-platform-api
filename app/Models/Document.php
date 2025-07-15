<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'title',
        'views',
        'source',
        'tags_id',
        'created_by',
        'category_id',
        'status',
    ];

    // Dùng Document::find(1)->makeVisible('tags_id'); để hiển thị lại ở 1 số chỗ nếu cần
    // Nó chỉ ẩn khi output, k ảnh hướng khi dùng code trong PHP
    protected $appends = ['tags', 'creator']; // tự động thêm vào JSON

    protected $hidden = [
        'category_id',
        'created_by',
        'tags_id',
        'deleted_at'
    ];

    protected $casts = [
        'views' => 'integer',
        'tags_id' => 'array',
        'status' => 'boolean'
    ];

    public function category()
    {
        return $this->belongsTo(DocumentCategory::class, 'category_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getTagsAttribute()
    {
        return Tag::whereIn('id', $this->tags_id ?? [])->select('id', 'name', 'created_at')->get();
    }

    public function getCreatorAttribute()
    {
        return $this->creator()->select('id', 'full_name')->get();
    }
}
