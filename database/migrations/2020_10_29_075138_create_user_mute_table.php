<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserMuteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_mute', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mute_to');
            $table->unsignedBigInteger('mute_by');
            $table->timestamps();

            $table->foreign('mute_to')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('mute_by')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_mute');
    }
}
