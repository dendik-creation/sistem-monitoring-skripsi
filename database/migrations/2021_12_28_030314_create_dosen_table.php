<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDosenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dosen', function (Blueprint $table) {
            $table->id();
            $table->string('nidn')->unique();
            $table->string('name');
            $table->unsignedBigInteger('gelar1');
            $table->foreign('gelar1')->references('id')->on('s1');
            $table->unsignedBigInteger('gelar2');
            $table->foreign('gelar2')->references('id')->on('s2');
            $table->unsignedBigInteger('gelar3');
            $table->foreign('gelar3')->references('id')->on('s3');
            $table->string('jabatan_fungsional');
            $table->unsignedBigInteger('id_bidang');
            $table->foreign('id_bidang')->references('id')->on('bidang');
            $table->string('email');
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
        Schema::dropIfExists('dosen');
    }
}
