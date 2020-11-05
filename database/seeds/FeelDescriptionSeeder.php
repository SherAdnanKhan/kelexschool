<?php

use Illuminate\Database\Seeder;

class FeelDescriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $feels = App\Models\Feel::all();
        foreach ($feels as $feel) {
            $feel_updation = App\Models\Feel::find($feel->id); 
            if($feel->id == 1) {
               $feel_updation->description = "Happy";
            }
            else if($feel->id == 2) {
                $feel_updation->description = "Confused";
            }
            else if($feel->id == 3) {
                $feel_updation->description = "Excited";
            }
            else if($feel->id == 4) {
                $feel_updation->description = "Serene";
            }
            else if($feel->id == 5) {
                $feel_updation->description = "Angry";
            }
            else if($feel->id == 6) {
                $feel_updation->description = "Inspired";
            }
            else {
                $feel_updation->description = "Sad";
            }

            $feel_updation->update();

        }
    }
}
