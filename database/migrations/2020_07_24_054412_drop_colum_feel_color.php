<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropColumFeelColor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('feel_color');
        });

        Schema::table('messages', function (Blueprint $table) {
            $table->dropColumn('feel_color');
        });

        Schema::table('feeds', function (Blueprint $table) {
            $table->dropColumn('feel_color');
        });

        Schema::table('messages_logs', function (Blueprint $table) {
            $table->dropColumn('feel_color');
        });

        Schema::table('user_feels', function (Blueprint $table) {
            $table->dropColumn('feel');
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
