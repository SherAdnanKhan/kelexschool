<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserReportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_report', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('report_to');
            $table->unsignedBigInteger('report_by');
            $table->text('reason');
            $table->timestamps();

            $table->foreign('report_to')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('report_by')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_report');
    }
}
