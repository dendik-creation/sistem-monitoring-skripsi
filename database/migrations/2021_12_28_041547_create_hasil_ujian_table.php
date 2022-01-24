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
            $table->unsignedBigInteger('id_jadwal_ujian')->nullable();
            $table->foreign('id_jadwal_ujian')->references('id')->on('jadwal_ujian');
            $table->enum('berita_acara', ['Lulus', 'Tidak Lulus'])->default('Lulus');
            $table->string('sikap1')->nullable();
            $table->string('presentasi1')->nullable();
            $table->string('teori1')->nullable();
            $table->string('program1')->nullable();
            $table->string('jumlah1')->nullable();
            $table->string('keterangan1')->nullable();
            $table->text('revisi1')->nullable();
            $table->string('sikap2')->nullable();
            $table->string('presentasi2')->nullable();
            $table->string('teori2')->nullable();
            $table->string('program2')->nullable();
            $table->string('jumlah2')->nullable();
            $table->string('keterangan2')->nullable();
            $table->text('revisi2')->nullable();
            $table->string('sikap3')->nullable();
            $table->string('presentasi3')->nullable();
            $table->string('teori3')->nullable();
            $table->string('program3')->nullable();
            $table->string('jumlah3')->nullable();
            $table->string('keterangan3')->nullable();
            $table->text('revisi3')->nullable();
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
