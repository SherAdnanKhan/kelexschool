<?php

namespace Database\Factories;

use App\Models\kelex_section;
use Illuminate\Database\Eloquent\Factories\Factory;

class kelex_sectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = kelex_section::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'Section_name'=> $this->faker->name,
            'Class_id'=> $this->faker->numberBetween($min = 1, $max = 10),
            'CAMPUS_ID'=> $this->faker->numberBetween($min = 1, $max = 10),
            'USER_ID'=> $this->faker->numberBetween($min = 1, $max = 10),
        ];
    }
}
