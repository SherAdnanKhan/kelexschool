<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubjectMarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kelex_subject_marks', function (Blueprint $table) {
            $table->id('MARKS_ID');
            $table->bigInteger('SUBJECT_ID')->nullable();
            $table->bigInteger('TOTAL_MARKS')->nulable();
            $table->bigInteger('PASSING_MARKS')->nullabe();
            $table->bigInteger('USER_ID')->nullabe();
            $table->bigInteger('CAMPUS_ID')->nullabe();
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
        Schema::dropIfExists('kelex_subject_marks');
    }
}
