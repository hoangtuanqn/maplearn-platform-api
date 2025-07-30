<?php

namespace Database\Seeders;

use App\Models\Comment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Comment::factory()->count(10)->create(); // bình luận chính

        // tạo comment con
        $parents = Comment::inRandomOrder()->take(5)->get();

        foreach ($parents as $parent) {
            Comment::factory()->create([
                'reply_id' => $parent->id,
            ]);
        }
    }
}
