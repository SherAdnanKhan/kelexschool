<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserBlockTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_block', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('block_to');
            $table->unsignedBigInteger('block_by');
            $table->timestamps();

            $table->foreign('block_to')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('block_by')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_block');
    }
}
