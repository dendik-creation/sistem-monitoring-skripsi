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
            $table->unsignedBigInteger('id_jadwal_sempro')->nullable();
            $table->foreign('id_jadwal_sempro')->references('id')->on('jadwal_sempro');
            $table->enum('berita_acara', ['Diterima', 'Ditolak'])->default('Diterima');
            $table->string('sikap1')->nullable();
            $table->string('presentasi1')->nullable();
            $table->string('penguasaan1')->nullable();
            $table->string('jumlah1')->nullable();
            $table->string('grade1')->nullable();
            $table->text('revisi1')->nullable();
            $table->string('sikap2')->nullable();
            $table->string('presentasi2')->nullable();
            $table->string('penguasaan2')->nullable();
            $table->string('jumlah2')->nullable();
            $table->string('grade2')->nullable();
            $table->text('revisi2')->nullable();
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
        Schema::dropIfExists('hasil_sempro');
    }
}
