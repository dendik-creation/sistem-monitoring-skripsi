<?php

namespace App\Imports;

use App\PlotPengujiModel;
use Maatwebsite\Excel\Concerns\ToModel;

class PlotPengujiImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new PlotPengujiModel([
            'smt' => $row[1],
            'nim' => $row[2],
            'name' => $row[3],
            'ketua_penguji' => $row[4],
            'anggota_penguji_1' => $row[5],
            'anggota_penguji_2' => $row[6],
        ]);
    }
}
