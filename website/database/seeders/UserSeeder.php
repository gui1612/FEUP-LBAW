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
        // 300 normal users
        UserFactory::new()
            ->count(300)
            ->create();

        // 100 users with no biography
        UserFactory::new()
            ->count(100)
            ->no_bio()
            ->create();

        // 50 users with no profile picture
        UserFactory::new()
            ->count(50)
            ->no_profile_picture()
            ->create();

        // 100 users with no banner picture
        UserFactory::new()
            ->count(100)
            ->no_banner_picture()
            ->create();

        // 170 users with no banner picture and no profile picture
        UserFactory::new()
            ->count(170)
            ->no_profile_picture()
            ->no_banner_picture()
            ->create();

        // 10 users with admin privileges
        UserFactory::new()
            ->count(10)
            ->admin()
            ->create();

        // 20 blocked users
        UserFactory::new()
            ->count(10)
            ->blocked()
            ->create();

        // 50 users with deleted accounts
        UserFactory::new()
            ->count(50)
            ->deleted()
            ->create();
    }
}
