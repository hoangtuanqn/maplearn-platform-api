<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DocumentCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'status',
    ];

    // Không hiển thị các cột này khi in ra danh sách
    protected $hidden = [
        'deleted_at'
    ];

    protected $casts = [
        'title' => 'string',
        'status' => 'boolean'
    ];
}
