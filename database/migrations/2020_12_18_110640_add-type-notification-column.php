<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeNotificationColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->enum('type', ['CRITIQES', 'GALLERY FAVED', 'SPRFVS APPROVED', 'SPRFVS INVITE' , 'REPOST FEED', 'COMMENT FEED', 'REPOST EXHIBIT', 'STROKE FEED', 'STROKE EXHIBIT']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notifications', function (Blueprint $table) {
            //
        });
    }
}
