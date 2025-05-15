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
    // use Importable, SkipsErrors, SkipsFailures;
    // /**
    //  * @param array $row
    //  *
    //  * @return \Illuminate\Database\Eloquent\Model|null
    //  */
    // public function model(array $row)
    // {
    //     return new PlotDosbingModel([
    //         'smt' => $row['semester'],
    //         'nim' => $row['nim'],
    //         // 'name' => $row['nama'],
    //         'dosbing1' => $row['nidn_dosen_pembimbing_utama'],
    //         'dosbing2' => $row['nidn_dosen_pembimbing_pembantu'],
    //     ]);
    // }


    // public function rules(): array
    // {
    //     return [
    //         '*.nim' => Rule::unique('plot_dosbing', 'nim'),
    //         'nim' => 'required|exists:mahasiswa,nim',
    //         'nidn_dosen_pembimbing_utama' => 'required|exists:dosen,nidn|different:7',
    //         'nidn_dosen_pembimbing_pembantu' => 'required|exists:dosen,nidn|different:7|different:8',
    //     ];
    // }

    // public function customValidationMessages()
    // {
    //     return [
    //         'nim.required' => 'NIM wajib diisi.',
    //         'nim.exists' => 'NIM tidak ditemukan di tabel mahasiswa.',

    //         'nidn_dosen_pembimbing_utama.required' => 'Dosen pembimbing utama wajib dipilih.',
    //         'nidn_dosen_pembimbing_utama.exists' => 'Dosen pembimbing utama tidak terdaftar.',
    //         'nidn_dosen_pembimbing_utama.different' => 'Dosen pembimbing utama tidak boleh sama dengan ketua penguji.',

    //         'nidn_dosen_pembimbing_pembantu.required' => 'Dosen pembimbing pembantu wajib dipilih.',
    //         'nidn_dosen_pembimbing_pembantu.exists' => 'Dosen pembimbing pembantu tidak terdaftar.',
    //         'nidn_dosen_pembimbing_pembantu.different' => 'Dosen pembimbing pembantu harus berbeda dari Dosen pembimbing utama.',
    //     ];
    // }


    use Importable, SkipsErrors, SkipsFailures;

    public function model(array $row)
    {
        if (empty(array_filter($row))) {
            return null;
        }

        return new PlotDosbingModel([
            'smt' => $row['semester'],
            'nim' => $row['nim'],
            'dosbing1' => $row['nidn_dosen_pembimbing_utama'],
            'dosbing2' => $row['nidn_dosen_pembimbing_pembantu'],
        ]);
    }

    public function rules(): array
    {
        return [
            '*.nim' => Rule::unique('plot_dosbing', 'nim'),
            'nim' => 'required|exists:mahasiswa,nim',
            'nidn_dosen_pembimbing_utama' => 'required|exists:dosen,nidn|different:7',
            'nidn_dosen_pembimbing_pembantu' => 'required|exists:dosen,nidn|different:7|different:8',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'nim.required' => 'NIM wajib diisi.',
            'nim.exists' => 'NIM tidak ditemukan di tabel mahasiswa.',

            'nidn_dosen_pembimbing_utama.required' => 'Dosen pembimbing utama wajib dipilih.',
            'nidn_dosen_pembimbing_utama.exists' => 'Dosen pembimbing utama tidak terdaftar.',
            'nidn_dosen_pembimbing_utama.different' => 'Dosen pembimbing utama tidak boleh sama dengan ketua penguji.',

            'nidn_dosen_pembimbing_pembantu.required' => 'Dosen pembimbing pembantu wajib dipilih.',
            'nidn_dosen_pembimbing_pembantu.exists' => 'Dosen pembimbing pembantu tidak terdaftar.',
            'nidn_dosen_pembimbing_pembantu.different' => 'Dosen pembimbing pembantu harus berbeda dari Dosen pembimbing utama.',
        ];
    }
}
