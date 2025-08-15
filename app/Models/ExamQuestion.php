<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamQuestion extends Model
{
    /** @use HasFactory<\Database\Factories\ExamQuestionFactory> */
    use HasFactory;
    protected $fillable = [
        'exam_paper_id',
        'type',
        'content',
        'marks',
        'explanation',
        'images'
    ];
    protected $casts = [
        'marks' => 'float',
        'images' => 'array'
    ];
    protected $hidden = ['created_at', 'updated_at',];

    public function answers()
    {
        return $this->hasMany(ExamAnswer::class);
    }
    public function examPaper()
    {
        return $this->belongsTo(ExamPaper::class);
    }
}
