<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKelexFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kelex_fees', function (Blueprint $table) {
            $table->id('FEE_ID');
            $table->bigInteger('CAMPUS_ID')->nullable();
            $table->bigInteger('USER_ID')->nullable();
            $table->bigInteger('SESSION_ID')->nullable();
            $table->bigInteger('CLASS_ID')->nullable();
            $table->bigInteger('SECTION_ID')->nullable();
            $table->date('DUE_DATE')->nullable();
            $table->text('FEE_DATA')->nullable();
            $table->text('MONTHS')->nullable();
            $table->decimal('FEE_AMOUNT', 10, 2)->nullable();
            $table->enum('STATUS', ['0', '1'])->nullable()->comment('0=unpaid,1=paid');
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
        Schema::dropIfExists('kelex_fees');
    }
}
