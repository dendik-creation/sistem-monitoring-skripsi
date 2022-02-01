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
            $table->string('nim', 15);
            $table->string('topik', 50);
            $table->string('judul');
            $table->string('proposal');
            $table->enum('ket1', ['Menunggu ACC', 'Disetujui', 'Ditolak', 'Revisi'])->default('Menunggu ACC');
            $table->enum('ket2', ['Menunggu ACC', 'Disetujui', 'Ditolak', 'Revisi'])->default('Menunggu ACC');
            $table->unsignedBigInteger('id_plot_dosbing');
            $table->foreign('id_plot_dosbing')->references('id')->on('plot_dosbing');
            $table->text('komentar')->nullable();
            $table->text('komentar1')->default('-')->nullable();
            $table->text('komentar2')->default('-')->nullable();
            $table->string('file1')->nullable();
            $table->string('file2')->nullable();
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
        Schema::dropIfExists('proposal');
    }
}
