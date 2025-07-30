<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    // Không hiển thị các cột này khi in ra danh sách
    protected $hidden = [
        'deleted_at'
    ];
}
