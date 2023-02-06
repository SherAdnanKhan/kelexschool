<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKelexPaperMarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kelex_paper_marks', function (Blueprint $table) {
            $table->id('MARKS_ID');
            $table->unsignedBigInteger('STUDENT_ID')->nullable();
            $table->unsignedBigInteger('SESSION_ID')->nullable();
            $table->unsignedBigInteger('CLASS_ID')->nullable();
            $table->unsignedBigInteger('SECTION_ID')->nullable();
            $table->unsignedBigInteger('SUBJECT_ID')->nullable();
            $table->unsignedBigInteger('PAPER_ID')->nullable();
            $table->unsignedBigInteger('EXAM_ID')->nullable();
            $table->enum('STATUS',['1','2'])->nullable()->comments('1= PENDING 2= CHECKED ');
            $table->float('TOB_MARKS')->nullable();
            $table->float('VOB_MARKS')->nullable();
            $table->string('REMARKS')->nullable();
            $table->unsignedBigInteger('CAMPUS_ID')->nullable();
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
        Schema::dropIfExists('kelex_paper_marks');
    }
}
