<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHasilSemproTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hasil_sempro', function (Blueprint $table) {
            $table->id();
            $table->string('nim');
            $table->foreign('nim')->references('nim')->on('mahasiswa');
            $table->unsignedBigInteger('id_proposal');
            $table->foreign('id_proposal')->references('id')->on('proposal');
            $table->unsignedBigInteger('id_jadwal_sempro');
            $table->foreign('id_jadwal_sempro')->references('id')->on('jadwal_sempro');
            $table->enum('berita_acara', ['Diterima', 'Ditolak'])->default('Diterima');
            $table->string('sikap1');
            $table->string('presentasi1');
            $table->string('penguasaan1');
            $table->string('jumlah1');
            $table->string('grade1');
            $table->text('revisi1');
            $table->string('sikap2');
            $table->string('presentasi2');
            $table->string('penguasaan2');
            $table->string('jumlah2');
            $table->string('grade2');
            $table->text('revisi2');
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
        Schema::dropIfExists('hasil_sempro');
    }
}
