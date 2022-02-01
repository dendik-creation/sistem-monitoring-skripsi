<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PendaftarSemproExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DB::table('berkas_sempro')
        ->join('mahasiswa', 'berkas_sempro.nim', '=', 'mahasiswa.nim')
        ->join('plot_dosbing', 'berkas_sempro.id_plot_dosbing', '=', 'plot_dosbing.id')
        ->join('proposal', 'berkas_sempro.id_proposal', '=', 'proposal.id')
        ->join('semester', 'proposal.id_semester', '=', 'semester.id')
        ->join('dosen as dos1', 'plot_dosbing.dosbing1', '=', 'dos1.nidn')
        ->join('dosen as dos2', 'plot_dosbing.dosbing2', '=', 'dos2.nidn')
        ->select('berkas_sempro.id as id', 
        'proposal.id as id_proposal',
        'semester.semester as semester', 
        'semester.tahun as tahun', 
        'berkas_sempro.nim as nim', 
        'mahasiswa.name as nama', 
        'dos1.name as dosbing1', 
        'dos2.name as dosbing2',
        'berkas_sempro.berkas_sempro as berkas_sempro',
        'berkas_sempro.created_at as tgl_daftar', 
        'berkas_sempro.status as status')
        ->where('berkas_sempro.status', 'Berkas OK')
        ->get();

    }
    public function headings(): array
    {
        return [
            'ID_Berkas',
            'ID_Proposal',
            'Semester',
            'Tahun',
            'NIM',
            'Nama_Mahasiswa',
            'Dosen_Pembimbing_Utama',
            'Dosen_Pembimbing_Pembantu',
            'Berkas',
            'Tanggal_Daftar',
            'Status Berkas',
            'Tanggal_Seminar',
            'Jam_Seminar',
            'Tempat_Seminar',
            'Keterangan',
        ];
    }    
}
