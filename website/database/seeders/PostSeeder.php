<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $users = User::all();

        Post::factory()
            ->recycle($users)
            ->count(400)
            ->create();
        
        Post::factory()
            ->recycle($users)
            ->count(400)
            ->long()
            ->create();

        Post::factory()
            ->recycle($users)
            ->count(400)
            ->hidden()
            ->create();

        Post::factory()
            ->recycle($users)
            ->count(400)
            ->long()
            ->hidden()
            ->create();
    }
}
