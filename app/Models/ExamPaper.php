<?php

namespace App\Models;

use App\Helpers\CommonHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamPaper extends Model
{
    /** @use HasFactory<\Database\Factories\ExamPaperFactory> */
    use HasFactory;
    protected $fillable = [
        'exam_category_id',
        'subject_id',
        'grade_level',
        'title',
        'slug',
        'province',
        'difficulty',
        'exam_type',
        'max_score',
        'duration_minutes',
        'anti_cheat_enabled',
        'max_violation_attempts',
        'status'
    ];
    protected $casts = [
        'max_score' => 'float',
        'duration_minutes' => 'integer',
        'anti_cheat_enabled' => 'boolean',
        'max_violation_attempts' => 'integer',
        'status' => 'boolean',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    // Liên kết khóa ngoại
    public function examCategory()
    {
        return $this->belongsTo(ExamCategory::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function gradeLevel()
    {
        return $this->belongsTo(GradeLevel::class);
    }

    // Các sự kiện event
    protected static function booted()
    {
        static::creating(function ($post) {
            if (empty($post->slug) && isset($post->title)) {
                $post->slug = CommonHelper::generateSlug($post->title);
            }
        });
    }
}
