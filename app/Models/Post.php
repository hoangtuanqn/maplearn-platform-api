<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'content',
        'views',
        'tags_id',
        'status'
    ];
    protected $casts = [
        'views' => 'integer',
        'tags_id' => 'array',
        'status' => 'boolean'
    ];
}
