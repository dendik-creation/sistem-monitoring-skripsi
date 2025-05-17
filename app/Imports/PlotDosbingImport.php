<?php

namespace App\Imports;

use App\PlotDosbingModel;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Illuminate\Validation\Rule;

class PlotDosbingImport implements ToCollection, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use Importable, SkipsFailures;

    public function collection(Collection $rows)
    {
        $nims = [];
        foreach ($rows as $row) {
            foreach (['semester', 'nim', 'nidn_dosen_pembimbing_utama', 'nidn_dosen_pembimbing_pembantu'] as $field) {
                if (!isset($row[$field]) || trim($row[$field]) === '') {
                    throw new \Exception("Sistem menemukan informasi yang kosong, import dibatalkan.");
                }
            }
            if (in_array($row['nim'], $nims)) {
                throw new \Exception("Terdapat duplikasi NIM ({$row['nim']}) di proses import, import dibatalkan.");
            }
            $nims[] = $row['nim'];
        }

        DB::transaction(function () use ($rows) {
            foreach ($rows as $row) {
                PlotDosbingModel::create([
                    'smt'      => $row['semester'],
                    'nim'      => $row['nim'],
                    'dosbing1' => $row['nidn_dosen_pembimbing_utama'],
                    'dosbing2' => $row['nidn_dosen_pembimbing_pembantu'],
                ]);
            }
        });
    }

    public function rules(): array
    {
        return [
            '*.nim' => [
                'required',
                'exists:mahasiswa,nim',
                Rule::unique('plot_dosbing', 'nim'),
            ],
            '*.nidn_dosen_pembimbing_utama' => [
                'required',
                'exists:dosen,nidn',
                'different:nidn_dosen_pembimbing_pembantu',
            ],
            '*.nidn_dosen_pembimbing_pembantu' => [
                'required',
                'exists:dosen,nidn',
                'different:nidn_dosen_pembimbing_utama',
            ],
            '*.semester' => [
                'required',
            ],
        ];
    }

    public function customValidationMessages()
    {
        return [
            '*.nim.required' => 'NIM wajib diisi.',
            '*.nim.exists' => 'NIM tidak ditemukan di tabel mahasiswa.',
            '*.nim.unique' => 'NIM sudah ada di plot dosbing.',

            '*.nidn_dosen_pembimbing_utama.required' => 'Dosen pembimbing utama wajib dipilih.',
            '*.nidn_dosen_pembimbing_utama.exists' => 'Dosen pembimbing utama tidak terdaftar.',
            '*.nidn_dosen_pembimbing_utama.different' => 'Dosen pembimbing utama tidak boleh sama dengan pembantu.',

            '*.nidn_dosen_pembimbing_pembantu.required' => 'Dosen pembimbing pembantu wajib dipilih.',
            '*.nidn_dosen_pembimbing_pembantu.exists' => 'Dosen pembimbing pembantu tidak terdaftar.',
            '*.nidn_dosen_pembimbing_pembantu.different' => 'Dosen pembimbing pembantu harus berbeda dari utama.',

            '*.semester.required' => 'Semester wajib diisi.',
        ];
    }
}
