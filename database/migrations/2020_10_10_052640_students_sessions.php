<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class StudentsSessions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kelex_students_sessions', function (Blueprint $table) {
            $table->id('STD_SESSION_ID');
            $table->bigInteger('SESSION_ID')->nullable();
            $table->bigInteger('CLASS_ID')->nullable();
            $table->bigInteger('SECTION_ID')->nullable();
            $table->enum('IS_ACTIVE',['0','1'])->nullable()->comment('0=inActive,1=Active');
            $table->bigInteger('STUDENT_ID')->nullable();
            $table->bigInteger('ROLL_NO')->nullable();
            $table->bigInteger('CAMPUS_ID')->nullable();
            $table->bigInteger('USER_ID')->nullable();
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
        Schema::dropIfExists('kelex_students_sessions');
    }
}
