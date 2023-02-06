<?php

namespace Database\Factories;
use Illuminate\Support\Str;
use App\Models\Kelex_subject;
use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

class Kelex_subjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Kelex_subject::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */

    public function definition()
    {
        $faker = Faker::create();
        return [
            'SUBJECT_NAME'=> $faker->name,
            'SUBJECT_CODE'=> $faker->hexcolor,
            'CAMPUS_ID'=>$this->faker->numberBetween($min = 1, $max = 10),
            'USER_ID'=>$this->faker->numberBetween($min = 1, $max = 10),

        ];
    }
}
