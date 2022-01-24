<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBerkasSemproTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('berkas_sempro', function (Blueprint $table) {
            $table->id();
            $table->string('nim');
            $table->foreign('nim')->references('nim')->on('mahasiswa');
            $table->unsignedBigInteger('id_proposal');
            $table->foreign('id_proposal')->references('id')->on('proposal');
            $table->unsignedBigInteger('id_plot_dosbing');
            $table->foreign('id_plot_dosbing')->references('id')->on('plot_dosbing');
            $table->string('berkas_sempro');
            $table->enum('status', ['Menunggu Dijadwalkan', 'Terjadwal'])->default('Menunggu Dijadwalkan');
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
        Schema::dropIfExists('berkas_sempro');
    }
}
