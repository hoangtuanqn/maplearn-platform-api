<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseReviewVote extends Model
{
    /** @use HasFactory<\Database\Factories\CourseReviewVoteFactory> */
    use HasFactory;
    protected $table = 'course_review_votes'; // Specify the table name if different from the default
    protected $fillable = [
        'course_review_id',
        'user_id',
        'is_like', // 'upvote' or 'downvote'
    ];
    protected $casts = [
        'is_like' => 'boolean', // true for upvote, false for downvote
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function review()
    {
        return $this->belongsTo(CourseReview::class, 'course_review_id');
    }
}
