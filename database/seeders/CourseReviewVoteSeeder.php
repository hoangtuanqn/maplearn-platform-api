<?php

namespace Database\Seeders;

use App\Models\CourseReview;
use App\Models\CourseReviewVote;
use App\Models\User;
use Illuminate\Database\Seeder;

class CourseReviewVoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Giả sử bạn đã có một số CourseReview và User trong cơ sở dữ liệu
        $reviews = CourseReview::all();
        $users = User::all();

        foreach ($reviews as $review) {
            foreach ($users->random(13) as $user) {
                CourseReviewVote::create([
                    'course_review_id' => $review->id,
                    'user_id' => $user->id,
                    'is_like' => (bool) rand(0, 1), // Ngẫu nhiên true hoặc false
                ]);
            }
        }
    }
}
