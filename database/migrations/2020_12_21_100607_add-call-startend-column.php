<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCallStartendColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('conversations_logs', function (Blueprint $table) {
            $table->timestamp('call_end')->nullable()->after('feel_id');
            $table->timestamp('call_start')->nullable()->after('feel_id');
        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('conversations_logs', function (Blueprint $table) {
            //
        });
    }
}
