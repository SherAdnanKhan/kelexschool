<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFeelIdsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('feel_id')->default(1)->after('feel_color');
            $table->foreign('feel_id')->references('id')->on('feels')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('messages', function (Blueprint $table) {
            $table->unsignedBigInteger('feel_id')->default(1)->after('feel_color');
            $table->foreign('feel_id')->references('id')->on('feels')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('feeds', function (Blueprint $table) {
            $table->unsignedBigInteger('feel_id')->default(1)->after('feel_color');
            $table->foreign('feel_id')->references('id')->on('feels')->onDelete('cascade')->onUpdate('cascade');
        });
        Schema::table('messages_logs', function (Blueprint $table) {
            $table->unsignedBigInteger('feel_id')->default(1)->after('feel_color');
            $table->foreign('feel_id')->references('id')->on('feels')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
