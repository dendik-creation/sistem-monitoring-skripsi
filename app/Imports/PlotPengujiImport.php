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
            'smt' => $row[1],
            'nim' => $row[2],
            'name' => $row[3],
            'ketua_penguji' => $row[4],
            'anggota_penguji_1' => $row[5],
            'anggota_penguji_2' => $row[6],
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
