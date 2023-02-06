<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKelexSubject extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kelex_subjects', function (Blueprint $table) {
            $table->id('SUBJECT_ID');
            $table->string('SUBJECT_NAME')->nullable();
            $table->string('SUBJECT_CODE')->nullable();
            $table->enum('TYPE',['0','1'])->nullable();
            $table->bigInteger('CAMPUS_ID')->nullable();
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
        Schema::dropIfExists('kelex_subjects');
    }
}
