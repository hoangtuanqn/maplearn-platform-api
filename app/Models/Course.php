<?php

namespace App\Models;

use App\Observers\CourseObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([CourseObserver::class])]
class Course extends Model
{
    /** @use HasFactory<\Database\Factories\CourseFactory> */
    use HasFactory;
    protected $fillable = [
        'name',
        'slug',
        'description',
        'thumbnail',
        'intro_video',
        'price',
        'grade_level_id',
        'subject_id',
        'category_id',
        'department_id',
        'start_date',
        'end_date',
        'status',
    ];
    protected $hidden = [
        'updated_at',
        'deleted_at'
    ];
    protected $appends = ['department', 'subject', 'category', 'grade_level']; // tự động thêm vào JSON
    protected $casts = [
        'price' => 'decimal:2',
        'status' => 'boolean',
    ];
    public function courseCategory()
    {
        return $this->belongsTo(CourseCategory::class, 'category_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    // public function audience()
    // {
    //     return $this->belongTo(Audience::class);
    // }
    public function category()
    {
        return $this->belongsTo(CourseCategory::class, 'category_id');
    }
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function getDepartmentAttribute()
    {
        return $this->department()->select('id', 'name')->get();
    }
    public function getSubjectAttribute()
    {
        return $this->subject()->select('id', 'name')->get();
    }

    public function getCategoryAttribute()
    {
        return $this->courseCategory()->select('id', 'name')->get();
    }
    public function gradeLevel()
    {
        return $this->belongsTo(GradeLevel::class, 'grade_level_id');
    }

    // Lấy thông tin grade level
    public function getGradeLevelAttribute()
    {
        return $this->gradeLevel()->select('slug')->first()->slug;
    }
}
