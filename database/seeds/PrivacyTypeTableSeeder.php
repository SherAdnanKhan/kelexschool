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
        PrivacyType::create(array('name' => 'Every One', 'description' => 'Show it to everyone'));
        PrivacyType::create(array('name' => 'Faves', 'description' => 'User to Select Fave'));
        PrivacyType::create(array('name' => 'SPRFVS', 'description' => 'User to Select SPRFV to send requests'));
        PrivacyType::create(array('name' => 'Invite Only', 'description' => 'User who ask to show them'));
    }
}
