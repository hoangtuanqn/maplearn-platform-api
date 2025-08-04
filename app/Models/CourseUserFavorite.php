<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseUserFavorite extends Model
{
    /** @use HasFactory<\Database\Factories\CourseUserFavoriteFactory> */
    use HasFactory;
    protected $fillable = [
        'user_id',
        'course_id',
    ];

}
