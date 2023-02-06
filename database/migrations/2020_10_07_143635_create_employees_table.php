<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kelex_employees', function (Blueprint $table) {
            $table->id('EMP_ID');
            $table->bigInteger('EMP_NO')->nullable();
            $table->string('EMP_NAME',100)->nullable();
            $table->string('FATHER_NAME',100)->nullable();
            $table->enum('GENDER',["Male","Female"])->nullable();
            $table->string('CNIC',100)->nullable();
            $table->bigInteger('DESIGNATION_ID')->nullable();
            $table->string('QUALIFICATION')->nullable();
            $table->enum('EMP_TYPE',['1','2'])->nullable()->comment('1=teaching staff, 2= non-teaching staff');
            $table->string('ADDRESS')->nullable();
            $table->string('PASSWORD',100)->nullable();
            $table->string('EMP_IMAGE',250)->nullable();
            $table->bigInteger('CREATED_BY')->nullable();
            $table->dateTime('JOINING_DATE')->nullable();
            $table->dateTime('LEAVING_DATE')->nullable();
            $table->dateTime('EMP_DOB')->nullable();
            $table->string('ALLOWANCESS')->nullable();
            $table->bigInteger('ADDED_BY')->nullable();
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
        Schema::dropIfExists('kelex_employees');
    }
}
