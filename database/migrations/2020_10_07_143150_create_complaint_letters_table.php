<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComplaintLettersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kelex_complaint_letters', function (Blueprint $table) {
            $table->id("COMPLAIN_ID");
            $table->bigInteger('CLASS_ID')->nullable();
            $table->bigInteger('SECTION_ID')->nullable();
            $table->text('COMPLAINT')->nullable();
            $table->enum('TYPE',['1','2'])->comment('1=students,2=teacher');
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
        Schema::dropIfExists('kelex_complaint_letters');
    }
}
