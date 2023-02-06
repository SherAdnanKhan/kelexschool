<?php

namespace Database\Factories;

use App\Models\Kelex_student;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;
class Kelex_studentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Kelex_student::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = Faker::create();
        return [
            'NAME'=> $faker->name,
            'FATHER_NAME'=> $faker->name,
            'FATHER_CONTACT'=> $this->faker->phoneNumber,
            'SECONDARY_CONTACT'=> $this->faker->phoneNumber,
            'GENDER'=> $this->faker->randomElement(['Male', 'Female']),
            'DOB'=>  $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'CNIC'=>  $faker->uuid,
            'RELIGION'=> $faker->creditCardType,
            'FATHER_CNIC'=> $faker->uuid,

            'SHIFT'=> $this->faker->randomElement(['1', '2']),
            'PRESENT_ADDRESS'=> $faker->address,
            'PERMANENT_ADDRESS'=> $faker->address,
            'GUARDIAN'=> $faker->name,
            'STD_PASSWORD'=> $faker->password,
            'GUARDIAN_CNIC'=> $faker->uuid,
            'IMAGE'=> '123.jpg',
            'PREV_CLASS'=>  $this->faker->numberBetween($min = 1, $max = 10),
            'SLC_NO'=>  $this->faker->numberBetween($min = 200, $max = 3000),
            'PREV_CLASS_MARKS'=>  $this->faker->numberBetween($min = 200, $max = 1000),
            'PREV_BOARD_UNI'=> $faker->colorName,
            'PASSING_YEAR'=>  $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'REG_NO'=> $this->faker->numberBetween($min = 50, $max = 1000),
            'CAMPUS_ID'=> $this->faker->numberBetween($min = 1, $max = 10),
            'USER_ID'=> $this->faker->numberBetween($min = 1, $max = 10),
        ];
    }
}
