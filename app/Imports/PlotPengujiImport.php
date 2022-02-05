<?php

namespace App\Imports;

use App\PlotPengujiModel;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;

class PlotPengujiImport implements ToModel, WithHeadingRow
{
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

    // public function rules(): array
    // {
    //     return [
    //         'nim' => Rule::in('plot_penguji', 'nim'), // Table name, field in your db
    //     ];
    // }

    // public function customValidationMessages()
    // {
    //     return [
    //         'nim.unique' => 'Data sudah ada',
    //     ];
    // }

    // public function chunkSize(): int
    // {
    //     return 1000;
    // }
}
