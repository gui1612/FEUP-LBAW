<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Database\Seeder;

class RatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Rating::factory()
            ->count(200)
            ->create();

        Rating::factory()
            ->count(200)
            ->dislike()
            ->create();
    }
}
