<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamPapers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kelex_exam_papers', function (Blueprint $table) {
            $table->id('PAPER_ID');
            $table->unsignedBigInteger('EXAM_ID')->nullable();
            $table->unsignedBigInteger('SUBJECT_ID')->nullable();
            $table->unsignedBigInteger('CLASS_ID')->nullable();
            $table->unsignedBigInteger('SECTION_ID')->nullable();
            $table->float('TIME')->nullable();
            $table->string('DATE')->nullable();
            $table->float('TOTAL_MARKS')->nullable();
            $table->float('PASSING_MARKS')->nullable();
            $table->enum('PUBLISHED',['1','2'])->nullable()->comments('1= YES 2= NO ');
            $table->enum('VIVA',['1','2'])->nullable()->comments('1= YES 2= NO ');
            $table->float('VIVA_MARKS')->nullable();
            $table->unsignedBigInteger('SESSION_ID')->nullable();
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
        Schema::dropIfExists('kelex_exam_papers');
    }
}
