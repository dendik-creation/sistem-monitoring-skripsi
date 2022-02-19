<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JadwalUjianModel extends Model
{
    protected $table = 'jadwal_ujian';
    protected $fillable = ['nim', 'id_berkas_ujian', 'id_semester', 'tanggal', 'jam', 'tempat', 'ket', 'ketua_penguji', 'anggota_penguji_1', 'anggota_penguji_2'];
}
