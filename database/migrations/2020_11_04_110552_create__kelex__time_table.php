<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKelexTimeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kelex_timetables', function (Blueprint $table) {
            $table->id('TIMETABLE_ID');
            $table->string('EMP_ID')->nullable();
            $table->bigInteger('GROUP_ID')->nullable();
            $table->bigInteger('CLASS_ID')->nullable();
            $table->bigInteger('SECTION_ID')->nullable();
            $table->string('SUBJECT_ID')->nullable();
            $table->enum('DAY',['1','2','3','4','5','6','7'])->nullable()->comments('1= Monday 2= Tuesday 3= Wednesday 4= Thursday 5= Friday 6= Saturday 7= Sunday');
            $table->time('TIMEFROM')->nullable();
		    $table->time('TIMETO')->nullable();
            $table->bigInteger('USER_ID')->nullable();
            $table->bigInteger('CAMPUS_ID')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kelex_timetables');
    }
}
