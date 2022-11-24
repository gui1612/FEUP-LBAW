<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() {
        $username = $this->faker->unique()->userName;
        return [
            'created_at' => $this->faker->dateTimeBetween('-2 year', 'now'),
            'email' => $username . '@example.com',
            'password' => bcrypt($username),
            'username' => $username,
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'bio' => $this->faker->paragraph(),
            'block_reason' => null,
            'profile_picture' => $this->faker->imageUrl(200, 200),
            'banner_picture' => $this->faker->imageUrl(800, 200),
            'is_admin' => false
        ];
    }

    /**
     * Indicate that the user has no biography.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function no_bio() {
        return $this->state(function (array $attributes) {
            return [
                'bio' => null,
            ];
        });
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

    /**
     * Indicate that the user is an admin.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function admin() {
        return $this->state(function (array $attributes) {
            return [
                'is_admin' => true,
            ];
        });
    }

    /**
     * Indicate that the user is blocked.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function blocked() {
        return $this->state(function (array $attributes) {
            return [
                'block_reason' => $this->faker->paragraph(),
            ];
        });
    }

    /**
     * Indicate that the user has deleted their account.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function deleted() {
        return $this->state(function (array $attributes) {
            return [
                'email' => null,
                'password' => null,
                'first_name' => null,
                'last_name' => null,
                'bio' => null,
                'profile_picture' => null,
                'banner_picture' => null,
            ];
        })->afterCreating(function (User $user) {
            $user->username = '[deleted user #' . $user->id . ']';
            $user->save();
        });
    }
}
