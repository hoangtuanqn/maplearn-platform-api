<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'thumbnail' => $this->faker->imageUrl(640, 480, 'education', true),
            'user_id' => 1, // Bạn có thể sửa lại random user
            'banner' => $this->faker->imageUrl(800, 200, 'banner', true),
            'subject_id' => 1,
            'audience_id' => 1,
            'category_id' => 1,
            'start_date' => $this->faker->dateTimeBetween('-1 month', '+1 month'),
            'end_date' => $this->faker->dateTimeBetween('+2 months', '+6 months'),
            'status' => 1,
        ];
    }
}
