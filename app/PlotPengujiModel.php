<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlotPengujiModel extends Model
{
    protected $table = 'plot_penguji';
    protected $fillable = ['smt', 'nim', 'name', 'ketua_penguji', 'anggota_penguji_1', 'anggota_penguji_2'];
    public $timestamps = false;
}
