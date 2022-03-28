<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBerkasUjianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('berkas_ujian', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_semester');
            $table->foreign('id_semester')->references('id')->on('semester');
            $table->string('nim', 15);
            $table->foreign('nim')->references('nim')->on('mahasiswa');
            $table->unsignedBigInteger('id_proposal');
            $table->foreign('id_proposal')->references('id')->on('proposal');
            // $table->unsignedBigInteger('id_plot_penguji');
            // $table->foreign('id_plot_penguji')->references('id')->on('plot_penguji');
            $table->string('berkas_ujian');
            // $table->string('laporan');
            // $table->string('transkrip');
            // $table->string('ketpengumpulan');
            // $table->string('turnitin');
            $table->enum('status', ['Menunggu Dijadwalkan', 'Berkas OK', 'Berkas tidak lengkap', 'Terjadwal', 'Menunggu Verifikasi'])->default('Menunggu Verifikasi');
            $table->string('komentar_admin');
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
        Schema::dropIfExists('berkas_ujian');
    }
}
