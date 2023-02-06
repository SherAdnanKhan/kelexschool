<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKelexMonthsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kelex_months', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('NUMBER');
            $table->string('MONTH',255)->nullable();
            $table->enum('TYPE', ['1', '2'])->nullable()->comments('1=school,2=institute');
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
        Schema::dropIfExists('kelex_months');
    }
}
