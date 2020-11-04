<?php

use Illuminate\Database\Seeder;
use App\Models\PrivacyType;
use App\Models\PrivacyPage;
use App\Models\UserPrivacy;

class PrivacyPageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('privacy_types')->delete();

        PrivacyType::create(array('id' => 1, 'name' => 'Every One', 'description' => 'Show it to everyone'));
        PrivacyType::create(array('id' => 2, 'name' => 'Faves', 'description' => 'User to Select Fave'));
        PrivacyType::create(array('id' => 3, 'name' => 'SPRFVS', 'description' => 'User to Select SPRFV to send requests'));
        PrivacyType::create(array('id' => 4, 'name' => 'Invite Only', 'description' => 'User who ask to show them'));
        
        \DB::table('privacy_pages')->delete();
        
        PrivacyPage::create(array('id' => 1, 'name' => 'Strq'));
        PrivacyPage::create(array('id' => 2, 'name' => 'Mzflash'));
        PrivacyPage::create(array('id' => 3, 'name' => 'Critiques'));
        PrivacyPage::create(array('id' => 4, 'name' => 'Faves'));
        PrivacyPage::create(array('id' => 5, 'name' => 'Faved By'));
        PrivacyPage::create(array('id' => 6, 'name' => 'Online Active'));
        PrivacyPage::create(array('id' => 7, 'name' => 'Bio'));

        //to test on local privacy
        // \DB::table('user_privacy')->delete();
        // UserPrivacy::create(array('id' => 1, 'privacy_type' => 'App\Models\Gallery', 'privacy_id' => 1, 'user_id' => 2, 'privacy_type_id' => 3));
        // UserPrivacy::create(array('id' => 2, 'privacy_type' => 'App\Models\PrivacyPage', 'privacy_id' => 3, 'user_id' => 2, 'privacy_type_id' => 1));


    }
}
