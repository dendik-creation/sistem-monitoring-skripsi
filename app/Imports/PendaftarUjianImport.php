<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use App\JadwalUjianModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PendaftarUjianImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new JadwalUjianModel([
            'nim' => $row['nim'],
            'id_berkas_ujian' => $row['id_berkas'],
            'id_semester' => $row['id_semester'],
            'tanggal' => $row['tanggal_ujian'],
            'jam' => $row['jam_ujian'],
            'tempat' => $row['tempat_ujian'],
            'ket' => $row['keterangan'],
            'ketua_penguji' => $row['nidn_ketua_penguji'],
            'anggota_penguji_1' => $row['nidn_anggota_penguji_1'],
            'anggota_penguji_2' => $row['nidn_anggota_penguji_2'],
        ]);
    }
}
