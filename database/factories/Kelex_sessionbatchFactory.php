<?php

namespace Database\Factories;

use App\Models\Kelex_sessionbatch;
use Illuminate\Database\Eloquent\Factories\Factory;

class Kelex_sessionbatchFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Kelex_sessionbatch::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
           'SB_NAME' => $this->faker->name,
           'START_DATE'=>$this->faker->date($format = 'Y-m-d', $max = 'now') ,
           'END_DATE'=>$this->faker->date($format = 'Y-m-d', $max = 'now') ,
           'TYPE'=> $this->faker->boolean($chanceOfGettingTrue = 50) ,
           'CAMPUS_ID'=>$this->faker->numberBetween($min = 1, $max = 10),
           'USER_ID'=>$this->faker->numberBetween($min = 1, $max = 10),
        ];
    }
}
