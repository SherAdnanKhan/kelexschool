<?php

namespace Database\Factories;

use App\Models\Kelex_month;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;


class Kelex_monthFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Kelex_month::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = Faker::create();
        return [
           'NUMBER' => $faker->month(0),
           'MONTH' =>$faker->monthName(),
           'TYPE' => 1,
           'CAMPUS_ID' => 2,
        ];
    }
}
