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
            $table->string('smt', 50);
            $table->string('nim', 15)->unique();
            $table->string('name');
            $table->string('dosbing1', 15);
            $table->foreign('dosbing1')->references('nidn')->on('dosen');
            $table->string('dosbing2', 15)->nullable()->default('-');
            $table->foreign('dosbing2')->references('nidn')->on('dosen');
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
        Schema::dropIfExists('plot_dosbing');
    }
}
