<?php

namespace App\Models;

use App\Helpers\CommonHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class ExamCategory extends Model
{
    /** @use HasFactory<\Database\Factories\ExamCategoryFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];
    // Các sự kiện event
    protected static function booted()
    {
        static::creating(function ($post) {
            if (empty($post->slug) && isset($post->name)) {
                $post->slug = Str::slug($post->name);
            }
        });
    }
}
