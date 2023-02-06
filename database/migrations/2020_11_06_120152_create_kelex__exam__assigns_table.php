<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKelexExamAssignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kelex_exam_assigns', function (Blueprint $table) {
            $table->id('ASSIGN_ID');
            $table->unsignedBigInteger('PAPER_ID')->nullable();
            $table->unsignedBigInteger('EMP_ID')->nullable();
            $table->string('DUEDATE')->nullable();
            $table->enum('STATUS',['1','2'])->nullable()->comments('1= PENDING 2= CHECKED ');
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
        Schema::dropIfExists('kelex_exam_assigns');
    }
}
