<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProposalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proposal', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_semester');
            $table->foreign('id_semester')->references('id')->on('semester');
            $table->string('nim');
            $table->string('topik');
            $table->string('judul');
            $table->string('proposal');
            $table->enum('ket1', ['Menunggu ACC', 'Disetujui', 'Ditolak', 'Revisi'])->default('Menunggu ACC');
            $table->enum('ket2', ['Menunggu ACC', 'Disetujui', 'Ditolak', 'Revisi'])->default('Menunggu ACC');
            $table->unsignedBigInteger('id_plot_dosbing');
            $table->foreign('id_plot_dosbing')->references('id')->on('plot_dosbing');
            $table->string('komentar')->nullable();
            $table->string('komentar1')->default('-')->nullable();
            $table->string('komentar2')->default('-')->nullable();
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
        Schema::dropIfExists('proposal');
    }
}
