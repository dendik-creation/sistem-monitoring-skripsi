<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JadwalUjianModel extends Model
{
    protected $table = 'jadwal_ujian';
    protected $fillable = ['nim', 'id_berkas_ujian', 'tanggal', 'jam', 'tempat', 'ket'];
}
