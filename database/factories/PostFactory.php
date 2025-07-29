<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $realPosts = [
            [
                'title' => 'Gợi ý đáp án môn Toán tốt nghiệp THPT 2025',
                'thumbnail' => 'https://mapstudy.sgp1.digitaloceanspaces.com/blog/7a057s902und/7hatq8803p2l-1750848712712.png',
            ],
            [
                'title' => 'Gợi ý đáp án môn Hoá Học tốt nghiệp THPT 2025',
                'thumbnail' => 'https://mapstudy.sgp1.digitaloceanspaces.com/blog/7a0d62t02mdp/7hat6xi0419y-1750848687702.png',
            ],
            [
                'title' => 'Gợi ý đáp án môn Vật Lý tốt nghiệp THPT 2025',
                'thumbnail' => 'https://mapstudy.sgp1.digitaloceanspaces.com/blog/7a0e2zr02ujf/7hasxl303w2q-1750848675591.png',
            ],
            [
                'title' => 'Gợi ý đáp án môn Tiếng Anh tốt nghiệp THPT 2025',
                'thumbnail' => 'https://mapstudy.sgp1.digitaloceanspaces.com/blog/7a0f2ev02hmv/7hasmqx03xfi-1750848661545.png',
            ],
            [
                'title' => 'Gợi ý đáp án môn Toán tốt nghiệp THPT 2024',
                'thumbnail' => 'https://mapstudy.sgp1.digitaloceanspaces.com/blog/sn4cz9w00ew1/sse7ts8006kv-1718867802248.jpg',
            ],
        ];

        $real = $this->faker->randomElement($realPosts);
        return [
            // 'slug' => $this->faker->slug(),
            'title' => $real['title'],
            'content' => collect(range(5, 10))->map(function () {
                return '<p>' . $this->faker->paragraph() . '</p>';
            })->implode("\n"),
            'thumbnail' => $real['thumbnail'],
            'tags_id' => [1, 2, 3, 4, 5],
            'created_at' => now(),
            'updated_at' => now(),
            'created_by' => 1
        ];
    }
}
