<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Comment::class;
    public function definition(): array
    {
        $types = ['post']; // enum giả định

        return [
            'user_id'    => User::inRandomOrder()->first()?->id ?? 1,
            'type'       => $this->faker->randomElement($types),
            'type_id'    => $this->faker->numberBetween(1, 10),
            'description' => $this->faker->paragraph,
            'reply_id'   => null, // bạn có thể thêm logic reply ngẫu nhiên nếu muốn
        ];
    }
}
