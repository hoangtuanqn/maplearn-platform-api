<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    /** @use HasFactory<\Database\Factories\CourseFactory> */
    use HasFactory;
    protected $hidden = [
        'updated_at',
        'deleted_at'
    ];
    protected $appends = ['creator']; // tự động thêm vào JSON

    public function courseCategory()
    {
        return $this->belongsTo(CourseCategory::class, 'category_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function audience()
    {
        return $this->belongTo(Audience::class);
    }

    public function getCreatorAttribute()
    {
        return $this->creator()->select('id', 'full_name')->get();
    }
}
