<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMahasiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->string('nim', 15)->unique();
            $table->string('name');
            $table->string('email', 50)->default('-');
            $table->string('hp', 16)->default('-');
            $table->string('status_proposal', 50)->nullable()->default('Belum mengajukan proposal');
            $table->string('status_sempro', 50)->nullable()->default('Belum seminar proposal');
            $table->string('status_bimbingan', 50)->nullable()->default('Belum melakukan bimbingan');
            $table->string('status_skripsi', 50)->nullable()->default('Belum mengerjakan');
            $table->string('status_ujian', 50)->nullable()->default('Belum ujian');
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
        Schema::dropIfExists('mahasiswa');
    }
}
