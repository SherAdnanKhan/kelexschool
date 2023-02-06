<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKelexBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kelex_banks', function (Blueprint $table) {
            $table->id('BANK_ID');
            $table->string('NAME',255)->nullable();
            $table->string('ACC_TITLE',255)->nullable();
            $table->string('ACC_NUMBER',255)->nullable();
            $table->string('LOGO',255)->nullable();
            $table->enum('IS_ACTIVE', [0,1])->nullable()->comment('0 = inactive 1= active');
            $table->bigInteger('CAMPUS_ID')->nullable();
            $table->bigInteger('USER_ID')->nullable();
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
        Schema::dropIfExists('kelex_banks');
    }
}
