<?php

namespace Database\Factories;
use App\Models\Kelex_students_session;
use Illuminate\Database\Eloquent\Factories\Factory;

class Kelex_students_sessionsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Kelex_students_session::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
           'STUDENT_ID' => range(2,200),
           'SESSION_ID' => 1,
           'CLASS_ID' => range(1,10),
           'SECTION_ID' => range(1,200),
           'ROLE_NO' => range(2,200),
           'USER_ID' => 3,
           'CAMPUS_ID' => 2,

        ];
    }
}
