<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    /** @use HasFactory<\Database\Factories\TeacherFactory> */
    use HasFactory;
    protected $fillable = [
        'user_id',
        'department_ids',
        'bio',
        'degree',
    ];
    protected $casts = [
        'department_ids' => 'array',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // List các tổ của giáo viên này
    public function departments()
    {
        return $this->belongsToMany(Department::class);
    }

    // Danh sách khóa học mà giáo viên này dạy
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_teacher');
    }
}
