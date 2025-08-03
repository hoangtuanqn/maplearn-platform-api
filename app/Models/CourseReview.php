<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseReview extends Model
{
    /** @use HasFactory<\Database\Factories\CourseReviewFactory> */
    use HasFactory;
    protected $fillable = [
        'course_id',
        'user_id',
        'rating',
        'comment',
    ];
    protected $casts = [
        'rating' => 'integer',
    ];
    // user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // Course
    public function courses()
    {
        return $this->belongsTo(Course::class);
    }
    public function votes()
    {
        return $this->hasMany(CourseReviewVote::class);
    }

    public function likes()
    {
        return $this->votes()->where('is_like', true);
    }

    public function dislikes()
    {
        return $this->votes()->where('is_like', false);
    }
}
