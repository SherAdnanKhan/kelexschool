<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * 
     * @return void
     */
    public function up()
    {
        Schema::create('kelex_student_applications', function (Blueprint $table) {
            $table->id('STD_APPLICATION_ID');
            $table->bigInteger('STUDENT_ID')->nullable();
            $table->enum('APPLICATION_STATUS',['0','1','2'])->nullable()->comments('0=pending,1=approved,2=rejected');
            $table->enum('APPLICATION_TYPE',['L','SL','HL','H'])->nullable();
            $table->text('APPLICATION_DESCRIPTION')->nullable();
            $table->date('START_DATE')->nullable();
            $table->date('END_DATE')->nullable();
            $table->date('APPROVED_AT')->nullable();
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
        Schema::dropIfExists('kelex_student_applications');
    }
}
