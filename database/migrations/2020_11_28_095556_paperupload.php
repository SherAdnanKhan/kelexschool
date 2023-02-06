<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Paperupload extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kelex_paper_uploads', function (Blueprint $table) {
            $table->id('PAPER_MARKING_ID');
            $table->unsignedBigInteger('PAPER_ID')->nullable();
            $table->unsignedBigInteger('EMP_ID')->nullable();
            $table->string('DUEDATE')->nullable();
            $table->enum('UPLOADSTATUS',['1','2'])->nullable()->comments('1= PENDING 2= UPLOADED ');
            $table->string('UPLOADFILE')->nullable();
            $table->unsignedBigInteger('SESSION_ID')->nullable();
            $table->unsignedBigInteger('SUBJECT_ID')->nullable();
            $table->unsignedBigInteger('CLASS_ID')->nullable();
            $table->unsignedBigInteger('SECTION_ID')->nullable();
            $table->unsignedBigInteger('CAMPUS_ID')->nullable();
            $table->unsignedBigInteger('USER_ID')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('kelex_paper_uploads');
    }
}
