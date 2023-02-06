<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class KelexWidthdrawStudent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kelex_withdraw_students', function (Blueprint $table) {
            $table->id('STD_WITHDRAW_ID');
            $table->bigInteger('STUDENT_ID')->nullable();
            $table->bigInteger('SESSION_ID')->nullable();
            $table->bigInteger('CLASS_ID')->nullable();
            $table->bigInteger('SECTION_ID')->nullable();
            $table->dateTime('WITHDRAW_DATE')->nullable();
            $table->enum('STATUS',['1','2'])->nullable()->comment('1=WITHDRAW,2=ROLLBACK');
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
        Schema::dropIfExists('kelex_withdraw_students');
    }
}
