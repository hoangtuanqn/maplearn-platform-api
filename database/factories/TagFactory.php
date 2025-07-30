<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tag>
 */
class TagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement([
                'Toán 10',
                'Toán 11',
                'Toán 12',
                'Vật lý 10',
                'Vật lý 11',
                'Vật lý 12',
                'Hóa học 10',
                'Hóa học 11',
                'Hóa học 12',
                'Sinh học 10',
                'Sinh học 11',
                'Sinh học 12',
                'Ngữ văn 10',
                'Ngữ văn 11',
                'Ngữ văn 12',
                'Lịch sử 10',
                'Lịch sử 11',
                'Lịch sử 12',
                'Địa lý 10',
                'Địa lý 11',
                'Địa lý 12',
                'Tin học 10',
                'Tin học 11',
                'Tin học 12',
                'Tiếng Anh 10',
                'Tiếng Anh 11',
                'Tiếng Anh 12',
            ]),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
