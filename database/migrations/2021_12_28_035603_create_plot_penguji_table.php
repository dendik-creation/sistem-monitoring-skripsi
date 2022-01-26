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
            $table->string('smt', 50);
            $table->string('nim', 15);
            $table->string('name');
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
        Schema::dropIfExists('plot_penguji');
    }
}
