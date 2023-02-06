<?php

use Illuminate\Database\Seeder;

class UpdatePrivacyPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('privacy_pages')->where('name', 'Stro')->update(['name' => 'Strq']);
    }
}
