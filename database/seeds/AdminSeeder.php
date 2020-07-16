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
        DB::table('admin')->insert([
            'username'=> 'Administrator',
            'first_name'=> 'Admin',
            'last_name'=> 'Meuzum',
            'email'=> 'admin@meuzum.com',
            'password'=> bcrypt('admin@123'),
        ]);
    }
}
