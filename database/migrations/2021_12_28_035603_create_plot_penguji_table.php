<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlotPengujiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plot_penguji', function (Blueprint $table) {
            $table->id();
            $table->string('smt');
            $table->string('nim');
            $table->string('name');
            $table->string('ketua_penguji');
            $table->foreign('ketua_penguji')->references('nidn')->on('dosen');
            $table->string('anggota_penguji_1');
            $table->foreign('anggota_penguji_1')->references('nidn')->on('dosen');
            $table->string('anggota_penguji_2');
            $table->foreign('anggota_penguji_2')->references('nidn')->on('dosen');
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
        Schema::dropIfExists('plot_penguji');
    }
}
