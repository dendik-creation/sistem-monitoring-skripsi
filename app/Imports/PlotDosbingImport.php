<?php

namespace App\Imports;

use App\PlotDosbingModel;
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

class PlotDosbingImport implements ToModel, WithHeadingRow, SkipsOnError, WithValidation, SkipsOnFailure
{
    use Importable, SkipsErrors, SkipsFailures;
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


    public function rules(): array
    {
        return [
            '*.nim' => Rule::unique('plot_dosbing', 'nim') // Table name, field in your db
        ];
    }
}
