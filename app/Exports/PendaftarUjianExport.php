<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PendaftarUjianExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DB::table('berkas_ujian')
        ->join('mahasiswa', 'berkas_ujian.nim', '=', 'mahasiswa.nim')
        // ->join('plot_penguji', 'berkas_ujian.id_plot_penguji', '=', 'plot_penguji.id')
        ->join('proposal', 'berkas_ujian.id_proposal', '=', 'proposal.id')
        ->join('semester', 'berkas_ujian.id_semester', '=', 'semester.id')
        // ->join('dosen as dos1', 'plot_penguji.ketua_penguji', '=', 'dos1.nidn')
        // ->join('dosen as dos2', 'plot_penguji.anggota_penguji_1', '=', 'dos2.nidn')
        // ->join('dosen as dos3', 'plot_penguji.anggota_penguji_2', '=', 'dos3.nidn')
        ->select(DB::raw('ROW_NUMBER() OVER() AS no'), 
        'berkas_ujian.id as id', 
        'proposal.id as id_proposal',
        'semester.id as id_semester',
        'semester.semester as semester',
        'semester.tahun as tahun', 
        'berkas_ujian.nim as nim', 
        'mahasiswa.name as nama', 
        // 'dos1.name as ketua', 
        // 'dos2.name as anggota1',
        // 'dos3.name as anggota2',
        'berkas_ujian.berkas_ujian as berkas_ujian',
        'berkas_ujian.created_at as tgl_daftar', 
        'berkas_ujian.status as status')
        ->where('berkas_ujian.status', 'Berkas OK')
        ->get();
    }
    public function headings(): array
    {
        return [
            'No',
            'ID_Berkas',
            'ID_Proposal',
            'ID_Semester',
            'Semester',
            'Tahun',
            'NIM',
            'Nama_Mahasiswa',
            'Berkas',
            'Tanggal_Daftar',
            'Status_Berkas',
            'Tanggal_Ujian',
            'Jam_Ujian',
            'Tempat_Ujian',
            'Keterangan',
            'NIDN_Ketua_Penguji',
            'Nama_Ketua_Penguji',
            'NIDN_Anggota_Penguji_1',
            'Nama_Anggota_Penguji_1',
            'NIDN_Anggota_Penguji_2',
            'Nama_Anggota_Penguji_2',
        ];
    }    
}
