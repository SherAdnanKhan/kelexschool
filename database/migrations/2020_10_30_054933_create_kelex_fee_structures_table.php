<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKelexFeeStructuresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kelex_fee_structures', function (Blueprint $table) {
            $table->id('FEE_STRUCTURE_ID');
            $table->bigInteger('SESSION_ID')->nullable();
            $table->bigInteger('CAMPUS_ID')->nullable();
            $table->bigInteger('USER_ID')->nullable();
            $table->bigInteger('CLASS_ID')->nullable();
            $table->bigInteger('SECTION_ID')->nullable();
            $table->text('FEE_CATEGORY_ID')->nullable();
            $table->text('CATEGORY_AMOUNT')->nullable();
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
