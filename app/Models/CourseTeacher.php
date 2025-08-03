<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseTeacher extends Model
{
    /** @use HasFactory<\Database\Factories\CourseTeacherFactory> */
    use HasFactory;
    protected $table = 'course_teacher';
    protected $fillable = [
    'course_id',
        'teacher_id',
    ];
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
