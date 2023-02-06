<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKelexExam extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kelex_exams', function (Blueprint $table) {
            $table->id('EXAM_ID');
            $table->string('EXAM_NAME')->nullable();
            $table->string('START_DATE')->nullable();
            $table->string('END_DATE')->nullable();
            $table->unsignedBigInteger('CAMPUS_ID')->nullable();
            $table->unsignedBigInteger('SESSION_ID')->nullable();
            $table->unsignedBigInteger('USER_ID')->nullable();
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
        Schema::dropIfExists('kelex_examS');
    }
}
