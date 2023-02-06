<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeeCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kelex_fee_categories', function (Blueprint $table) {
            $table->id('FEE_CAT_ID');
            $table->bigInteger('CLASS_ID')->nullable();
            $table->bigInteger('SECTION_ID')->nullable();
            $table->bigInteger('SHIFT')->nullable();
            $table->string('CATEGORY',100)->nullable();
            $table->bigInteger("CAMPUS_ID")->nullable();
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
        Schema::dropIfExists('kelex_fee_categories');
    }
}
