<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('user_roles', function (Blueprint $table) {
            $table->id('user_role_id');
            $table->string('role_name')->nullable();
            $table->unsignedBigInteger('CAMPUS_ID')->nullable();
            $table->unsignedBigInteger('ROLE_ID')->nullable();
            $table->longText('permissions')->nullable();
            $table->longText('user_id')->nullable();
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
         Schema::dropIfExists('user_roles');
    }
}
