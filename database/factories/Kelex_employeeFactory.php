<?php

namespace Database\Factories;
use Faker\Factory as Faker;
use App\Models\Kelex_employee;
use Illuminate\Database\Eloquent\Factories\Factory;

class Kelex_employeeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Kelex_employee::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = Faker::create();
        return [
            'EMP_NO'=> $faker->ein ,
            'EMP_NAME'=> $faker->name ,
            'FATHER_NAME'=> $faker->name ,
            'GENDER'=>  $this->faker->randomElement(['Male', 'Female']),
            'CNIC'=> $faker->uuid,
            'DESIGNATION_ID'=> $faker->uuid,
            'QUALIFICATION'=> $faker->buildingNumber ,
            'EMP_TYPE'=> $this->faker->randomElement(['1', '2']),
            'ADDRESS'=> $faker-> address,
            'PASSWORD'=> $faker->password ,
            'EMP_IMAGE'=> "12123.jpg",
            'CREATED_BY'=> $this->faker->numberBetween($min = 1, $max = 10),
            'JOINING_DATE'=> $this->faker->date($format = 'Y-m-d', $max = 'now') ,
            'LEAVING_DATE'=> $this->faker->date($format = 'Y-m-d', $max = 'now') ,
            'EMP_DOB'=>  $this->faker->date($format = 'Y-m-d', $max = 'now')  ,
            'ALLOWANCESS'=> $this->faker->randomNumber(3) ,
            'ADDED_BY'=> $this->faker->numberBetween($min = 1, $max = 10),
            'CAMPUS_ID' => $this->faker->numberBetween($min = 1, $max = 10),
        ];
    }
}
