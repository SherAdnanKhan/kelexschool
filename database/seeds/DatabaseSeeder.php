<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ArtSeeder::class);
        $this->call(PrivacyPageTableSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(FeelSeeder::class);
    }
}
