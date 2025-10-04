<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessonViewHistory extends Model
{
    /** @use HasFactory<\Database\Factories\LessonViewHistoryFactory> */
    use HasFactory;
    protected $fillable = [
        'user_id',
        'lesson_id',
        'watched_at',
        'progress',
        'is_completed',
        'updated_at'
    ];

    public function lesson()
    {
        return $this->belongsTo(CourseLesson::class, 'lesson_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function chapter()
    {
        return $this->belongsTo(CourseChapter::class, 'chapter_id');
    }
}
