<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeeDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kelex_fee_discounts', function (Blueprint $table) {
            $table->id('DISCOUNT_ID');
            $table->bigInteger('STUDENT_ID')->nullable();
            $table->bigInteger('FEE_CAT_ID')->nullable();
            $table->bigInteger('DISCOUNT')->nullable();
            $table->bigInteger('USER_ID')->nullable();
            $table->bigInteger('CAMPUS_ID')->nullable();
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
        Schema::dropIfExists('kelex_fee_discounts');
    }
}
