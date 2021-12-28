<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlotDosbingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plot_dosbing', function (Blueprint $table) {
            $table->id();
            $table->string('smt');
            $table->string('nim');
            $table->string('name');
            $table->string('dosbing1');
            $table->foreign('dosbing1')->references('nidn')->on('dosen');
            $table->string('dosbing2');
            $table->foreign('dosbing2')->references('nidn')->on('dosen');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plot_dosbing');
    }
}
