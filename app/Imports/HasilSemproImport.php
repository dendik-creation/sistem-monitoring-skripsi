<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use App\HasilSemproModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class HasilSemproImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function model(array $row)
    {
        return new HasilSemproModel([
            'nim' => $row['nim'],
            'id_proposal' => $row['id_proposal'],
        ]);
    }
}