<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJadwalSemproTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jadwal_sempro', function (Blueprint $table) {
            $table->id();
            $table->string('nim');
            $table->foreign('nim')->references('nim')->on('mahasiswa');
            $table->unsignedBigInteger('id_berkas_sempro');
            $table->foreign('id_berkas_sempro')->references('id')->on('berkas_sempro');
            $table->date('tanggal');
            $table->time('jam');
            $table->string('tempat');
            $table->text('ket');
            $table->enum('status1', ['Belum', 'Sudah'])->default('Belum');
            $table->enum('status2', ['Belum', 'Sudah'])->default('Belum');
            $table->timestamps()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jadwal_sempro');
    }
}
