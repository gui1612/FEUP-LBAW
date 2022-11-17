<?php

namespace Database\Seeders;

use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserFactory::new()
            ->count(100)
            ->create();

        UserFactory::new()
            ->count(100)
            ->no_bio()
            ->create();

        UserFactory::new()
            ->count(100)
            ->no_profile_picture()
            ->create();

        UserFactory::new()
            ->count(100)
            ->no_banner_picture()
            ->create();

        UserFactory::new()
            ->count(100)
            ->no_profile_picture()
            ->no_banner_picture()
            ->create();

        UserFactory::new()
            ->count(100)
            ->admin()
            ->create();

        UserFactory::new()
            ->count(100)
            ->blocked()
            ->create();

        UserFactory::new()
            ->count(100)
            ->deleted()
            ->create();
    }
}
