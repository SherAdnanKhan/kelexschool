<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCURRENTSESSIONToKelexStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kelex_campuses', function (Blueprint $table) {
            $table->unsignedBigInteger('CURRENT_SESSION')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kelex_campuses', function (Blueprint $table) {
            //
        });
    }
}
