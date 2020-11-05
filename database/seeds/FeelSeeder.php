<?php

use Illuminate\Database\Seeder;

class FeelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('feels')->delete();
        DB::table('feels')->insert([
            'id' => 1,
            'name'=> 'gold',
            'color'=> 'gold',
            'description' => 'Happy',
            'color_code'=> '#FFD700',
            'image_path'=> asset('images/feelicons/iconyellow.png'),
            //'image_path'=> 'http://localhost:8000/images/feelicons/iconyellow.png',
        ]);
        DB::table('feels')->insert([
            'id' => 2,
            'name'=> 'gray',
            'description' => 'Confused',
            'color'=> 'gray',
            'color_code'=> '#808080',
            'image_path'=> asset('images/feelicons/icongray.png'),
            //'image_path'=> 'http://localhost:8000/images/feelicons/icongray.png',

        ]);
        DB::table('feels')->insert([
            'id' => 3,
            'name'=> 'orange',
            'description' => 'Excited',
            'color'=> 'orange',
            'color_code'=> '#FFA500',
            'image_path'=> asset('images/feelicons/iconorange.png'),
            //'image_path'=> 'http://localhost:8000/images/feelicons/iconorange.png',

        ]);
        DB::table('feels')->insert([
            'id' => 4,
            'name'=> 'green',
            'description' => 'Serene',
            'color'=> 'limegreen',
            'color_code'=> '#32CD32',
            'image_path'=> asset('images/feelicons/icongreen.png'),
            //'image_path'=> 'http://localhost:8000/images/feelicons/icongreen.png',
        ]);
        DB::table('feels')->insert([
            'id' => 5,
            'name'=> 'red',
            'description' => 'Angry',
            'color'=> 'red',
            'color_code'=> '#FF0000',
            'image_path'=> asset('images/feelicons/iconred.png'),
            //'image_path'=> 'http://localhost:8000/images/feelicons/iconred.png',

        ]);
        DB::table('feels')->insert([
            'id' => 6,
            'name'=> 'purple',
            'description' => 'Inspired',
            'color'=> 'purple',
            'color_code'=> '#800080',
            'image_path'=> asset('images/feelicons/iconpurple.png'),
            //'image_path'=> 'http://localhost:8000/images/feelicons/iconpurple.png',

        ]);
        DB::table('feels')->insert([
            'id' => 7,
            'name'=> 'blue',
            'description' => 'Sad',
            'color'=> 'dodgerblue',
            'color_code'=> '#1E90FF',
            'image_path'=> asset('images/feelicons/iconblue.png'),
            //'image_path'=> 'http://localhost:8000/images/feelicons/iconblue.png',
        ]);
    }
}
