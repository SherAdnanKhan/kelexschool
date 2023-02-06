<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserSprfvsSelectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_sprfvs_selections', function (Blueprint $table) {
            $table->id();
            $table->boolean('status')->comment('1-Approved, 0-invited');
            $table->unsignedBigInteger('privacy_type_id');
            $table->unsignedBigInteger('created_to');
            $table->unsignedBigInteger('created_by');
            $table->timestamps();

            $table->foreign('created_to')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('privacy_type_id')->references('id')->on('privacy_types')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_sprfvs_selections');
    }
}
