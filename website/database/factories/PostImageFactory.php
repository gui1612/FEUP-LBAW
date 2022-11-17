<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PostImage>
 */
class PostImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'path' => $this->faker->imageUrl(400, 400),
            'caption' => $this->faker->sentence(20),
            'post_id' => Post::factory()
        ];
    }

    public function landscape() {
        return $this->state(function (array $attributes) {
            return [
                'path' => $this->faker->imageUrl(800, 400)
            ];
        });
    }

    public function tall() {
        return $this->state(function (array $attributes) {
            return [
                'path' => $this->faker->imageUrl(400, 800)
            ];
        });
    }
}
