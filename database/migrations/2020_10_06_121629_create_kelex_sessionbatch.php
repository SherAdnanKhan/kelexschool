<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKelexSessionbatch extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kelex_sessionbatches', function (Blueprint $table) {
            $table->id('SB_ID');
            $table->string('SB_NAME')->nullable();
            $table->string('START_DATE')->nullable();
            $table->string('END_DATE')->nullable();
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
        Schema::dropIfExists('kelex_sessionbatches');
    }
}
