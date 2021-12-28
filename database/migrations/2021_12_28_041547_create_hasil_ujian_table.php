<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHasilUjianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hasil_ujian', function (Blueprint $table) {
            $table->id();
            $table->string('nim');
            $table->foreign('nim')->references('nim')->on('mahasiswa');
            $table->unsignedBigInteger('id_proposal');
            $table->foreign('id_proposal')->references('id')->on('proposal');
            $table->unsignedBigInteger('id_jadwal_ujian');
            $table->foreign('id_jadwal_ujian')->references('id')->on('jadwal_ujian');
            $table->enum('berita_acara', ['Diterima', 'Ditolak'])->default('Diterima');
            $table->string('sikap1');
            $table->string('presentasi1');
            $table->string('teori1');
            $table->string('program1');
            $table->string('jumlah1');
            $table->string('keterangan1');
            $table->text('revisi1');
            $table->string('sikap2');
            $table->string('presentasi2');
            $table->string('teori2');
            $table->string('program2');
            $table->string('jumlah2');
            $table->string('keterangan2');
            $table->text('revisi2');
            $table->string('sikap3');
            $table->string('presentasi3');
            $table->string('teori3');
            $table->string('program3');
            $table->string('jumlah3');
            $table->string('keterangan3');
            $table->text('revisi3');
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
        Schema::dropIfExists('hasil_ujian');
    }
}
