<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JadwalSemproModel extends Model
{
    protected $table = 'jadwal_sempro';
    protected $fillable = ['nim', 'id_berkas_sempro', 'tanggal', 'jam', 'tempat', 'ket'];
}
