<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use App\JadwalSemproModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PendaftarSemproImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new JadwalSemproModel([
            'nim' => $row['nim'],
            'id_berkas_sempro' => $row['id_berkas'],
            'tanggal' => $row['tanggal_seminar'],
            'jam' => $row['jam_seminar'],
            'tempat' => $row['tempat_seminar'],
            'ket' => $row['keterangan'],
        ]);
    }
}
