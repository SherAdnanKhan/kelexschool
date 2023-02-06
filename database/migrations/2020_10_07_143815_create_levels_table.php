<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kelex_levels', function (Blueprint $table) {
            $table->id('LEVEL_ID');
            $table->string('LEVEL',100);
            $table->enum('USER_TYPE',['1','2'])->nullable()->comment('1=school user, 2= institute');
            $table->bigInteger('USER_ID')->nullable();
            $table->bigInteger('CAMPUS_ID');
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
        Schema::dropIfExists('kelex_levels');
    }
}
