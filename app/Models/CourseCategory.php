<?php

namespace App\Models;

use App\Observers\CourseCategoryObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([CourseCategoryObserver::class])]

class CourseCategory extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    // protected $table = 'course_categories';
    use HasFactory;

    protected $fillable = [
        'name',
        'created_by',
        'status',
    ];

    // Dùng Document::find(1)->makeVisible('tags_id'); để hiển thị lại ở 1 số chỗ nếu cần
    // Nó chỉ ẩn khi output, k ảnh hưởng khi dùng code trong PHP
    protected $appends = ['count_courses']; // tự động thêm vào JSON

    protected $hidden = [
        'created_by',
        'updated_at',
        'deleted_at'
    ];
    protected $casts = [
        'status' => 'boolean'
    ];


    public function courses()
    {
        return $this->hasMany(Course::class, 'category_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function getCountCoursesAttribute()
    {
        return $this->courses()->count();
    }
}
