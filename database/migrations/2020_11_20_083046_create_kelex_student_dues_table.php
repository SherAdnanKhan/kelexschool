<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKelexStudentDuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kelex_student_dues', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('STUDENT_ID')->nullable();
            $table->unsignedBigInteger('FEE_ID')->nullable();
            $table->double('AMOUNT',10,2)->nullable();
            $table->enum('TYPE',[1,2])->nullable()->comment('1=Balance,2=Criedt');
            $table->unsignedBigInteger('CAMPUS_ID')->nullable();
            $table->unsignedBigInteger('USER_ID')->nullable();
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
        Schema::dropIfExists('kelex_student_dues');
    }
}
