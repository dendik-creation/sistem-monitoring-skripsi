<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use App\HasilUjianModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class HasilUjianImport implements ToModel, WithHeadingRow
{
     /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function model(array $row)
    {
        return new HasilUjianModel([
            'nim' => $row['nim'],
            'id_proposal' => $row['id_proposal'],
            'id_semester' => $row['id_semester'],
        ]);
    }
}
