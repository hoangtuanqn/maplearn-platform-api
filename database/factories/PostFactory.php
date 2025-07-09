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
        return [
            'title' => $this->faker->sentence(),
            'content' => collect(range(5, 10))->map(function () {
                return '<p>' . $this->faker->paragraph() . '</p>';
            })->implode("\n"),
            'tags_id' => [1, 2, 3, 4, 5],
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
