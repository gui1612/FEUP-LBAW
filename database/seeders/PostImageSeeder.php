<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\PostImage;
use Illuminate\Database\Seeder;

class PostImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = Post::all();

        PostImage::factory()
            ->recycle($posts)
            ->count(200)
            ->create();

        PostImage::factory()
            ->recycle($posts)
            ->count(200)
            ->landscape()
            ->create();

        PostImage::factory()
            ->recycle($posts)
            ->count(200)
            ->tall()
            ->create();
    }
}
