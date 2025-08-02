<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Thêm observer vào model
class GradeLevel extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'slug',
    ];
    function courses()
    {
        return $this->hasMany(Course::class, 'grade_level_id');
    }
    /** @use HasFactory<\Database\Factories\GradeLevelFactory> */
}
