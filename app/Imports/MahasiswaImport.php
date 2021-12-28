<?php

namespace App\Imports;

use App\MahasiswaModel;
use Maatwebsite\Excel\Concerns\ToModel;

class MahasiswaImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new MahasiswaModel([
            'nim' => $row[2],
            'name' => $row[3],
        ]);
    }
}
