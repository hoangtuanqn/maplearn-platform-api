<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamAnswer extends Model
{
    /** @use HasFactory<\Database\Factories\ExamAnswerFactory> */
    use HasFactory;
    protected $fillable = [
        'exam_question_id',
        'content',
        'is_correct',
    ];
    protected $hidden = ['created_at', 'updated_at', 'exam_question_id', 'is_correct'];

    public function question()
    {
        return $this->belongsTo(ExamQuestion::class);
    }
}
