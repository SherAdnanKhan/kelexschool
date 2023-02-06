<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kelex_employee_attendances', function (Blueprint $table) {
            $table->id('EMP_ATTENDANCE_ID');
            $table->bigInteger('EMPLOYEE_ID')->nullable();
            $table->dateTime('ATTEN_DATE');
            $table->enum('ATTEN_STATUS',['A','P','L','SL','PL'])->nullable();
            $table->dateTime('CHECK_IN')->nullable();
            $table->dateTime('CHECK_OUT')->nullable();
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
        Schema::dropIfExists('employee_attendances');
    }
}
