<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
// use App\Models\Kelex_students_session;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
       //  \App\Models\Kelex_campus::factory(10)->create();
        // \App\Models\Kelex_class::factory(10)->create();
        // \App\Models\kelex_section::factory(10)->create();
       // \App\Models\Kelex_sessionbatch::factory(10)->create();
       // \App\Models\Kelex_subject::factory(10)->create();
       \App\Models\Kelex_employee::factory(10)->create();
      \App\Models\Kelex_student::factory(10)->create();
    }
}
