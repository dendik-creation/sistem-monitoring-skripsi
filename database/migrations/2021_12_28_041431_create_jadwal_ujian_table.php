<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJadwalUjianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jadwal_ujian', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_semester');
            $table->foreign('id_semester')->references('id')->on('semester');
            $table->string('nim', 15);
            $table->foreign('nim')->references('nim')->on('mahasiswa');
            $table->unsignedBigInteger('id_berkas_ujian');
            $table->foreign('id_berkas_ujian')->references('id')->on('berkas_ujian');
            $table->date('tanggal');
            $table->time('jam');
            $table->string('tempat');
            $table->text('ket');
            $table->enum('status1', ['Belum', 'Sudah'])->default('Belum');
            $table->enum('status2', ['Belum', 'Sudah'])->default('Belum');
            $table->enum('status3', ['Belum', 'Sudah'])->default('Belum');
            $table->enum('status4', ['Belum', 'Sudah'])->default('Belum');
            $table->string('ketua_penguji', 15);
            $table->foreign('ketua_penguji')->references('nidn')->on('dosen');
            $table->string('anggota_penguji_1', 15);
            $table->foreign('anggota_penguji_1')->references('nidn')->on('dosen');
            $table->string('anggota_penguji_2', 15);
            $table->foreign('anggota_penguji_2')->references('nidn')->on('dosen');
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
        Schema::dropIfExists('jadwal_ujian');
    }
}
