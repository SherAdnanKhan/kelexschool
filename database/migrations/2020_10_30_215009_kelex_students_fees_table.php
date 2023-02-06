<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class KelexStudentsFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kelex_student_fees', function (Blueprint $table) {
            $table->id('STUDENT_FEE_ID');
            $table->bigInteger('FEE_ID')->nullable();
            $table->enum('STATUS',['0','1'])->nullable();
            $table->bigInteger('STUDENT_ID')->nullable();
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
        Schema::dropIfExists('kelex_student_fees', function (Blueprint $table) {

        });
    }
}
