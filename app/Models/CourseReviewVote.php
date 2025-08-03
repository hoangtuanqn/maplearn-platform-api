<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseReviewVote extends Model
{
    /** @use HasFactory<\Database\Factories\CourseReviewVoteFactory> */
    use HasFactory;
    protected $fillable = [
        'course_review_id',
        'user_id',
        'vote_type', // 'upvote' or 'downvote'
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
