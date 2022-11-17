<?php

namespace Database\Factories;

use App\Models\Forum;
use App\Models\User;
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
    public function definition()
    {
        $created_at = $this->faker->dateTimeBetween('-2 year', 'now');

        return [
            'created_at' => $created_at,
            'last_edited' => $this->faker->dateTimeBetween($created_at, 'now'),
            'title' => $this->faker->sentence,
            'body' => implode("\n", $this->faker->paragraphs),
            'owner_id' => User::factory(),
            'hidden' => false
        ];
    }

    public function long() {
        return $this->state(function (array $attributes) {
            return [
                'body' => implode("\n", $this->faker->paragraphs(10))
            ];
        });
    }

    public function hidden() {
        return $this->state(function (array $attributes) {
            return [
                'hidden' => true
            ];
        });
    }
}
