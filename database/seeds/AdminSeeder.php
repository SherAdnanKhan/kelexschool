<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('admins')->delete();
        DB::table('admins')->insert([
            'id' => 1,
            'username'=> 'Administrator',
            'first_name'=> 'Admin',
            'last_name'=> 'Meuzum',
            'email'=> 'admin@meuzum.com',
            'password'=> \Hash::make("admin@123"),
        ]);
    }
}
