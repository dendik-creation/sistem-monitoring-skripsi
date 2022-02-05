<?php

namespace App\Imports;

use App\PlotDosbingModel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PlotDosbingImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new PlotDosbingModel([
            'smt' => $row['semester'],
            'nim' => $row['nim'],
            'name' => $row['nama'],
            'dosbing1' => $row['nidn_dosen_pembimbing_utama'],
            'dosbing2' => $row['nidn_dosen_pembimbing_pembantu'],
        ]);
    }
}
