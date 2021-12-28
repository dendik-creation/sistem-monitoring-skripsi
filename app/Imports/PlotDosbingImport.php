<?php

namespace App\Imports;

use App\PlotDosbingModel;
use Maatwebsite\Excel\Concerns\ToModel;

class PlotDosbingImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new PlotDosbingModel([
            'smt' => $row[1],
            'nim' => $row[2],
            'name' => $row[3],
            'dosbing1' => $row[4],
            'dosbing2' => $row[5],
        ]);
    }
}
