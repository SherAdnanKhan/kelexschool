<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKelexSubjectgroupname extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kelex_subjectgroupnames', function (Blueprint $table) {
            $table->id('GROUP_ID');
            $table->string('GROUP_NAME')->nullable();
            $table->unsignedBigInteger('CAMPUS_ID')->nullable();
            $table->unsignedBigInteger('USER_ID')->nullable();
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
        Schema::dropIfExists('kelex_subjectgroupname');
    }
}
