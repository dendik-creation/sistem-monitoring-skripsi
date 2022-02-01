<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
Use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'no_induk' => '12345678910',
            'name' => 'Admin',
            'username' => 'adminskripsi',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('adminskripsi123'),
            'role' => 'admin',
            'created_at' => \Carbon\Carbon::now(),
            'email_verified_at' => \Carbon\Carbon::now()
        ]);
        DB::table('semester')->insert([
            'semester' => 'GASAL',
            'tahun' => '2021/2022',
            'aktif' => 'Y',
        ]);
        DB::table('bidang')->insert([
            'nama_bidang' => 'Jaringan Komputer',
            'created_at' => \Carbon\Carbon::now(),
        ]);
        DB::table('bidang')->insert([
            'nama_bidang' => 'Bisnis Cerdas & Visi Komputer',
            'created_at' => \Carbon\Carbon::now(),
        ]);
        DB::table('bidang')->insert([
            'nama_bidang' => 'Komputer Grafis',
            'created_at' => \Carbon\Carbon::now(),
        ]);
        DB::table('bidang')->insert([
            'nama_bidang' => 'Komputasi Terapan',
            'created_at' => \Carbon\Carbon::now(),
        ]);
        DB::table('bidang')->insert([
            'nama_bidang' => 'Rekayasa Perangkat Lunak',
            'created_at' => \Carbon\Carbon::now(),
        ]);
    }
}
