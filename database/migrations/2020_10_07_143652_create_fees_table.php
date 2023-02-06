<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kelex_fee_types', function (Blueprint $table) {
            $table->id('FEE_ID');
            $table->bigInteger('CLASS_ID')->nullable();
            $table->bigInteger('SECTION_ID')->nullable();
            $table->bigInteger('CAMPUS_ID')->nullable();
            $table->bigInteger('FEE_CAT_ID')->nullable();
            $table->bigInteger('SESSION_ID')->nullable();
            $table->enum('SHIFT',['1','2'])->nullable()->comments('1= Morning 2= Evening');
            $table->bigInteger('CREATED_BY')->nullable();
            $table->bigInteger('UPDATE_BY')->nullable();
            $table->text('FEE_TYPE')->nullable();
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
        Schema::dropIfExists('kelex_fee_structures');
    }
}
