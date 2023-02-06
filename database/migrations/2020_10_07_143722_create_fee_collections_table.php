<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeeCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kelex_fee_collections', function (Blueprint $table) {
            $table->id('COLLECTION_ID');
            $table->bigInteger('CAMPUS_ID')->nullable();
            $table->bigInteger('USER_ID')->nullable();
            $table->bigInteger('FEE_ID')->nullable();
            $table->bigInteger('STUDENT_ID')->nullable();
            $table->bigInteger('SESSION_ID')->nullable();
            $table->float('PAID_AMOUNT',6,2)->nullable();
            $table->float('REMAINING',6,2)->nullable();
            $table->dateTime('PAYMENT_DATE')->nullable();
            $table->enum('PAYMENT_STATUS',['0','1'])->nullable()->comment('0=pending,1=confirmend');
            $table->enum('PAYMENT_TYPE',['1','2'])->nullable()->comment('1=Cash deposit,1=Bank deposit');
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
        Schema::dropIfExists('kelex_fee_collections');
    }
}
