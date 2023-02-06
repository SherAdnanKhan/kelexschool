<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKelexCampusesTable extends Migration
{
    public function up()
    {
        Schema::create('kelex_campuses', function (Blueprint $table) {

		$table->id('CAMPUS_ID')->autoIncrement();
		$table->string('SCHOOL_NAME',50)->nullable();
		$table->text('SCHOOL_ADDRESS')->nullable();
		$table->string('PHONE_NO',50)->nullable();
		$table->string('MOBILE_NO',50)->nullable();
		$table->string('LOGO_IMAGE')->nullable();
		$table->string('SCHOOL_REG',50)->nullable();
		$table->string('SCHOOL_EMAIL',50)->nullable();
		$table->string('SCHOOL_WEBSITE',50)->nullable();
		$table->string('CONTROLLLER')->nullable();
		$table->unsignedBigInteger('USER_ID')->nullable();
		$table->bigInteger('CITY_ID')->nullable();
		$table->string('TYPE',50)->nullable();
		$table->bigInteger('BILLING_CHARGE')->nullable();
		$table->bigInteger('BILLING_DISCOUNT')->nullable();
		$table->date('DUE_DATE')->nullable();
		$table->bigInteger('STATUS')->nullable();
		$table->bigInteger('SMS_ALLOWED')->nullable();
		$table->enum('AGREEMENT',['0','1'])->nullable();
		$table->date('AGREEMENT_DATE')->nullable();
		$table->softDeletes();
		$table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('campuses');
    }
}