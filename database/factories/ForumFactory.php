<?php

namespace Database\Factories;

use App\Models\Forum;
use App\Models\User;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class ForumFactory extends Factory
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
            'name' => $this->faker->name,
            'description' => implode("\n",$this->faker->paragraphs),
            'last_edited' => $this->faker->dateTimeBetween($created_at, 'now'),
            'profile_picture' => $this->faker->imageUrl(200, 200),
            'banner_picture' => $this->faker->imageUrl(800, 200),
            'owner_id' => User::factory(),
            'hidden' => false
        ];
    }

    /**
     * Indicate that the user has no profile picture.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function no_profile_picture() {
      return $this->state(function (array $attributes) {
          return [
              'profile_picture' => null,
          ];
      });
    }

  /**
   * Indicate that the user has no banner picture.
   *
   * @return \Illuminate\Database\Eloquent\Factories\Factory
   */
    public function no_banner_picture() {
      return $this->state(function (array $attributes) {
          return [
              'banner_picture' => null,
          ];
      });
    }

    public function hidden() {
        return $this->state(function (array $attributes) {
            return [
                'hidden' => true,
            ];
        });
    }
}
