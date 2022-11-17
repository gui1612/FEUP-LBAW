<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rating>
 */
class RatingFactory extends Factory
{

    public $taken = [];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition() {
        if ($this->taken === []) {
            foreach (Rating::all() as $rating) {
                if (!isset($this->taken[$rating->owner_id])) $this->taken[$rating->owner_id] = [];
                $this->taken[$rating->owner_id][$rating->rated_post_id] = true;
            }
        }

        do {
            $uid = User::inRandomOrder()->first()->id;
            $pid = Post::inRandomOrder()->first()->id;
        } while (isset($this->taken[$uid][$pid]));
        
        if (!isset($uid)) $this->taken[$uid] = [];
        $this->taken[$uid][$pid] = true;

        return [
            'owner_id' => $uid,
            'rated_post_id' => $pid,
            'type' => 'like',
        ];
    }

    public function like() {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'like'
            ];
        });
    }

    public function dislike() {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'dislike'
            ];
        });
    }
}
