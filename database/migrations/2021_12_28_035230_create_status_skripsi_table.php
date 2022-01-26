<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusSkripsiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('status_skripsi', function (Blueprint $table) {
            $table->id();
            $table->string('nim', 15);
            $table->foreign('nim')->references('nim')->on('mahasiswa');
            $table->unsignedBigInteger('id_proposal');
            $table->foreign('id_proposal')->references('id')->on('proposal');
            $table->enum('status_skripsi', ['Sedang Dikerjakan', 'Selesai'])->default('Sedang Dikerjakan');
            $table->enum('status_ujian', ['Belum Ujian', 'Lulus', 'Tidak Lulus'])->default('Belum Ujian');
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
        Schema::dropIfExists('status_skripsi');
    }
}
