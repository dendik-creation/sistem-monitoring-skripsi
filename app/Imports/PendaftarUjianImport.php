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
            'tanggal' => $row['tanggal_ujian'],
            'jam' => $row['jam_ujian'],
            'tempat' => $row['tempat_ujian'],
            'ket' => $row['keterangan'],
        ]);
    }
}
