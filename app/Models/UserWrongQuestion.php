<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWrongQuestion extends Model
{
    /** @use HasFactory<\Database\Factories\UserWrongQuestionFactory> */
    use HasFactory;
    protected $fillable = [
        'user_id',
        'exam_question_id',
        'wrong_count',
        'correct_streak',
        'first_wrong_at',
        'last_wrong_at',
        'last_correct_at',
        'status',
    ];

    protected $casts = [
        'wrong_count' => 'integer',
        'first_wrong_at' => 'datetime',
        'last_wrong_at' => 'datetime',
        'last_correct_at' => 'datetime',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    // Câu hỏi
    public function question()
    {
        return $this->belongsTo(ExamQuestion::class, 'exam_question_id');
    }
}
