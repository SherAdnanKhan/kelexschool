<?php

use Illuminate\Database\Seeder;
use App\Models\PrivacyType;

class PrivacyTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('privacy_types')->delete();

        //PrivacyType::create(array('id' => 1, 'name' => 'Every One', 'description' => 'Show it to everyone'));
        //PrivacyType::create(array('id' => 2, 'name' => 'Faves', 'description' => 'User to Select Fave'));
        //PrivacyType::create(array('id' => 3, 'name' => 'SPRFVS', 'description' => 'User to Select SPRFV to send requests'));
        //PrivacyType::create(array('id' => 4, 'name' => 'Invite Only', 'description' => 'User who ask to show them'));
    }
}
