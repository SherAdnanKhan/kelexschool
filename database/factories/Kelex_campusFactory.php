<?php

namespace Database\Factories;

use App\Models\Kelex_campus;
use Illuminate\Database\Eloquent\Factories\Factory;

class Kelex_campusFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Kelex_campus::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
                'SCHOOL_NAME' => $this->faker->name , 
                'SCHOOL_ADDRESS'=> $this->faker->address, 
                'PHONE_NO'=> $this->faker->e164PhoneNumber,
                'MOBILE_NO'=> $this->faker->phoneNumber,  
                'LOGO_IMAGE'=> '13b73edae8443990be1aa8f1a483bc27.jpg' , 
                'SCHOOL_REG'=> $this->faker->company, 
                'SCHOOL_WEBSITE'=> 'https://marmelab.com/blog/2020/10/21/sunsetting-faker.html' , 
                'SCHOOL_EMAIL'=> $this->faker->freeEmail, 
                'CONTROLLLER'=> $this->faker->name ,
                'USER_ID'=> $this->faker->randomDigit ,
                'CITY_ID'=> $this->faker->postcode  ,
                'TYPE'=> $this->faker->randomElement(['school', 'L_instuition']),
                'BILLING_CHARGE'=> $this->faker->randomNumber(3) ,
                'BILLING_DISCOUNT'=> $this->faker->randomNumber(2),	   
                'DUE_DATE' => $this->faker->date($format = 'Y-m-d', $max = 'now')  ,
                'STATUS' => $this->faker->boolean($chanceOfGettingTrue = 50)  , 
                'SMS_ALLOWED' => $this->faker->boolean($chanceOfGettingTrue = 50)	,
                'AGREEMENT' => $this->faker->boolean($chanceOfGettingTrue = 50)  ,
                'AGREEMENT_DATE'=> $this->faker->date($format = 'Y-m-d', $max = 'now'),
        ];
    }
}
