<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use App\JadwalUjianModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class PendaftarUjianImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new JadwalUjianModel([
            'nim' => $row['nim'],
            'id_berkas_ujian' => $row['id_berkas'],
            'id_semester' => $row['id_semester'],
            'tanggal' => $row['tanggal_ujian'],
            'jam' => $row['jam_ujian'],
            'tempat' => $row['tempat_ujian'],
            'ket' => $row['keterangan'],
            'ketua_penguji' => $row['nidn_ketua_penguji'],
            'anggota_penguji_1' => $row['nidn_anggota_penguji_1'],
            'anggota_penguji_2' => $row['nidn_anggota_penguji_2'],
        ]);
    }

    public function rules(): array
    {
        return [
            'nim' => 'required|exists:mahasiswa,nim',
            'id_berkas' => 'required|integer|exists:berkas_ujian,id',
            'id_semester' => 'required|integer|exists:semester,id',
            'tempat_ujian' => 'required|string|max:255',
            'tanggal_ujian' => 'required|date_format:Y-m-d',
            'jam_ujian' => 'required|date_format:H:i',
            'keterangan' => 'required|string|max:500',
            'nidn_ketua_penguji' => 'required|exists:dosen,nidn',
            'nidn_anggota_penguji_1' => 'required|exists:dosen,nidn|different:7',
            'nidn_anggota_penguji_2' => 'required|exists:dosen,nidn|different:7|different:8',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'nim.required' => 'NIM wajib diisi.',
            'nim.exists' => 'NIM tidak ditemukan di tabel mahasiswa.',

            'id_berkas.required' => 'Berkas ujian wajib diisi.',
            'id_berkas.integer' => 'ID berkas ujian harus berupa angka.',
            'id_berkas.exists' => 'ID Berkas tidak terdaftar.',

            'id_semester.required' => 'Semester wajib diisi.',
            'id_semester.integer' => 'ID semester harus berupa angka.',
            'id_semester.exists' => 'ID semester tidak terdaftar',

            'tanggal_ujian.required' => 'Tanggal wajib diisi.',
            'tanggal_ujian.date' => 'Format tanggal tidak valid.',

            'jam_ujian.required' => 'Jam wajib diisi.',
            'jam_ujian.date_format' => 'Format jam harus dalam format HH:MM (contoh: 13:00).',

            'tempat_ujian.required' => 'Tempat ujian wajib diisi.',
            'tempat_ujian.string' => 'Tempat harus berupa teks.',
            'tempat_ujian.max' => 'Tempat maksimal 255 karakter.',

            'keterangan.strrequireding' => 'Keterangan wajib diisi.',
            'keterangan.string' => 'Keterangan harus berupa teks.',
            'keterangan.max' => 'Keterangan maksimal 500 karakter.',

            'nidn_ketua_penguji.required' => 'Ketua penguji wajib dipilih.',
            'nidn_ketua_penguji.exists' => 'Ketua penguji tidak terdaftar.',

            'nidn_anggota_penguji_1.required' => 'Anggota penguji 1 wajib dipilih.',
            'nidn_anggota_penguji_1.exists' => 'Anggota penguji 1 tidak terdaftar.',
            'nidn_anggota_penguji_1.different' => 'Anggota penguji 1 tidak boleh sama dengan ketua penguji.',

            'nidn_anggota_penguji_2.required' => 'Anggota penguji 2 wajib dipilih.',
            'nidn_anggota_penguji_2.exists' => 'Anggota penguji 2 tidak terdaftar.',
            'nidn_anggota_penguji_2.different' => 'Anggota penguji 2 harus berbeda dari ketua dan anggota penguji 1.',
        ];
    }
}
