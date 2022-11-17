<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = 'resources/sql/seed.sql';
        DB::unprepared(file_get_contents($path));
        // DB::unprepared(file_get_contents('resources/sql/populate.sql'));
        $this->call([
            UserSeeder::class,
            PostSeeder::class,
            PostImageSeeder::class,
            RatingSeeder::class
        ]);
        
        $this->command->info('Database seeded!');
    }
}
