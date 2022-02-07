<?php

namespace App\Imports;

use App\PlotPengujiModel;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Validators\Failure;
use Throwable;

class PlotPengujiImport implements ToModel, WithHeadingRow, SkipsOnError, WithValidation, SkipsOnFailure
{
    use Importable, SkipsErrors, SkipsFailures;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    

    public function model(array $row)
    {
        return new PlotPengujiModel([
            'smt' => $row['semester'],
            'nim' => $row['nim'],
            'name' => $row['nama'],
            'ketua_penguji' => $row['nidn_ketua_penguji'],
            'anggota_penguji_1' => $row['nidn_anggota_penguji_1'],
            'anggota_penguji_2' => $row['nidn_anggota_penguji_2'],
        ]);
    }

    public function rules(): array
    {
        return [
            '*.nim' => Rule::unique('plot_penguji', 'nim') // Table name, field in your db
        ];
    }
}
