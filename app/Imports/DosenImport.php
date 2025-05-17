<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DosenImport implements ToCollection, WithHeadingRow, SkipsOnError, SkipsOnFailure
{
    use Importable, SkipsErrors, SkipsFailures;
    private function validateGelar($gelar_list, $gelar)
    {
        foreach ($gelar_list as $gelar_item) {
            if (strtolower($gelar_item->gelar) == strtolower($gelar)) {
                return $gelar_item;
            }
        }
        return null;
    }

    private function validateBidang($bidang_list, $bidang)
    {
        foreach ($bidang_list as $bidang_item) {
            if (strtolower($bidang_item->nama_bidang) == strtolower($bidang)) {
                return $bidang_item->id;
            }
        }
        return null;
    }

    private function checkAllCellsFilled(Collection $rows)
    {
        foreach ($rows as $index => $row) {
        foreach ($rows as $row) {
            foreach ($row as $key => $value) {
                if ($key == 'gelar_s3') {
                    continue;
                }
                if (is_null($value) || (is_string($value) && trim($value) === '')) {
                    throw new \Exception('Ada data yang kosong. Import dibatalkan');
                }
            }
        }
    }
    }

    private function setFullNameUser($nama_dosen, $gelar_s1, $gelar_s2, $gelar_s3 = null, $is_depan = null)
    {
        $gelar_belakang = [];
        if (!empty($gelar_s1)) {
            $gelar_belakang[] = $gelar_s1;
        }
        if (!empty($gelar_s2)) {
            $gelar_belakang[] = $gelar_s2;
        }
        $gelar_belakang_str = implode(', ', $gelar_belakang);

        $gelar_depan = '';
        if (!empty($gelar_s3) && ($is_depan === true || is_null($is_depan))) {
            $gelar_depan = $gelar_s3 . ' ';
        }

        $full_name = $gelar_depan . $nama_dosen;
        if ($gelar_belakang_str) {
            $full_name .= ', ' . $gelar_belakang_str;
        }

        return trim($full_name);
    }

    /**
     * @param Collection $rows
     */

    public function collection(Collection $rows)
    {
        $this->checkAllCellsFilled($rows);

        $s1_gelar_list = DB::table('s1')->get()->toArray();
        $s2_gelar_list = DB::table('s2')->get()->toArray();
        $s3_gelar_list = DB::table('s3')->get()->toArray();
        $bidang_list = DB::table('bidang')->get()->toArray();
        $dosenData = [];
        $userData = [];
        $now = now();
        foreach ($rows as $row) {
            $gelar1Obj = $this->validateGelar($s1_gelar_list, $row['gelar_s1']);
            $gelar2Obj = $this->validateGelar($s2_gelar_list, $row['gelar_s2']);
            $gelar3Obj = $this->validateGelar($s3_gelar_list, $row['gelar_s3']);

            $dosenData[] = [
                'nidn' => $row['nidn'],
                'name' => $row['nama'],
                'email' => $row['email'],
                'gelar1' => $gelar1Obj ? $gelar1Obj->id : null,
                'gelar2' => $gelar2Obj ? $gelar2Obj->id : null,
                'gelar3' => $gelar3Obj ? $gelar3Obj->id : null,
                'jabatan_fungsional' => $row['jabatan_fungsional'],
                'id_bidang' => $this->validateBidang($bidang_list, $row['bidang']),
                'created_at' => $now,
                'updated_at' => $now,
            ];
            $userData[] = [
                'no_induk' => $row['nidn'],
                'name' => $this->setFullNameUser(
                    $row['nama'],
                    $row['gelar_s1'],
                    $row['gelar_s2'],
                    $row['gelar_s3'],
                    $gelar3Obj ? $gelar3Obj->depan == 'Y' : null
                ),
                'username' => $row['nidn'],
                'email' => $row['email'],
                'password' => Hash::make($row['nidn']),
                'role' => 'dosen',
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::transaction(function () use ($dosenData, $userData) {
            DB::table('dosen')->insert($dosenData);
            DB::table('users')->insert($userData);
        });
    }
}
