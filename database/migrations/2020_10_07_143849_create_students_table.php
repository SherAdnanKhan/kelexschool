<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kelex_students', function (Blueprint $table) {
            $table->id('STUDENT_ID');
            $table->string('NAME',100)->nullable();
            $table->string('FATHER_NAME',100)->nullable();
            $table->string('FATHER_CONTACT',100)->nullable();
            $table->string('SECONDARY_CONTACT',100)->nullable();
            $table->enum('GENDER',['Male','Female'])->nullable();
            $table->date('DOB')->nullable();
            $table->string('CNIC',100)->nullable();
            $table->string('RELIGION',100)->nullable();
            $table->string('FATHER_CNIC',100)->nullable();
            $table->enum('SHIFT',['1','2'])->nullable()->comments('1= Morning 2= Evening');
            $table->text('PRESENT_ADDRESS')->nullable();
            $table->string('STD_PASSWORD')->nullable();
            $table->text('PERMANENT_ADDRESS')->nullable();
            $table->string('GUARDIAN',100)->nullable();
            $table->string('GUARDIAN_CNIC',100)->nullable();
            $table->string('IMAGE',100)->nullable();
            $table->bigInteger('REG_NO')->nullable();
            $table->bigInteger('PREV_CLASS')->nullable();
            $table->bigInteger('SLC_NO')->nullable();
            $table->string('PREV_CLASS_MARKS')->nullable();
            $table->string('PREV_BOARD_UNI')->nullable();
            $table->date('PASSING_YEAR')->nullable();
            $table->bigInteger('CAMPUS_ID')->nullable();
            $table->bigInteger('USER_ID')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('kelex_students');
    }
}
