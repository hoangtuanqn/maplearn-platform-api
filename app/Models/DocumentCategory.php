<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DocumentCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', // <-- sửa lại nếu DB dùng name
        'status',
    ];

    protected $appends = ['total_downloads', 'total_documents']; // tự động thêm vào JSON

    protected $hidden = ['deleted_at'];

    protected $casts = [
        'name' => 'string',
        'status' => 'boolean'
    ];

    public function documents()
    {
        return $this->hasMany(Document::class, 'category_id'); // sửa lại cho đúng với DB
    }

    public function getTotalDownloadsAttribute()
    {
        return (int)$this->documents()->sum('download_count');
    }

    public function getTotalDocumentsAttribute()
    {
        return (int)$this->documents()->count();
    }
}
