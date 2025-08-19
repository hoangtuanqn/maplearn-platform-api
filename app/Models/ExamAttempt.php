<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamAttempt extends Model
{

    use HasFactory;
    protected $fillable = [
        'exam_paper_id',
        'user_id',
        'score',
        'violation_count',
        'time_spent',
        'details',
        'started_at',
        'submitted_at',
        'status',
        'note'
    ];
    protected $casts = [
        'score' => 'float',
        'details' => 'array',
        'started_at' => 'datetime',
        'submitted_at' => 'datetime',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function paper()
    {
        return $this->belongsTo(ExamPaper::class);
    }
}
