<?php

namespace App\Imports;

use App\User;
use Maatwebsite\Excel\Concerns\ToModel;

use Illuminate\Support\Facades\Hash;

class UserImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new User([
            'no_induk' => $row[2],
            'name' => $row[3],
            'username' => $row[2],
            'password' => Hash::make($row[2]),
        ]);
    }
}
