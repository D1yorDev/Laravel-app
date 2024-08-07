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
            "user_id" => 1,
            "category_id" => rand(1,5),
            "title" => $this->faker->title(1),
            "short_content" => $this->faker->text(10),
            "content" => $this->faker->paragraph(25),
        ];
    }
}
