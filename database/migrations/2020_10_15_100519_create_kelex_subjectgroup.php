<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKelexSubjectgroup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kelex_subjectgroups', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('GROUP_ID')->nullable();
            $table->bigInteger('CLASS_ID')->nullable();
            $table->bigInteger('SECTION_ID')->nullable();
            $table->bigInteger('SUBJECT_ID')->nullable();
            $table->bigInteger('SESSION_ID')->nullable();
            $table->bigInteger('USER_ID')->nullable();
            $table->bigInteger('CAMPUS_ID')->nullable();
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
        Schema::dropIfExists('kelex_subjectgroup');
    }
}
