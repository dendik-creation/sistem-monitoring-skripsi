<?php

namespace App\Imports;

use App\MahasiswaModel;
use App\User;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;

class MahasiswaImport implements ToCollection, WithHeadingRow, SkipsOnError, WithValidation, SkipsOnFailure
{
    use Importable, SkipsErrors, SkipsFailures;

    public function collection(Collection $rows)
    {
        $rows = $rows->filter(function ($row) {
            return !empty($row['nim']) && !empty($row['nama']);
        });

        $nims = $rows->pluck('nim')->all();

        if (count($nims) !== count(array_unique($nims))) {
            throw new \Exception('Terdapat duplikasi NIM di file import!');
        }

        $existingNims = MahasiswaModel::whereIn('nim', $nims)->pluck('nim')->all();
        if (!empty($existingNims)) {
            throw new \Exception('NIM berikut sudah ada di database: ' . implode(', ', $existingNims));
        }

        $userData = [];
        $mahasiswaData = [];
        $now = now();

        foreach ($rows as $row) {
            $userData[] = [
                'no_induk' => $row['nim'],
                'name' => $row['nama'],
                'username' => $row['nim'],
                'password' => Hash::make($row['nim']),
                'role' => 'mahasiswa',
                'created_at' => $now,
                'updated_at' => $now,
            ];

            $mahasiswaData[] = [
                'nim' => $row['nim'],
                'name' => $row['nama'],
                'email' => $row['email'] ?? null,
                'hp' => $row['no_hp'] ?? null,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::transaction(function () use ($userData, $mahasiswaData) {
            User::insert($userData);
            MahasiswaModel::insert($mahasiswaData);
        });
    }

    public function rules(): array
    {
        return [
            '*.nim' => ['required'],
            '*.nama' => ['required'],
        ];
    }
}
