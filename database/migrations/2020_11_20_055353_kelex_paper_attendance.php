<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class KelexPaperAttendance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kelex_paper_attendances', function (Blueprint $table) {
            $table->id('STD_ATTENDANCE_ID');
            $table->bigInteger('STD_ID')->nullable();
            $table->bigInteger('SESSION_ID')->nullable();
            $table->bigInteger('CLASS_ID')->nullable();
            $table->bigInteger('SECTION_ID')->nullable();
            $table->bigInteger('SUBJECT_ID')->nullable();
            $table->dateTime('ATTEN_DATE')->nullable();
            $table->unsignedBigInteger('PAPER_ID')->nullable();
            $table->unsignedBigInteger('EXAM_ID')->nullable();
            $table->enum('ATTEN_STATUS',['P','A','L','SL','HL','H'])->nullable()->comment('P=present,A=Abscent,L=leave,SL=Sick leave,HL=Half leave,H=holiday');
            $table->bigInteger('USER_ID')->nullable();
            $table->bigInteger('CAMPUS_ID')->nullable();
            $table->text('REMARKS')->nullable();;
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
        Schema::dropIfExists('kelex_paper_attendances');
    }
}
