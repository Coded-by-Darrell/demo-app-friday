<?php

// database/seeders/DatabaseSeeder.php
// Tutorial #Seeding: Database seeding

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            ServiceCategorySeeder::class,
            ServiceSeeder::class,
            TeamMemberSeeder::class,
            ContactSeeder::class,
            SettingsSeeder::class,
        ]);
    }
}






