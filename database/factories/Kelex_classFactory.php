<?php

namespace Database\Factories;

use App\Models\Kelex_class;
use Illuminate\Database\Eloquent\Factories\Factory;

class Kelex_classFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Kelex_class::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'class_name'=> $this->faker->name,
            'CAMPUS_ID'=> $this->faker->numberBetween($min = 1, $max = 10),
            'USER_ID'=> $this->faker->numberBetween($min = 1, $max = 10),

        ];
    }
}
