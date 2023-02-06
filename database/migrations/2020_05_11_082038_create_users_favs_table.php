<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersFavsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_favs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('faved_by');
            $table->unsignedBigInteger('faved_to');
            $table->timestamps();
            
            $table->foreign('faved_by')->references('id')->on('users');
            $table->foreign('faved_to')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_favs');
    }
}
