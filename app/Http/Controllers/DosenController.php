<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Response;
use Carbon\Carbon;
// use \PDF;

use Illuminate\Support\Facades\DB;
use App\HasilSemproModel;
use App\PesanBimbinganModel;
use App\StatusSkripsiModel;
use App\HasilUjianModel;

class DosenController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $dosen = $user -> no_induk;
        $totalmhs = DB::table('plot_dosbing')
        ->where('plot_dosbing.dosbing1', $dosen)
        ->orWhere('plot_dosbing.dosbing2', $dosen)
        ->count();

        $totalmhsskripsi = DB::table('status_skripsi')
        ->join('mahasiswa', 'status_skripsi.nim', '=', 'mahasiswa.nim')
        ->join('proposal', 'status_skripsi.id_proposal', '=', 'proposal.id')
        ->join('plot_dosbing', 'proposal.id_plot_dosbing', '=', 'plot_dosbing.id')
        ->join('semester', 'proposal.id_semester', '=', 'semester.id')
        ->select('status_skripsi.id as id', 'status_skripsi.nim as nim', 'mahasiswa.name as nama', 'proposal.judul as judul', 
        'semester.semester as semester', 'semester.tahun as tahun', 'status_skripsi.status_skripsi as status_skripsi', 'status_skripsi.status_ujian as status_ujian',
        'plot_dosbing.dosbing1 as dosbing1', 'plot_dosbing.dosbing2 as dosbing2')
        ->where(function ($query) {
            $user = Auth::user();
            $dosen = $user -> no_induk;
            $query ->where('plot_dosbing.dosbing1', $dosen)
                    ->where('status_skripsi.status_skripsi', 'Sedang Dikerjakan');
        })
        ->orWhere(function ($query) {
            $user = Auth::user();
            $dosen = $user -> no_induk;
            $query->where('status_skripsi.status_skripsi', 'Sedang Dikerjakan')
                    ->where('plot_dosbing.dosbing2', $dosen);
        })
        ->count();
        
        $propwaitacc = DB::table('proposal')
        ->join('mahasiswa', 'proposal.nim', '=', 'mahasiswa.nim')
        ->join('plot_dosbing', 'proposal.id_plot_dosbing', '=', 'plot_dosbing.id')
        ->join('semester', 'proposal.id_semester', '=', 'semester.id')
        ->select('proposal.id as id', 'proposal.nim as nim', 'mahasiswa.name as nama', 'proposal.judul as judul', 
        'proposal.proposal as proposal', 'proposal.ket1 as ket1' ,'proposal.ket2 as ket2', 'proposal.komentar as komentar', 'proposal.komentar1 as komentar1', 'proposal.komentar2 as komentar2', 'semester.semester as semester', 'semester.tahun as tahun',
        'plot_dosbing.dosbing1 as dosbing1', 'plot_dosbing.dosbing2 as dosbing2')
        ->where(function ($query) {
            $user = Auth::user();
            $dosen = $user -> no_induk;
            $query ->where('plot_dosbing.dosbing1', $dosen)
                    ->where('proposal.ket1', 'Menunggu ACC');
        })
        ->orWhere(function ($query) {
            $user = Auth::user();
            $dosen = $user -> no_induk;
            $query->where('proposal.ket2', 'Menunggu ACC')
                    ->where('plot_dosbing.dosbing2', $dosen);
        })
        ->count();

        $bimbwaitacc = DB::table('bimbingan')
            ->join('mahasiswa', 'bimbingan.nim', '=', 'mahasiswa.nim')
            ->join('proposal', 'bimbingan.id_proposal', '=', 'proposal.id')
            ->join('plot_dosbing', 'bimbingan.id_plot_dosbing', '=', 'plot_dosbing.id')
            ->join('semester', 'bimbingan.id_semester', '=', 'semester.id')
            ->select('bimbingan.id as id', 'bimbingan.nim as nim', 'mahasiswa.name as nama', 'proposal.judul as judul', 
            'bimbingan.bimbingan_ke as bimbingan_ke', 'bimbingan.file as file', 'bimbingan.ket1 as ket1', 'bimbingan.ket2 as ket2', 'bimbingan.komentar as komentar', 'semester.semester as semester', 'semester.tahun as tahun',
            'plot_dosbing.dosbing1 as dosbing1', 'plot_dosbing.dosbing2 as dosbing2')
            ->where(function ($query) {
                $user = Auth::user();
                $dosen = $user -> no_induk;
                $query ->where('plot_dosbing.dosbing1', $dosen)
                       ->where('bimbingan.ket1', 'Review');
            })
            ->orWhere(function ($query) {
                $user = Auth::user();
                $dosen = $user -> no_induk;
                $query->where('bimbingan.ket2', 'Review')
                      ->where('plot_dosbing.dosbing2', $dosen);
            })
            ->count();

            $jadwalsempro = DB::table('jadwal_sempro')
            ->join('mahasiswa', 'jadwal_sempro.nim', '=', 'mahasiswa.nim')
            ->join('berkas_sempro', 'jadwal_sempro.id_berkas_sempro', '=', 'berkas_sempro.id')
            ->join('proposal', 'berkas_sempro.id_proposal', '=', 'proposal.id')
            ->join('plot_dosbing', 'berkas_sempro.id_plot_dosbing', '=', 'plot_dosbing.id')
            ->select('jadwal_sempro.id as id', 'jadwal_sempro.nim as nim', 'mahasiswa.name as nama', 'berkas_sempro.id as id_berkas_sempro', 'berkas_sempro as berkas_sempro', 'proposal.id as id_proposal', 'proposal.judul as judul', 'proposal.proposal as proposal', 
            'plot_dosbing.dosbing1 as dosbing1', 'plot_dosbing.dosbing2 as dosbing2' ,'jadwal_sempro.tanggal as tanggal',
            'jadwal_sempro.jam as jam', 'jadwal_sempro.tempat as tempat', 'jadwal_sempro.ket as ket')
            // ->where(function ($query) {
            //         $user = Auth::user();
            //         $dosen = $user -> no_induk;
            //         $query ->where('plot_dosbing.dosbing1', $dosen)
            //                ->orWhere('plot_dosbing.dosbing2', $dosen);
            //     })
            ->where(function ($query) {
                $user = Auth::user();
                $dosen = $user -> no_induk;
                $query ->where('plot_dosbing.dosbing1', $dosen)
                        ->where('jadwal_sempro.status1', 'Belum');
            })
            ->orWhere(function ($query) {
                $user = Auth::user();
                $dosen = $user -> no_induk;
                $query->where('jadwal_sempro.status2', 'Belum')
                        ->where('plot_dosbing.dosbing2', $dosen);
            })
            ->count();

            $jadwalujian = DB::table('jadwal_ujian')
            ->join('mahasiswa', 'jadwal_ujian.nim', '=', 'mahasiswa.nim')
            ->join('berkas_ujian', 'jadwal_ujian.id_berkas_ujian', '=', 'berkas_ujian.id')
            ->join('proposal', 'berkas_ujian.id_proposal', '=', 'proposal.id')
            ->join('plot_penguji', 'berkas_ujian.id_plot_penguji', '=', 'plot_penguji.id')
            ->select('jadwal_ujian.id as id', 'jadwal_ujian.nim as nim', 'mahasiswa.name as nama', 'berkas_ujian.id as id_berkas_ujian', 'berkas_ujian as berkas_ujian', 'proposal.id as id_proposal', 'proposal.judul as judul', 'proposal.proposal as proposal', 
            'plot_penguji.ketua_penguji as ketua', 'plot_penguji.anggota_penguji_1 as anggota1', 'plot_penguji.anggota_penguji_2 as anggota2','jadwal_ujian.tanggal as tanggal',
            'jadwal_ujian.jam as jam', 'jadwal_ujian.tempat as tempat', 'jadwal_ujian.ket as ket')
            ->where(function ($query) {
                $user = Auth::user();
                $dosen = $user -> no_induk;
                $query ->where('plot_penguji.ketua_penguji', $dosen)
                        ->where('jadwal_ujian.status1', 'Belum');
            })
            ->orWhere(function ($query) {
                $user = Auth::user();
                $dosen = $user -> no_induk;
                $query->where('plot_penguji.anggota_penguji_1', $dosen)
                      ->where('jadwal_ujian.status2', 'Belum');
            })
            ->orWhere(function ($query) {
                $user = Auth::user();
                $dosen = $user -> no_induk;
                $query->where('plot_penguji.anggota_penguji_2', $dosen)
                      ->where('jadwal_ujian.status3', 'Belum');
            })
            ->count();

        return view('dosen.index', compact('user', 'totalmhs', 'totalmhsskripsi', 'propwaitacc', 'bimbwaitacc', 'jadwalsempro', 'jadwalujian'));
    }

    public function viewMahasiswaBimbingan(){
        $user = Auth::user();
        $dosen = $user -> no_induk;
        // $data = DB::table('plot_dosbing')
        //         ->join('mahasiswa', 'plot_dosbing.nim', '=', 'mahasiswa.nim')
        //         ->leftJoin('proposal', 'mahasiswa.nim', '=', 'proposal.nim')
        //         ->leftJoin('jadwal_sempro', 'mahasiswa.nim', '=', 'jadwal_sempro.nim')
        //         ->leftJoin('bimbingan', 'mahasiswa.nim', '=', 'bimbingan.nim')
        //         ->leftJoin('status_skripsi', 'mahasiswa.nim', '=', 'status_skripsi.nim')
        //         ->select('plot_dosbing.nim as nim', 'plot_dosbing.smt as smt', 'plot_dosbing.name as name', 
        //         DB::raw('(SELECT COUNT(proposal.id) FROM proposal WHERE proposal.nim = plot_dosbing.nim AND proposal.ket1 = "Disetujui" AND proposal.ket2 = "Disetujui") as proposal'),
        //         DB::raw('(SELECT COUNT(jadwal_sempro.id) FROM proposal WHERE jadwal_sempro.nim = plot_dosbing.nim) as jadwal_sempro'),
        //         DB::raw('(SELECT COUNT(bimbingan.id) FROM bimbingan WHERE bimbingan.nim = plot_dosbing.nim) as bimbingan'),
        //         DB::raw('(SELECT COUNT(status_skripsi.id) FROM status_skripsi WHERE status_skripsi.nim = plot_dosbing.nim) as status'))
                

        //         ->where('plot_dosbing.dosbing1', $dosen)
        //         ->orWhere('plot_dosbing.dosbing2', $dosen)
        //         // ->groupBy('proposal.id')
        //         ->get();

                // dd($data);

        $data = DB::table('plot_dosbing')
                ->join('mahasiswa', 'plot_dosbing.nim', '=', 'mahasiswa.nim')
                ->where('plot_dosbing.dosbing1', $dosen)
                ->orWhere('plot_dosbing.dosbing2', $dosen)
                ->orderByRaw('plot_dosbing.id DESC')
                ->get();
                // dd($data);
                
                
        return view ('dosen.mahasiswa.read',  compact('data', 'user'));
    }

    public function viewMahasiswaBimbinganFilter($id){
        $user = Auth::user();
        $dosen = $user -> no_induk;

        if($id==1){
            //option as dosbing 1
            $data = DB::table('plot_dosbing')
                ->join('mahasiswa', 'plot_dosbing.nim', '=', 'mahasiswa.nim')
                ->where('plot_dosbing.dosbing1', $dosen)
                ->orderByRaw('plot_dosbing.id DESC')
                ->get();
        }else if($id==2){
            //option as dosbing2
            $data = DB::table('plot_dosbing')
                ->join('mahasiswa', 'plot_dosbing.nim', '=', 'mahasiswa.nim')
                ->where('plot_dosbing.dosbing2', $dosen)
                ->orderByRaw('plot_dosbing.id DESC')
                ->get();
        }else if($id==3){
            //option all
            $data = DB::table('plot_dosbing')
                ->join('mahasiswa', 'plot_dosbing.nim', '=', 'mahasiswa.nim')
                ->where('plot_dosbing.dosbing1', $dosen)
                ->orWhere('plot_dosbing.dosbing2', $dosen)
                ->orderByRaw('plot_dosbing.id DESC')
                ->get();
        }

        return $data;
    }

    public function viewMahasiswaBimbinganDetail($id){
        $user = Auth::user();
        $mhs = DB::table('mahasiswa')
            ->where('mahasiswa.nim', $id)
            ->first();
        $plot = DB::table('plot_dosbing')
                ->where('plot_dosbing.nim', $id)
                ->first();
        $dosen1 = DB::table('dosen')
        ->join('s1', 'dosen.gelar1', '=', 's1.id')
        ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
        ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
        ->select('dosen.id as id', 'dosen.nidn as nidn', 'dosen.name as name', 's1.gelar as gelar1', 's2.gelar as gelar2', 's3.gelar as gelar3', 's3.depan as depan',
        'dosen.jabatan_fungsional as jabatan', 'dosen.email as email')
        ->where('nidn', $plot->dosbing1)->first();
        $dosen2 = DB::table('dosen')
        ->join('s1', 'dosen.gelar1', '=', 's1.id')
        ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
        ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
        ->select('dosen.id as id', 'dosen.nidn as nidn', 'dosen.name as name', 's1.gelar as gelar1', 's2.gelar as gelar2', 's3.gelar as gelar3', 's3.depan as depan',
        'dosen.jabatan_fungsional as jabatan', 'dosen.email as email')
        ->where('nidn', $plot->dosbing2)->first();
        // $pengajuan = DB::table('proposal')
        //             ->where('proposal.nim', $id)
        //             ->where('proposal.ket1', 'Disetujui')->where('proposal.ket2', 'Disetujui')
        //             ->count();
        // $sempro = DB::table('jadwal_sempro')
        //         ->where('jadwal_sempro.nim', $id)
        //         ->first();
        // $bimbingan = DB::table('bimbingan')
        //         ->where('bimbingan.nim', $id)
        //         ->orderByRaw('bimbingan.bimbingan_ke DESC')
        //         ->first();
        // $status = DB::table('status_skripsi')
        //         ->where('status_skripsi.nim', $id)
        //         ->first();
        return view ('dosen.mahasiswa.detail',  compact('plot', 'dosen1', 'dosen2', 'user', 'mhs'));
    }

    public function formEditProfil(){
        $user = Auth::user();
        $data = DB::table('dosen')
        ->join('s1', 'dosen.gelar1', '=', 's1.id')
        ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
        ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
        ->join('bidang', 'dosen.id_bidang', '=', 'bidang.id')
        ->select('dosen.id as id', 'dosen.nidn as nidn', 'dosen.name as name', 's1.gelar as gelar1', 's2.gelar as gelar2', 's3.gelar as gelar3', 's3.depan as depan',
        'dosen.jabatan_fungsional as jabatan', 'bidang.nama_bidang as bidang', 'dosen.email as email')
        ->where('nidn', $user->no_induk)->first();
        return view ('dosen.edit',  compact('data', 'user'));
    }
    public function updateProfil(Request $request, $id){
        $this->validate($request, [
			'photo' => 'max:2048',
		],
        [
            'photo.max' => 'File terlalu besar, maksimal 2 mb',
        ]);
        
        $nidn = $request->nidn;
        $name = $request->name;
        $email = $request->email;

        $photo = $request->file('photo');

        // Kalo ganti gambar 
        if($photo) {
            $tujuan_upload = 'photo';
    
            $photo->move($tujuan_upload,$photo->getClientOriginalName());
            
            $photo = $photo->getClientOriginalName();

            $data = DB::table('users')
            ->where('no_induk', $id)
            ->update(
            ['photo' => $photo]
            );
        }
        
        $data = DB::table('dosen')
        ->where('nidn', $id)
        ->update(
        ['name' => $name,
        'email' => $email]
        );

        $data = DB::table('users')
        ->where('no_induk', $id)
        ->update(
        ['email' => $email,]
        );

        return redirect('dosen')->with(['success' => 'Berhasil']);
    }

    public function viewProposalMahasiswa(){
        $user = Auth::user();
        $dosen = $user -> no_induk;

        $dosbing = DB::table('proposal')
            ->join('mahasiswa', 'proposal.nim', '=', 'mahasiswa.nim')
            ->join('plot_dosbing', 'proposal.id_plot_dosbing', '=', 'plot_dosbing.id')
            ->join('semester', 'proposal.id_semester', '=', 'semester.id')
            ->select('proposal.id as id', 'proposal.nim as nim', 'mahasiswa.name as nama', 'proposal.judul as judul', 
            'proposal.proposal as proposal', 'proposal.ket1 as ket1' ,'proposal.ket2 as ket2', 'proposal.komentar as komentar', 'proposal.komentar1 as komentar1', 'proposal.komentar2 as komentar2', 'semester.semester as semester', 'semester.tahun as tahun',
            'plot_dosbing.dosbing1 as dosbing1', 'plot_dosbing.dosbing2 as dosbing2')
            ->where('plot_dosbing.dosbing1', $dosen)
            ->orWhere('plot_dosbing.dosbing2', $dosen)
            ->orderByRaw('proposal.id DESC')
            ->get();
        // dd($dosbing);
        return view('dosen.monitoring.proposal.read', compact('dosbing', 'user'));
    }

    public function viewDetailProposal($id){
        $user = Auth::user();
        $data = DB::table('proposal')
        ->join('mahasiswa', 'proposal.nim', '=', 'mahasiswa.nim')
        ->join('plot_dosbing', 'proposal.id_plot_dosbing', '=', 'plot_dosbing.id')
        ->select('proposal.id as id', 'proposal.nim as nim', 'proposal.topik as topik', 'proposal.judul as judul', 'proposal.proposal as proposal', 'proposal.komentar as komentar', 'proposal.file1 as file1', 'proposal.file2 as file2',
        'proposal.ket1 as ket1', 'proposal.ket2 as ket2', 'proposal.komentar1 as komentar1', 'proposal.komentar2 as komentar2', 'mahasiswa.name as name',
        'plot_dosbing.dosbing1 as dosbing1', 'plot_dosbing.dosbing2 as dosbing2' )
        ->where('proposal.id', $id)
        ->get();
        $dosen1 = DB::table('dosen')
        ->join('s1', 'dosen.gelar1', '=', 's1.id')
        ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
        ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
        ->select('dosen.id as id', 'dosen.nidn as nidn', 'dosen.name as name', 's1.gelar as gelar1', 's2.gelar as gelar2', 's3.gelar as gelar3', 's3.depan as depan',
        'dosen.jabatan_fungsional as jabatan', 'dosen.email as email')
        ->where('nidn', $data[0]->dosbing1)->first();
        $dosen2 = DB::table('dosen')
        ->join('s1', 'dosen.gelar1', '=', 's1.id')
        ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
        ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
        ->select('dosen.id as id', 'dosen.nidn as nidn', 'dosen.name as name', 's1.gelar as gelar1', 's2.gelar as gelar2', 's3.gelar as gelar3', 's3.depan as depan',
        'dosen.jabatan_fungsional as jabatan', 'dosen.email as email')
        ->where('nidn', $data[0]->dosbing2)->first();
        return view('dosen.monitoring.proposal.detail', compact('data', 'user', 'dosen1', 'dosen2'));
    }

    public function viewProposalMahasiswaFilter($id){
        $user = Auth::user();
        $dosen = $user -> no_induk;

        if($id==1){
            //option as dosbing 1
            $dosbing = DB::table('proposal')
            ->join('mahasiswa', 'proposal.nim', '=', 'mahasiswa.nim')
            ->join('plot_dosbing', 'proposal.id_plot_dosbing', '=', 'plot_dosbing.id')
            ->join('semester', 'proposal.id_semester', '=', 'semester.id')
            ->select('proposal.id as id', 'proposal.nim as nim', 'mahasiswa.name as nama', 'proposal.judul as judul', 
            'proposal.proposal as proposal', 'proposal.ket1 as ket1' ,'proposal.ket2 as ket2', 'proposal.komentar as komentar', 'proposal.komentar1 as komentar1', 'proposal.komentar2 as komentar2', 'semester.semester as semester', 'semester.tahun as tahun',
            'plot_dosbing.dosbing1 as dosbing1', 'plot_dosbing.dosbing2 as dosbing2')
            ->where('plot_dosbing.dosbing1', $dosen)
            ->orderByRaw('proposal.id DESC')
            ->get();
        }else if($id==2){
            //option as dosbing2
            $dosbing = DB::table('proposal')
            ->join('mahasiswa', 'proposal.nim', '=', 'mahasiswa.nim')
            ->join('plot_dosbing', 'proposal.id_plot_dosbing', '=', 'plot_dosbing.id')
            ->join('semester', 'proposal.id_semester', '=', 'semester.id')
            ->select('proposal.id as id', 'proposal.nim as nim', 'mahasiswa.name as nama', 'proposal.judul as judul', 
            'proposal.proposal as proposal', 'proposal.ket1 as ket1' ,'proposal.ket2 as ket2', 'proposal.komentar as komentar', 'proposal.komentar1 as komentar1', 'proposal.komentar2 as komentar2', 'semester.semester as semester', 'semester.tahun as tahun',
            'plot_dosbing.dosbing1 as dosbing1', 'plot_dosbing.dosbing2 as dosbing2')
            ->where('plot_dosbing.dosbing2', $dosen)
            ->orderByRaw('proposal.id DESC')
            ->get();
        }else if($id==3){
            $dosbing = DB::table('proposal')
            ->join('mahasiswa', 'proposal.nim', '=', 'mahasiswa.nim')
            ->join('plot_dosbing', 'proposal.id_plot_dosbing', '=', 'plot_dosbing.id')
            ->join('semester', 'proposal.id_semester', '=', 'semester.id')
            ->select('proposal.id as id', 'proposal.nim as nim', 'mahasiswa.name as nama', 'proposal.judul as judul', 
            'proposal.proposal as proposal', 'proposal.ket1 as ket1' ,'proposal.ket2 as ket2', 'proposal.komentar as komentar', 'proposal.komentar1 as komentar1', 'proposal.komentar2 as komentar2', 'semester.semester as semester', 'semester.tahun as tahun',
            'plot_dosbing.dosbing1 as dosbing1', 'plot_dosbing.dosbing2 as dosbing2')
            ->where('plot_dosbing.dosbing1', $dosen)
            ->orWhere('plot_dosbing.dosbing2', $dosen)
            ->orderByRaw('proposal.id DESC')
            ->get();
        }else if($id==4){
            $dosbing = DB::table('proposal')
            ->join('mahasiswa', 'proposal.nim', '=', 'mahasiswa.nim')
            ->join('plot_dosbing', 'proposal.id_plot_dosbing', '=', 'plot_dosbing.id')
            ->join('semester', 'proposal.id_semester', '=', 'semester.id')
            ->select('proposal.id as id', 'proposal.nim as nim', 'mahasiswa.name as nama', 'proposal.judul as judul', 
            'proposal.proposal as proposal', 'proposal.ket1 as ket1' ,'proposal.ket2 as ket2', 'proposal.komentar as komentar', 'proposal.komentar1 as komentar1', 'proposal.komentar2 as komentar2', 'semester.semester as semester', 'semester.tahun as tahun',
            'plot_dosbing.dosbing1 as dosbing1', 'plot_dosbing.dosbing2 as dosbing2')
            ->where(function ($query) {
                $user = Auth::user();
                $dosen = $user -> no_induk;
                $query ->where('plot_dosbing.dosbing1', $dosen)
                       ->where('proposal.ket1', 'Menunggu ACC');
            })
            ->orWhere(function ($query) {
                $user = Auth::user();
                $dosen = $user -> no_induk;
                $query->where('proposal.ket2', 'Menunggu ACC')
                      ->where('plot_dosbing.dosbing2', $dosen);
            })
            ->orderByRaw('proposal.id DESC')
            ->get();
        }
        return $dosbing;
    }

    //Aksi
    public function accProposalMhs($id){
        $user = Auth::user();
        $dosen = $user -> no_induk;

        $dosen1 = DB::table('proposal')
        ->join('plot_dosbing', 'proposal.id_plot_dosbing', '=', 'plot_dosbing.id')
        ->select('plot_dosbing.dosbing1 as dosbing1')
        ->where('proposal.id', $id)
        ->first();

        $dosen2 = DB::table('proposal')
        ->join('plot_dosbing', 'proposal.id_plot_dosbing', '=', 'plot_dosbing.id')
        ->select('plot_dosbing.dosbing2 as dosbing2')
        ->where('proposal.id', $id)
        ->first();
        
        if(($dosen1->dosbing1) == $dosen){
            $data = DB::table('proposal')
            ->where('id', $id)
            ->update(
            ['ket1' => 'Disetujui']);
        }else if(($dosen2->dosbing2) == $dosen){
            $data = DB::table('proposal')
            ->where('id', $id)
            ->update(
            ['ket2' => 'Disetujui']);
        }

        $cekproposal = DB::table('proposal')
                            ->where('proposal.id', $id)
                            ->first();

                            // dd($cekproposal);

        if($cekproposal->ket1 == "Disetujui" && $cekproposal->ket2 == "Disetujui"){
            $data = DB::table('mahasiswa')
            ->where('nim', $cekproposal->nim)
            ->update(
            ['status_proposal' => 'Sudah mengajukan proposal']);
        }

        return redirect('dosen/monitoring/proposal')->with(['success' => 'Berhasil']);
    }

    public function tolakProposalMhs($id){
        $user = Auth::user();
        $dosen = $user -> no_induk;

        $dosen1 = DB::table('proposal')
        ->join('plot_dosbing', 'proposal.id_plot_dosbing', '=', 'plot_dosbing.id')
        ->select('plot_dosbing.dosbing1 as dosbing1')
        ->where('proposal.id', $id)
        ->first();

        $dosen2 = DB::table('proposal')
        ->join('plot_dosbing', 'proposal.id_plot_dosbing', '=', 'plot_dosbing.id')
        ->select('plot_dosbing.dosbing2 as dosbing2')
        ->where('proposal.id', $id)
        ->first();
        
        if(($dosen1->dosbing1) == $dosen){
            $data = DB::table('proposal')
            ->where('id', $id)
            ->update(
            ['ket1' => 'Ditolak']);
        }else if(($dosen2->dosbing2) == $dosen){
            $data = DB::table('proposal')
            ->where('id', $id)
            ->update(
            ['ket2' => 'Ditolak']);
        }

        return redirect('dosen/monitoring/proposal')->with(['success' => 'Berhasil']);
    }

    public function revisiProposalMhs(Request $request, $id){
        $this->validate($request, [
			'file_pendukung' => 'max:30720',
		],
        [
            'file_pendukung.max' => 'File terlalu besar, maksimal 30 mb',
        ]);

        $user = Auth::user();
        $dosen = $user -> no_induk;

        $komentar = $request->komentar;
        $file = $request->file('file_pendukung');

        $dosen1 = DB::table('proposal')
        ->join('plot_dosbing', 'proposal.id_plot_dosbing', '=', 'plot_dosbing.id')
        ->select('plot_dosbing.dosbing1 as dosbing1')
        ->where('proposal.id', $id)
        ->first();

        $dosen2 = DB::table('proposal')
        ->join('plot_dosbing', 'proposal.id_plot_dosbing', '=', 'plot_dosbing.id')
        ->select('plot_dosbing.dosbing2 as dosbing2')
        ->where('proposal.id', $id)
        ->first();
        
        if(($dosen1->dosbing1) == $dosen){
            $tujuan_upload = 'filemhs/'.$request->nim.'/proposal/revisi dari dosen';

            $namafile = rand().$file->getClientOriginalName();
    
            $file->move($tujuan_upload,$namafile);
            
            $file = $namafile;

            $data = DB::table('proposal')
            ->where('id', $id)
            ->update(
            ['ket1' => 'Revisi',
            'komentar1' => $komentar,
            'file1' => $file]
            );
        }else if(($dosen2->dosbing2) == $dosen){
            $tujuan_upload = 'filemhs/'.$request->nim.'/proposal/revisi dari dosen';

            $namafile = rand().$file->getClientOriginalName();
    
            $file->move($tujuan_upload,$namafile);
            
            $file = $namafile;

            $data = DB::table('proposal')
            ->where('id', $id)
            ->update(
            ['ket2' => 'Revisi',
            'komentar2' => $komentar,
            'file2' => $file]
            );
        }

        return redirect('dosen/monitoring/proposal')->with(['success' => 'Berhasil']);
    }

    //Seminar Proposal
    //Jadwal Seminar
    public function viewJadwalSempro(){
        $user = Auth::user();
        $data = DB::table('jadwal_sempro')
        ->join('mahasiswa', 'jadwal_sempro.nim', '=', 'mahasiswa.nim')
        ->join('berkas_sempro', 'jadwal_sempro.id_berkas_sempro', '=', 'berkas_sempro.id')
        ->join('proposal', 'berkas_sempro.id_proposal', '=', 'proposal.id')
        ->join('plot_dosbing', 'berkas_sempro.id_plot_dosbing', '=', 'plot_dosbing.id')
        ->select('jadwal_sempro.id as id', 'jadwal_sempro.nim as nim', 'mahasiswa.name as nama', 'berkas_sempro.id as id_berkas_sempro', 'berkas_sempro as berkas_sempro', 'proposal.id as id_proposal', 'proposal.judul as judul', 'proposal.proposal as proposal', 
        'plot_dosbing.dosbing1 as dosbing1', 'plot_dosbing.dosbing2 as dosbing2' ,'jadwal_sempro.tanggal as tanggal', 'jadwal_sempro.status1 as status1', 'jadwal_sempro.status2 as status2',
        'jadwal_sempro.jam as jam', 'jadwal_sempro.tempat as tempat', 'jadwal_sempro.ket as ket')
        ->where(function ($query) {
            $user = Auth::user();
            $dosen = $user -> no_induk;
            $query ->where('plot_dosbing.dosbing1', $dosen)
                    ->where('jadwal_sempro.status1', 'Belum');
        })
        ->orWhere(function ($query) {
            $user = Auth::user();
            $dosen = $user -> no_induk;
            $query->where('jadwal_sempro.status2', 'Belum')
                    ->where('plot_dosbing.dosbing2', $dosen);
        })
        ->orderByRaw('jadwal_sempro.tanggal ASC')
        // ->orderByRaw('jadwal_sempro.id DESC')
        ->get();
        return view('dosen.sempro.readjadwal', compact('data', 'user'));
    }

    public function viewDetailJadwalSempro($id){
        $user = Auth::user();
        $data = DB::table('jadwal_sempro')
        ->join('mahasiswa', 'jadwal_sempro.nim', '=', 'mahasiswa.nim')
        ->join('berkas_sempro', 'jadwal_sempro.id_berkas_sempro', '=', 'berkas_sempro.id')
        ->join('proposal', 'berkas_sempro.id_proposal', '=', 'proposal.id')
        ->join('plot_dosbing', 'berkas_sempro.id_plot_dosbing', '=', 'plot_dosbing.id')
        ->select('jadwal_sempro.id as id', 'jadwal_sempro.nim as nim', 'mahasiswa.name as nama', 'berkas_sempro.id as id_berkas_sempro', 'berkas_sempro as berkas_sempro', 'proposal.id as id_proposal', 'proposal.judul as judul', 'proposal.proposal as proposal', 
        'plot_dosbing.dosbing1 as dosbing1', 'plot_dosbing.dosbing2 as dosbing2' ,'jadwal_sempro.tanggal as tanggal',
        'jadwal_sempro.jam as jam', 'jadwal_sempro.tempat as tempat', 'jadwal_sempro.ket as ket',)
        ->where(function ($query) {
                $user = Auth::user();
                $dosen = $user -> no_induk;
                $query ->where('plot_dosbing.dosbing1', $dosen)
                       ->orWhere('plot_dosbing.dosbing2', $dosen);
            })
        ->where('jadwal_sempro.id', $id)
        ->get();

        $dosen1 = DB::table('dosen')
        ->join('s1', 'dosen.gelar1', '=', 's1.id')
        ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
        ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
        ->select('dosen.id as id', 'dosen.nidn as nidn', 'dosen.name as name', 's1.gelar as gelar1', 's2.gelar as gelar2', 's3.gelar as gelar3', 's3.depan as depan',
        'dosen.jabatan_fungsional as jabatan', 'dosen.email as email')
        ->where('nidn', $data[0]->dosbing1)->first();
        $dosen2 = DB::table('dosen')
        ->join('s1', 'dosen.gelar1', '=', 's1.id')
        ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
        ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
        ->select('dosen.id as id', 'dosen.nidn as nidn', 'dosen.name as name', 's1.gelar as gelar1', 's2.gelar as gelar2', 's3.gelar as gelar3', 's3.depan as depan',
        'dosen.jabatan_fungsional as jabatan', 'dosen.email as email')
        ->where('nidn', $data[0]->dosbing2)->first();

        $id_hasil_sempro = DB::table('hasil_sempro')
        ->select('hasil_sempro.id as id')
        ->where('nim', $data[0]->nim)
        ->orderByRaw('hasil_sempro.id DESC')->first();

        // dd($id_hasil_sempro);

        return view('dosen.sempro.detailjadwal', compact('data', 'user', 'dosen1', 'dosen2', 'id_hasil_sempro',));
    }

    public function cetakUndanganSempro($id){
        $user = Auth::user();
        $data = DB::table('jadwal_sempro')
        ->join('mahasiswa', 'jadwal_sempro.nim', '=', 'mahasiswa.nim')
        ->join('berkas_sempro', 'jadwal_sempro.id_berkas_sempro', '=', 'berkas_sempro.id')
        ->join('proposal', 'berkas_sempro.id_proposal', '=', 'proposal.id')
        ->join('plot_dosbing', 'berkas_sempro.id_plot_dosbing', '=', 'plot_dosbing.id')
        ->select('jadwal_sempro.id as id', 'jadwal_sempro.nim as nim', 'mahasiswa.name as nama', 'berkas_sempro.id as id_berkas_sempro', 'berkas_sempro as berkas_sempro', 'proposal.id as id_proposal', 'proposal.judul as judul', 'proposal.proposal as proposal', 
        'plot_dosbing.dosbing1 as dosbing1', 'plot_dosbing.dosbing2 as dosbing2' ,'jadwal_sempro.tanggal as tanggal',
        'jadwal_sempro.jam as jam', 'jadwal_sempro.tempat as tempat', 'jadwal_sempro.ket as ket',)
        ->where('jadwal_sempro.id', $id)
        ->first();

        $dosen1 = DB::table('dosen')
        ->join('s1', 'dosen.gelar1', '=', 's1.id')
        ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
        ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
        ->select('dosen.id as id', 'dosen.nidn as nidn', 'dosen.name as name', 's1.gelar as gelar1', 's2.gelar as gelar2', 's3.gelar as gelar3', 's3.depan as depan',
        'dosen.jabatan_fungsional as jabatan', 'dosen.email as email')
        ->where('nidn', $data->dosbing1)->first();
        $dosen2 = DB::table('dosen')
        ->join('s1', 'dosen.gelar1', '=', 's1.id')
        ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
        ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
        ->select('dosen.id as id', 'dosen.nidn as nidn', 'dosen.name as name', 's1.gelar as gelar1', 's2.gelar as gelar2', 's3.gelar as gelar3', 's3.depan as depan',
        'dosen.jabatan_fungsional as jabatan', 'dosen.email as email')
        ->where('nidn', $data->dosbing2)->first();

        return view ('dosen.sempro.dokumen.undangan_sempro_pdf',  compact('user', 'data', 'dosen1', 'dosen2'));
        
    }

    //Hasil Seminar
    public function viewHasilSempro(){
        $user = Auth::user();
        $data = DB::table('hasil_sempro')
        ->join('mahasiswa', 'hasil_sempro.nim', '=', 'mahasiswa.nim')
        ->join('proposal', 'hasil_sempro.id_proposal', '=', 'proposal.id')
        ->join('jadwal_sempro', 'hasil_sempro.id_jadwal_sempro', '=', 'jadwal_sempro.id')
        ->join('plot_dosbing', 'proposal.id_plot_dosbing', '=', 'plot_dosbing.id')
        ->select('hasil_sempro.id as id', 'hasil_sempro.nim as nim', 'mahasiswa.name as nama', 'proposal.judul as judul', 'jadwal_sempro.status1 as status1', 'jadwal_sempro.status2 as status2', 'hasil_sempro.berita_acara as berita_acara',
        'jadwal_sempro.tanggal as tanggal', 'jadwal_sempro.jam as jam', 'jadwal_sempro.tempat as tempat', 'jadwal_sempro.ket as ket',)
        ->where(function ($query) {
                $user = Auth::user();
                $dosen = $user -> no_induk;
                $query ->where('plot_dosbing.dosbing1', $dosen)
                       ->orWhere('plot_dosbing.dosbing2', $dosen);
            })
        ->orderByRaw('hasil_sempro.id DESC')
        ->get();
        return view('dosen.sempro.readhasil', compact('data', 'user'));
    }

    public function viewDetailHasilSempro($id){
        $user = Auth::user();
        $data = DB::table('hasil_sempro')
        ->join('mahasiswa', 'hasil_sempro.nim', '=', 'mahasiswa.nim')
        ->join('proposal', 'hasil_sempro.id_proposal', '=', 'proposal.id')
        ->join('jadwal_sempro', 'hasil_sempro.id_jadwal_sempro', '=', 'jadwal_sempro.id')
        ->join('plot_dosbing', 'proposal.id_plot_dosbing', '=', 'plot_dosbing.id')
        ->select('hasil_sempro.id as id', 'hasil_sempro.nim as nim', 'mahasiswa.name as nama', 'proposal.judul as judul', 'plot_dosbing.dosbing1 as dosbing1', 'plot_dosbing.dosbing2 as dosbing2',
        'jadwal_sempro.tanggal as tanggal', 'jadwal_sempro.jam as jam', 'jadwal_sempro.tempat as tempat', 'jadwal_sempro.ket as ket',
        'jadwal_sempro.status1 as status1', 'jadwal_sempro.status2 as status2', 'hasil_sempro.berita_acara as berita_acara', 'hasil_sempro.*')
        ->where('hasil_sempro.id', $id)
        ->get();

        $dosen1 = DB::table('dosen')
        ->join('s1', 'dosen.gelar1', '=', 's1.id')
        ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
        ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
        ->select('dosen.id as id', 'dosen.nidn as nidn', 'dosen.name as name', 's1.gelar as gelar1', 's2.gelar as gelar2', 's3.gelar as gelar3', 's3.depan as depan',
        'dosen.jabatan_fungsional as jabatan', 'dosen.email as email')
        ->where('nidn', $data[0]->dosbing1)->first();
        $dosen2 = DB::table('dosen')
        ->join('s1', 'dosen.gelar1', '=', 's1.id')
        ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
        ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
        ->select('dosen.id as id', 'dosen.nidn as nidn', 'dosen.name as name', 's1.gelar as gelar1', 's2.gelar as gelar2', 's3.gelar as gelar3', 's3.depan as depan',
        'dosen.jabatan_fungsional as jabatan', 'dosen.email as email')
        ->where('nidn', $data[0]->dosbing2)->first();

        return view('dosen.sempro.detailhasil', compact('data', 'user', 'dosen1', 'dosen2'));
    }

    public function insertHasilSempro(Request $request){
        $this->validate($request, [
			'file_pendukung1' => 'max:30720',
            'file_pendukung2' => 'max:30720',
		],
        [
            'file_pendukung1.max' => 'File terlalu besar, maksimal 30 mb',
            'file_pendukung2.max' => 'File terlalu besar, maksimal 30 mb',
        ]);

        $user = Auth::user();
        $dosen = $user -> no_induk;


        $dosen1 = DB::table('proposal')
        ->join('plot_dosbing', 'proposal.id_plot_dosbing', '=', 'plot_dosbing.id')
        ->select('plot_dosbing.dosbing1 as dosbing1')
        ->where('proposal.id', $request->id_proposal)
        ->first();

        $dosen2 = DB::table('proposal')
        ->join('plot_dosbing', 'proposal.id_plot_dosbing', '=', 'plot_dosbing.id')
        ->select('plot_dosbing.dosbing2 as dosbing2')
        ->where('proposal.id', $request->id_proposal)
        ->first();

        // dd($dosen);
        
        if(($dosen1->dosbing1) == $dosen){
            $file1 = $request->file('file_pendukung1');

            if($file1 == null){
                $data = DB::table('hasil_sempro')
                ->where('id', $request->id_hasil_sempro)
                ->update(
                ['id_jadwal_sempro' => $request->id_jadwal_sempro,
                'berita_acara' => $request->berita_acara,
                'sikap1' => $request->sikap1,
                'presentasi1' => $request->presentasi1,
                'penguasaan1' => $request->penguasaan1,
                'jumlah1' => $request->jumlah1,
                'grade1' => $request->grade1,
                'revisi1' => $request->revisi1]
                );
    
                $data = DB::table('jadwal_sempro')
                ->where('id', $request->id_jadwal_sempro)
                ->update(
                ['status1' => 'Sudah',]
                );


            }else{

                $tujuan_upload1 = 'filemhs/'.$request->nim.'/proposal/revisi dari dosen';
    
                $namafile1 = rand().$file1->getClientOriginalName();
    
                $file1->move($tujuan_upload1,$namafile1);
                
                $file1 = $namafile1;
    
                $data = DB::table('hasil_sempro')
                ->where('id', $request->id_hasil_sempro)
                ->update(
                ['id_jadwal_sempro' => $request->id_jadwal_sempro,
                'berita_acara' => $request->berita_acara,
                'sikap1' => $request->sikap1,
                'presentasi1' => $request->presentasi1,
                'penguasaan1' => $request->penguasaan1,
                'jumlah1' => $request->jumlah1,
                'grade1' => $request->grade1,
                'revisi1' => $request->revisi1,
                'file1' => $file1]
                );
    
                $data = DB::table('jadwal_sempro')
                ->where('id', $request->id_jadwal_sempro)
                ->update(
                ['status1' => 'Sudah',]
                );
    
            }


        }else if(($dosen2->dosbing2) == $dosen){
            $file2 = $request->file('file_pendukung2');

            if($file2 == null){
                $data = DB::table('hasil_sempro')
                ->where('id', $request->id_hasil_sempro)
                ->update(
                ['id_jadwal_sempro' => $request->id_jadwal_sempro,
                'sikap2' => $request->sikap2,
                'presentasi2' => $request->presentasi2,
                'penguasaan2' => $request->penguasaan2,
                'jumlah2' => $request->jumlah2,
                'grade2' => $request->grade2,
                'revisi2' => $request->revisi2]
                );
    
                $data = DB::table('jadwal_sempro')
                ->where('id', $request->id_jadwal_sempro)
                ->update(
                ['status2' => 'Sudah',]
                );

            }else{

                $tujuan_upload2 = 'filemhs/'.$request->nim.'/proposal/revisi dari dosen';
    
                $namafile2 = rand().$file2->getClientOriginalName();
    
                $file2->move($tujuan_upload2,$namafile2);
                
                $file2 = $namafile2;
    
                $data = DB::table('hasil_sempro')
                ->where('id', $request->id_hasil_sempro)
                ->update(
                ['id_jadwal_sempro' => $request->id_jadwal_sempro,
                'sikap2' => $request->sikap2,
                'presentasi2' => $request->presentasi2,
                'penguasaan2' => $request->penguasaan2,
                'jumlah2' => $request->jumlah2,
                'grade2' => $request->grade2,
                'revisi2' => $request->revisi2,
                'file2' => $file2]
                );
    
                $data = DB::table('jadwal_sempro')
                ->where('id', $request->id_jadwal_sempro)
                ->update(
                ['status2' => 'Sudah',]
                );
            }

        }

        $cek = DB::table('jadwal_sempro')
                    ->where('jadwal_sempro.id', $request->id_jadwal_sempro)
                    ->first();

        $cek2 = DB::table('hasil_sempro')
        ->where('hasil_sempro.id', $request->id_hasil_sempro)
        ->first();

        // dd($cek);

        if($cek->status1 == "Sudah" && $cek->status2 == "Sudah" && $cek2->berita_acara == "Diterima"){
            $data = DB::table('mahasiswa')
            ->where('nim', $cek->nim)
            ->update(
            ['status_sempro' => 'Sudah seminar proposal',
            'status_skripsi' => 'Sedang dikerjakan',
            'status_ujian' => 'Belum ujian']);

            $ssModel = new StatusSkripsiModel;
    
                $ssModel->nim = $request->nim;
                $ssModel->id_proposal = $request->id_proposal;
    
                $ssModel->save();
        }

        return redirect('dosen/sempro/hasil')->with(['success' => 'Berhasil']);
    }

    public function cetakDokumenSempro($id){
        $user = Auth::user();
        $data = DB::table('hasil_sempro')
        ->join('mahasiswa', 'hasil_sempro.nim', '=', 'mahasiswa.nim')
        ->join('proposal', 'hasil_sempro.id_proposal', '=', 'proposal.id')
        ->join('plot_dosbing', 'proposal.id_plot_dosbing', '=', 'plot_dosbing.id')
        ->join('jadwal_sempro', 'hasil_sempro.id_jadwal_sempro', '=', 'jadwal_sempro.id')
        ->select('hasil_sempro.id as id', 'hasil_sempro.nim as nim', 'mahasiswa.name as nama', 'proposal.judul as judul', 'hasil_sempro.berita_acara as berita_acara', 'jadwal_sempro.tanggal as tanggal', 'jadwal_sempro.jam as jam', 'jadwal_sempro.tempat as tempat',
        'hasil_sempro.sikap1 as sikap1', 'hasil_sempro.presentasi1 as presentasi1', 'hasil_sempro.penguasaan1 as penguasaan1', 'hasil_sempro.jumlah1 as jumlah1', 'hasil_sempro.grade1 as grade1', 'hasil_sempro.revisi1 as revisi1',
        'hasil_sempro.sikap2 as sikap2', 'hasil_sempro.presentasi2 as presentasi2', 'hasil_sempro.penguasaan2 as penguasaan2', 'hasil_sempro.jumlah2 as jumlah2', 'hasil_sempro.grade2 as grade2', 'hasil_sempro.revisi2 as revisi2',
        'plot_dosbing.dosbing1 as dosbing1', 'plot_dosbing.dosbing2 as dosbing2')
        ->where('hasil_sempro.id', $id)
        ->first();

        // dd($id);

        $dosen1 = DB::table('dosen')
        ->join('s1', 'dosen.gelar1', '=', 's1.id')
        ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
        ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
        ->select('dosen.id as id', 'dosen.nidn as nidn', 'dosen.name as name', 'dosen.ttd as ttd', 's1.gelar as gelar1', 's2.gelar as gelar2', 's3.gelar as gelar3', 's3.depan as depan',
        'dosen.jabatan_fungsional as jabatan', 'dosen.email as email')
        ->where('nidn', $data->dosbing1)->first();
        $dosen2 = DB::table('dosen')
        ->join('s1', 'dosen.gelar1', '=', 's1.id')
        ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
        ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
        ->select('dosen.id as id', 'dosen.nidn as nidn', 'dosen.name as name', 'dosen.ttd as ttd', 's1.gelar as gelar1', 's2.gelar as gelar2', 's3.gelar as gelar3', 's3.depan as depan',
        'dosen.jabatan_fungsional as jabatan', 'dosen.email as email')
        ->where('nidn', $data->dosbing2)->first();

        return view ('dosen.sempro.dokumen.dokumen_sempro_pdf',  compact('user', 'data', 'dosen1', 'dosen2'));
        
    }




    // Skripsi
    public function viewSkripsiMahasiswa(){
        $user = Auth::user();
        $dosen = $user -> no_induk;

        $data = DB::table('status_skripsi')
            ->join('mahasiswa', 'status_skripsi.nim', '=', 'mahasiswa.nim')
            ->join('proposal', 'status_skripsi.id_proposal', '=', 'proposal.id')
            ->join('plot_dosbing', 'proposal.id_plot_dosbing', '=', 'plot_dosbing.id')
            ->join('semester', 'proposal.id_semester', '=', 'semester.id')
            ->select('status_skripsi.id as id', 'status_skripsi.nim as nim', 'mahasiswa.name as nama', 'proposal.judul as judul', 
            'semester.semester as semester', 'semester.tahun as tahun', 'status_skripsi.status_skripsi as status_skripsi', 'status_skripsi.status_ujian as status_ujian',
            'plot_dosbing.dosbing1 as dosbing1', 'plot_dosbing.dosbing2 as dosbing2')
            ->where('plot_dosbing.dosbing1', $dosen)
            ->orWhere('plot_dosbing.dosbing2', $dosen)
            ->orderByRaw('status_skripsi.id DESC')
            ->get();
        // dd($dosbing);
        return view('dosen.monitoring.skripsi.read', compact('data', 'user'));
    }

    public function viewSkripsiMahasiswaFilter($id){
        $user = Auth::user();
        $dosen = $user -> no_induk;

        if($id==1){
            //option as dosbing 1
            $data = DB::table('status_skripsi')
            ->join('mahasiswa', 'status_skripsi.nim', '=', 'mahasiswa.nim')
            ->join('proposal', 'status_skripsi.id_proposal', '=', 'proposal.id')
            ->join('plot_dosbing', 'proposal.id_plot_dosbing', '=', 'plot_dosbing.id')
            ->join('semester', 'proposal.id_semester', '=', 'semester.id')
            ->select('status_skripsi.id as id', 'status_skripsi.nim as nim', 'mahasiswa.name as nama', 'proposal.judul as judul', 
            'semester.semester as semester', 'semester.tahun as tahun', 'status_skripsi.status_skripsi as status_skripsi', 'status_skripsi.status_ujian as status_ujian',
            'plot_dosbing.dosbing1 as dosbing1', 'plot_dosbing.dosbing2 as dosbing2')
            ->where('plot_dosbing.dosbing1', $dosen)
            ->orderByRaw('status_skripsi.id DESC')
            ->get();
        }else if($id==2){
            //option as dosbing2
            $data = DB::table('status_skripsi')
            ->join('mahasiswa', 'status_skripsi.nim', '=', 'mahasiswa.nim')
            ->join('proposal', 'status_skripsi.id_proposal', '=', 'proposal.id')
            ->join('plot_dosbing', 'proposal.id_plot_dosbing', '=', 'plot_dosbing.id')
            ->join('semester', 'proposal.id_semester', '=', 'semester.id')
            ->select('status_skripsi.id as id', 'status_skripsi.nim as nim', 'mahasiswa.name as nama', 'proposal.judul as judul', 
            'semester.semester as semester', 'semester.tahun as tahun', 'status_skripsi.status_skripsi as status_skripsi', 'status_skripsi.status_ujian as status_ujian',
            'plot_dosbing.dosbing1 as dosbing1', 'plot_dosbing.dosbing2 as dosbing2')
            ->where('plot_dosbing.dosbing2', $dosen)
            ->orderByRaw('status_skripsi.id DESC')
            ->get();
        }else if($id==3){
            $data = DB::table('status_skripsi')
            ->join('mahasiswa', 'status_skripsi.nim', '=', 'mahasiswa.nim')
            ->join('proposal', 'status_skripsi.id_proposal', '=', 'proposal.id')
            ->join('plot_dosbing', 'proposal.id_plot_dosbing', '=', 'plot_dosbing.id')
            ->join('semester', 'proposal.id_semester', '=', 'semester.id')
            ->select('status_skripsi.id as id', 'status_skripsi.nim as nim', 'mahasiswa.name as nama', 'proposal.judul as judul', 
            'semester.semester as semester', 'semester.tahun as tahun', 'status_skripsi.status_skripsi as status_skripsi', 'status_skripsi.status_ujian as status_ujian',
            'plot_dosbing.dosbing1 as dosbing1', 'plot_dosbing.dosbing2 as dosbing2')
            ->where('plot_dosbing.dosbing1', $dosen)
            ->orWhere('plot_dosbing.dosbing2', $dosen)
            ->orderByRaw('status_skripsi.id DESC')
            ->get();
        }
        return $data;
    }



    //Bimbingan
    public function viewBimbinganMahasiswa(){
        $user = Auth::user();
        $dosen = $user -> no_induk;

        $dosbing = DB::table('bimbingan')
            ->join('mahasiswa', 'bimbingan.nim', '=', 'mahasiswa.nim')
            ->join('proposal', 'bimbingan.id_proposal', '=', 'proposal.id')
            ->join('plot_dosbing', 'bimbingan.id_plot_dosbing', '=', 'plot_dosbing.id')
            ->join('semester', 'bimbingan.id_semester', '=', 'semester.id')
            ->select('bimbingan.id as id', 'bimbingan.nim as nim', 'mahasiswa.name as nama', 'proposal.judul as judul', 
            'bimbingan.bimbingan_ke as bimbingan_ke', 'bimbingan.file as file', 'bimbingan.ket1 as ket1', 'bimbingan.ket2 as ket2', 'bimbingan.komentar as komentar', 'semester.semester as semester', 'semester.tahun as tahun',
            'plot_dosbing.dosbing1 as dosbing1', 'plot_dosbing.dosbing2 as dosbing2')
            ->where('plot_dosbing.dosbing1', $dosen)
            ->orWhere('plot_dosbing.dosbing2', $dosen)
            ->orderByRaw('bimbingan.id DESC')
            ->get();
        // dd($dosbing);
        return view('dosen.monitoring.bimbingan.read', compact('dosbing', 'user'));
    }

    public function viewBimbinganMahasiswaFilter($id){
        $user = Auth::user();
        $dosen = $user -> no_induk;

        if($id==1){
            //option as dosbing 1
            $dosbing = DB::table('bimbingan')
            ->join('mahasiswa', 'bimbingan.nim', '=', 'mahasiswa.nim')
            ->join('proposal', 'bimbingan.id_proposal', '=', 'proposal.id')
            ->join('plot_dosbing', 'bimbingan.id_plot_dosbing', '=', 'plot_dosbing.id')
            ->join('semester', 'bimbingan.id_semester', '=', 'semester.id')
            ->select('bimbingan.id as id', 'bimbingan.nim as nim', 'mahasiswa.name as nama', 'proposal.judul as judul', 
            'bimbingan.bimbingan_ke as bimbingan_ke', 'bimbingan.file as file', 'bimbingan.ket1 as ket1', 'bimbingan.ket2 as ket2', 'bimbingan.komentar as komentar', 'semester.semester as semester', 'semester.tahun as tahun',
            'plot_dosbing.dosbing1 as dosbing1', 'plot_dosbing.dosbing2 as dosbing2')
            ->where('plot_dosbing.dosbing1', $dosen)
            ->orderByRaw('bimbingan.id DESC')
            ->get();
        }else if($id==2){
            //option as dosbing2
            $dosbing = DB::table('bimbingan')
            ->join('mahasiswa', 'bimbingan.nim', '=', 'mahasiswa.nim')
            ->join('proposal', 'bimbingan.id_proposal', '=', 'proposal.id')
            ->join('plot_dosbing', 'bimbingan.id_plot_dosbing', '=', 'plot_dosbing.id')
            ->join('semester', 'bimbingan.id_semester', '=', 'semester.id')
            ->select('bimbingan.id as id', 'bimbingan.nim as nim', 'mahasiswa.name as nama', 'proposal.judul as judul', 
            'bimbingan.bimbingan_ke as bimbingan_ke', 'bimbingan.file as file', 'bimbingan.ket1 as ket1', 'bimbingan.ket2 as ket2', 'bimbingan.komentar as komentar', 'semester.semester as semester', 'semester.tahun as tahun',
            'plot_dosbing.dosbing1 as dosbing1', 'plot_dosbing.dosbing2 as dosbing2')
            ->where('plot_dosbing.dosbing2', $dosen)
            ->orderByRaw('bimbingan.id DESC')
            ->get();
        }else if($id==3){
            //option all
            $dosbing = DB::table('bimbingan')
            ->join('mahasiswa', 'bimbingan.nim', '=', 'mahasiswa.nim')
            ->join('proposal', 'bimbingan.id_proposal', '=', 'proposal.id')
            ->join('plot_dosbing', 'bimbingan.id_plot_dosbing', '=', 'plot_dosbing.id')
            ->join('semester', 'bimbingan.id_semester', '=', 'semester.id')
            ->select('bimbingan.id as id', 'bimbingan.nim as nim', 'mahasiswa.name as nama', 'proposal.judul as judul', 
            'bimbingan.bimbingan_ke as bimbingan_ke', 'bimbingan.file as file', 'bimbingan.ket1 as ket1', 'bimbingan.ket2 as ket2', 'bimbingan.komentar as komentar', 'semester.semester as semester', 'semester.tahun as tahun',
            'plot_dosbing.dosbing1 as dosbing1', 'plot_dosbing.dosbing2 as dosbing2')
            ->where('plot_dosbing.dosbing1', $dosen)
            ->orWhere('plot_dosbing.dosbing2', $dosen)
            ->orderByRaw('bimbingan.id DESC')
            ->get();
        }else if($id==4){
            //option menunggu
            $dosbing = DB::table('bimbingan')
            ->join('mahasiswa', 'bimbingan.nim', '=', 'mahasiswa.nim')
            ->join('proposal', 'bimbingan.id_proposal', '=', 'proposal.id')
            ->join('plot_dosbing', 'bimbingan.id_plot_dosbing', '=', 'plot_dosbing.id')
            ->join('semester', 'bimbingan.id_semester', '=', 'semester.id')
            ->select('bimbingan.id as id', 'bimbingan.nim as nim', 'mahasiswa.name as nama', 'proposal.judul as judul', 
            'bimbingan.bimbingan_ke as bimbingan_ke', 'bimbingan.file as file', 'bimbingan.ket1 as ket1', 'bimbingan.ket2 as ket2', 'bimbingan.komentar as komentar', 'semester.semester as semester', 'semester.tahun as tahun',
            'plot_dosbing.dosbing1 as dosbing1', 'plot_dosbing.dosbing2 as dosbing2')
            ->where(function ($query) {
                $user = Auth::user();
                $dosen = $user -> no_induk;
                $query ->where('plot_dosbing.dosbing1', $dosen)
                       ->where('bimbingan.ket1', 'Review');
            })
            ->orWhere(function ($query) {
                $user = Auth::user();
                $dosen = $user -> no_induk;
                $query->where('bimbingan.ket2', 'Review')
                      ->where('plot_dosbing.dosbing2', $dosen);
            })
            ->orderByRaw('bimbingan.id DESC')
            ->get();
        }
        return $dosbing;
    }


    public function viewBimbinganDetail($nim, $id){
        $user = Auth::user();
        $data = DB::table('bimbingan')
        ->join('mahasiswa', 'bimbingan.nim', '=', 'mahasiswa.nim')
        ->join('proposal', 'bimbingan.id_proposal', '=', 'proposal.id')
        ->join('plot_dosbing', 'bimbingan.id_plot_dosbing', '=', 'plot_dosbing.id')
        ->select('bimbingan.id as id', 'bimbingan.nim as nim', 'mahasiswa.name as nama', 'proposal.judul as judul', 
        'plot_dosbing.dosbing1 as dosbing1', 'plot_dosbing.dosbing2 as dosbing2', 'bimbingan.bimbingan_ke as bimbingan_ke',
        'bimbingan.file as file', 'bimbingan.ket1 as ket1', 'bimbingan.ket2 as ket2', 'bimbingan.komentar as komentar', 'bimbingan.created_at as tgl')
        ->where('bimbingan.nim', $nim)
        ->where('bimbingan.bimbingan_ke', $id)
        ->first();

        $dosen1 = DB::table('dosen')
        ->join('s1', 'dosen.gelar1', '=', 's1.id')
        ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
        ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
        ->select('dosen.id as id', 'dosen.nidn as nidn', 'dosen.name as name', 's1.gelar as gelar1', 's2.gelar as gelar2', 's3.gelar as gelar3', 's3.depan as depan',
        'dosen.jabatan_fungsional as jabatan', 'dosen.email as email')
        ->where('nidn', $data->dosbing1)->first();
        $dosen2 = DB::table('dosen')
        ->join('s1', 'dosen.gelar1', '=', 's1.id')
        ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
        ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
        ->select('dosen.id as id', 'dosen.nidn as nidn', 'dosen.name as name', 's1.gelar as gelar1', 's2.gelar as gelar2', 's3.gelar as gelar3', 's3.depan as depan',
        'dosen.jabatan_fungsional as jabatan', 'dosen.email as email')
        ->where('nidn', $data->dosbing2)->first();
        
        // dd($data);
        $id_bim = $data->id;

        $pesan = DB::table('pesan_bimbingan')
        ->join('users', 'pesan_bimbingan.id_user', '=', 'users.id')
        ->select('pesan_bimbingan.id as id', 'pesan_bimbingan.pesan as pesan', 'pesan_bimbingan.id_user as id_user', 'users.name as name', 'pesan_bimbingan.created_at as waktu', 'pesan_bimbingan.file_pendukung as file_pendukung')
        ->where('id_bimbingan', $id_bim)
        ->orderByRaw('pesan_bimbingan.id ASC')
        ->get();

        // dd($pesan);
        return view('dosen.monitoring.bimbingan.detail', compact('data', 'user', 'pesan', 'dosen1', 'dosen2'));
    }


    public function selesaiBimbinganMhs($id){
        $user = Auth::user();
        $dosen = $user -> no_induk;

        $dosen1 = DB::table('bimbingan')
        ->join('plot_dosbing', 'bimbingan.id_plot_dosbing', '=', 'plot_dosbing.id')
        ->select('plot_dosbing.dosbing1 as dosbing1')
        ->where('bimbingan.id', $id)
        ->first();

        $dosen2 = DB::table('bimbingan')
        ->join('plot_dosbing', 'bimbingan.id_plot_dosbing', '=', 'plot_dosbing.id')
        ->select('plot_dosbing.dosbing2 as dosbing2')
        ->where('bimbingan.id', $id)
        ->first();
        
        if(($dosen1->dosbing1) == $dosen){
            $data = DB::table('bimbingan')
            ->where('id', $id)
            ->update(
            ['ket1' => 'Ok']);
        }else if(($dosen2->dosbing2) == $dosen){
            $data = DB::table('bimbingan')
            ->where('id', $id)
            ->update(
            ['ket2' => 'Ok']);
        }

        $getid = DB::table('bimbingan')
        ->where('bimbingan.id', $id)
        ->first();

        $cek = DB::table('bimbingan')
                    ->where('bimbingan.nim', $getid->nim)
                    ->orderByRaw('bimbingan.bimbingan_ke DESC')
                    ->first();

        // dd($cek);

        $data = DB::table('mahasiswa')
        ->where('nim', $cek->nim)
        ->update(
        ['status_bimbingan' => 'Bimbingan Ke-'.$cek->bimbingan_ke]);
        

        return redirect('dosen/monitoring/bimbingan')->with(['success' => 'Berhasil']);
    }

    public function selesaiSemuaBimbinganMhs($id){
        $user = Auth::user();
        $dosen = $user -> no_induk;

        $dosen1 = DB::table('bimbingan')
        ->join('plot_dosbing', 'bimbingan.id_plot_dosbing', '=', 'plot_dosbing.id')
        ->select('plot_dosbing.dosbing1 as dosbing1')
        ->where('bimbingan.id', $id)
        ->first();

        $dosen2 = DB::table('bimbingan')
        ->join('plot_dosbing', 'bimbingan.id_plot_dosbing', '=', 'plot_dosbing.id')
        ->select('plot_dosbing.dosbing2 as dosbing2')
        ->where('bimbingan.id', $id)
        ->first();
        
        
        $finish = DB::table('bimbingan')
        ->where('id', $id)
        ->update(
        ['ket1' => 'Selesai Bimbingan',
        'ket2' => 'Selesai Bimbingan']);

        $getid = DB::table('bimbingan')
        ->where('bimbingan.id', $id)
        ->first();

        $cek = DB::table('bimbingan')
                    ->where('bimbingan.nim', $getid->nim)
                    ->orderByRaw('bimbingan.bimbingan_ke DESC')
                    ->first();

        $data = DB::table('mahasiswa')
        ->where('nim', $cek->nim)
        ->update(
        ['status_bimbingan' => 'Selesai Semua Bimbingan']);

        return redirect('dosen/monitoring/bimbingan')->with(['success' => 'Berhasil']);
    }


    public function insertPesan(Request $request){
        $this->validate($request, [
			'file_pendukung' => 'max:30720',
		],
        [
            'file_pendukung.max' => 'File terlalu besar, maksimal 30 mb',
        ]);

		$file = $request->file('file_pendukung');

        if($file){
            $pbModel = new PesanBimbinganModel;

            $pbModel->id_bimbingan = $request->id_bimbingan;
            $pbModel->id_user = $request->id_user;
            $pbModel->pesan = $request->pesan;

            $tujuan_upload = 'filemhs/'.$request->nim.'/bimbingan/revisi dari dosen';

            $namafile = rand().$file->getClientOriginalName();

            $file->move($tujuan_upload,$namafile);

            $pbModel->file_pendukung = $namafile;

            $pbModel->created_at = Carbon::now('GMT+7');
            $pbModel->save();
        }else{
            $pbModel = new PesanBimbinganModel;

            $pbModel->id_bimbingan = $request->id_bimbingan;
            $pbModel->id_user = $request->id_user;
            $pbModel->pesan = $request->pesan;
            $pbModel->created_at = Carbon::now('GMT+7');
            $pbModel->save();
        }

        
        
        return redirect()->back()->with(['success' => 'Berhasil']);
    }


    //Cetak
    public function cetakBeritaAcara(){

        // $pdf = PDF::loadview('dosen.ujian.berita.berita_acara_pdf', compact('data', 'user'));
        // return $pdf->stream("pedeef.pdf", array("Attachment" => false));

        return view ('dosen.ujian.dokumen.undangan_ujian_pdf');

        // return $pdf->download('berita-acara-pdf');
        
    }



    //Jadwal Ujian Skripsi
    public function viewJadwalUjian(){
        $user = Auth::user();
        $data = DB::table('jadwal_ujian')
        ->join('mahasiswa', 'jadwal_ujian.nim', '=', 'mahasiswa.nim')
        ->join('berkas_ujian', 'jadwal_ujian.id_berkas_ujian', '=', 'berkas_ujian.id')
        ->join('proposal', 'berkas_ujian.id_proposal', '=', 'proposal.id')
        ->join('plot_penguji', 'berkas_ujian.id_plot_penguji', '=', 'plot_penguji.id')
        ->select('jadwal_ujian.id as id', 'jadwal_ujian.nim as nim', 'mahasiswa.name as nama', 'berkas_ujian.id as id_berkas_ujian', 'berkas_ujian as berkas_ujian', 'proposal.id as id_proposal', 'proposal.judul as judul', 'proposal.proposal as proposal', 
        'plot_penguji.ketua_penguji as ketua', 'plot_penguji.anggota_penguji_1 as anggota1', 'plot_penguji.anggota_penguji_2 as anggota2','jadwal_ujian.tanggal as tanggal',
        'jadwal_ujian.jam as jam', 'jadwal_ujian.tempat as tempat', 'jadwal_ujian.ket as ket')
        ->where(function ($query) {
            $user = Auth::user();
            $dosen = $user -> no_induk;
            $query ->where('plot_penguji.ketua_penguji', $dosen)
                    ->where('jadwal_ujian.status1', 'Belum');
        })
        ->orWhere(function ($query) {
            $user = Auth::user();
            $dosen = $user -> no_induk;
            $query->where('plot_penguji.anggota_penguji_1', $dosen)
                    ->where('jadwal_ujian.status2', 'Belum');
        })
        ->orWhere(function ($query) {
            $user = Auth::user();
            $dosen = $user -> no_induk;
            $query->where('plot_penguji.anggota_penguji_2', $dosen)
                    ->where('jadwal_ujian.status3', 'Belum');
        })
        ->orderByRaw('jadwal_ujian.tanggal ASC')
        // ->orderByRaw('jadwal_ujian.id DESC')
        ->get();
        return view('dosen.ujian.readjadwal', compact('data', 'user'));
    }

    public function viewDetailJadwalujian($id){
        $user = Auth::user();
        $data = DB::table('jadwal_ujian')
        ->join('mahasiswa', 'jadwal_ujian.nim', '=', 'mahasiswa.nim')
        ->join('berkas_ujian', 'jadwal_ujian.id_berkas_ujian', '=', 'berkas_ujian.id')
        ->join('proposal', 'berkas_ujian.id_proposal', '=', 'proposal.id')
        ->join('plot_penguji', 'berkas_ujian.id_plot_penguji', '=', 'plot_penguji.id')
        ->join('plot_dosbing', 'proposal.id_plot_dosbing', '=', 'plot_dosbing.id')

        ->select('jadwal_ujian.id as id', 'jadwal_ujian.nim as nim', 'mahasiswa.name as nama', 'mahasiswa.hp as hp', 'mahasiswa.email as email', 'berkas_ujian.id as id_berkas_ujian', 'proposal.judul as judul', 'proposal.id as id_proposal',
        'plot_dosbing.dosbing1 as dosbing1', 'plot_dosbing.dosbing2 as dosbing2' ,'jadwal_ujian.tanggal as tanggal', 'berkas_ujian.created_at as tgl_daftar', 'berkas_ujian.berkas_ujian as berkas_ujian',
        'jadwal_ujian.jam as jam', 'jadwal_ujian.tempat as tempat', 'jadwal_ujian.ket as ket', 'jadwal_ujian.status1 as status1', 'jadwal_ujian.status2 as status2', 'jadwal_ujian.status3 as status3',
        'plot_penguji.ketua_penguji as ketua_penguji', 'plot_penguji.anggota_penguji_1 as anggota_penguji_1', 'plot_penguji.anggota_penguji_2 as anggota_penguji_2',)
        ->where('jadwal_ujian.id', $id)
        ->get();

        $dosen1 = DB::table('dosen')
        ->join('s1', 'dosen.gelar1', '=', 's1.id')
        ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
        ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
        ->select('dosen.id as id', 'dosen.nidn as nidn', 'dosen.name as name', 's1.gelar as gelar1', 's2.gelar as gelar2', 's3.gelar as gelar3', 's3.depan as depan',
        'dosen.jabatan_fungsional as jabatan', 'dosen.email as email')
        ->where('nidn', $data[0]->dosbing1)->first();
        $dosen2 = DB::table('dosen')
        ->join('s1', 'dosen.gelar1', '=', 's1.id')
        ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
        ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
        ->select('dosen.id as id', 'dosen.nidn as nidn', 'dosen.name as name', 's1.gelar as gelar1', 's2.gelar as gelar2', 's3.gelar as gelar3', 's3.depan as depan',
        'dosen.jabatan_fungsional as jabatan', 'dosen.email as email')
        ->where('nidn', $data[0]->dosbing2)->first();

        $ketua = DB::table('dosen')
        ->join('s1', 'dosen.gelar1', '=', 's1.id')
        ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
        ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
        ->select('dosen.id as id', 'dosen.nidn as nidn', 'dosen.name as name', 's1.gelar as gelar1', 's2.gelar as gelar2', 's3.gelar as gelar3', 's3.depan as depan',
        'dosen.jabatan_fungsional as jabatan', 'dosen.email as email')
        ->where('nidn', $data[0]->ketua_penguji)->first();
        $anggota1 = DB::table('dosen')
        ->join('s1', 'dosen.gelar1', '=', 's1.id')
        ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
        ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
        ->select('dosen.id as id', 'dosen.nidn as nidn', 'dosen.name as name', 's1.gelar as gelar1', 's2.gelar as gelar2', 's3.gelar as gelar3', 's3.depan as depan',
        'dosen.jabatan_fungsional as jabatan', 'dosen.email as email')
        ->where('nidn', $data[0]->anggota_penguji_1)->first();
        $anggota2 = DB::table('dosen')
        ->join('s1', 'dosen.gelar1', '=', 's1.id')
        ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
        ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
        ->select('dosen.id as id', 'dosen.nidn as nidn', 'dosen.name as name', 's1.gelar as gelar1', 's2.gelar as gelar2', 's3.gelar as gelar3', 's3.depan as depan',
        'dosen.jabatan_fungsional as jabatan', 'dosen.email as email')
        ->where('nidn', $data[0]->anggota_penguji_2)->first();

        $id_hasil_ujian = DB::table('hasil_ujian')
        ->select('hasil_ujian.id as id')
        ->where('nim', $data[0]->nim)
        ->orderByRaw('hasil_ujian.id DESC')->first();

        $id_status_skripsi = DB::table('status_skripsi')
        ->select('status_skripsi.id as id')
        ->where('nim', $data[0]->nim)
        ->orderByRaw('status_skripsi.id DESC')->first();

        return view('dosen.ujian.detailjadwal', compact('data', 'user', 'dosen1', 'dosen2', 'ketua', 'anggota1', 'anggota2', 'id_hasil_ujian', 'id_status_skripsi'));
    }

    public function cetakUndanganUjian($id){
        $user = Auth::user();
        $data = DB::table('jadwal_ujian')
        ->join('mahasiswa', 'jadwal_ujian.nim', '=', 'mahasiswa.nim')
        ->join('berkas_ujian', 'jadwal_ujian.id_berkas_ujian', '=', 'berkas_ujian.id')
        ->join('proposal', 'berkas_ujian.id_proposal', '=', 'proposal.id')
        ->join('plot_dosbing', 'proposal.id_plot_dosbing', '=', 'plot_dosbing.id')
        ->join('plot_penguji', 'berkas_ujian.id_plot_penguji', '=', 'plot_penguji.id')
        ->select('jadwal_ujian.id as id', 'jadwal_ujian.nim as nim', 'mahasiswa.name as nama', 'berkas_ujian.id as id_berkas_ujian', 'berkas_ujian as berkas_ujian', 'proposal.id as id_proposal', 'proposal.judul as judul', 'proposal.proposal as proposal', 
        'plot_dosbing.dosbing1 as dosbing1', 'plot_dosbing.dosbing2 as dosbing2', 'plot_penguji.ketua_penguji as ketua', 'plot_penguji.anggota_penguji_1 as anggota1', 'plot_penguji.anggota_penguji_2 as anggota2', 'jadwal_ujian.tanggal as tanggal',
        'jadwal_ujian.jam as jam', 'jadwal_ujian.tempat as tempat', 'jadwal_ujian.ket as ket',)
        ->where('jadwal_ujian.id', $id)
        ->first();

        // dd($data);

        $dosen1 = DB::table('dosen')
        ->join('s1', 'dosen.gelar1', '=', 's1.id')
        ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
        ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
        ->select('dosen.id as id', 'dosen.nidn as nidn', 'dosen.name as name', 's1.gelar as gelar1', 's2.gelar as gelar2', 's3.gelar as gelar3', 's3.depan as depan',
        'dosen.jabatan_fungsional as jabatan', 'dosen.email as email')
        ->where('nidn', $data->dosbing1)->first();
        $dosen2 = DB::table('dosen')
        ->join('s1', 'dosen.gelar1', '=', 's1.id')
        ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
        ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
        ->select('dosen.id as id', 'dosen.nidn as nidn', 'dosen.name as name', 's1.gelar as gelar1', 's2.gelar as gelar2', 's3.gelar as gelar3', 's3.depan as depan',
        'dosen.jabatan_fungsional as jabatan', 'dosen.email as email')
        ->where('nidn', $data->dosbing2)->first();
        $ketua = DB::table('dosen')
        ->join('s1', 'dosen.gelar1', '=', 's1.id')
        ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
        ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
        ->select('dosen.id as id', 'dosen.nidn as nidn', 'dosen.name as name', 's1.gelar as gelar1', 's2.gelar as gelar2', 's3.gelar as gelar3', 's3.depan as depan',
        'dosen.jabatan_fungsional as jabatan', 'dosen.email as email')
        ->where('nidn', $data->ketua)->first();
        $anggota1 = DB::table('dosen')
        ->join('s1', 'dosen.gelar1', '=', 's1.id')
        ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
        ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
        ->select('dosen.id as id', 'dosen.nidn as nidn', 'dosen.name as name', 's1.gelar as gelar1', 's2.gelar as gelar2', 's3.gelar as gelar3', 's3.depan as depan',
        'dosen.jabatan_fungsional as jabatan', 'dosen.email as email')
        ->where('nidn', $data->anggota1)->first();
        $anggota2 = DB::table('dosen')
        ->join('s1', 'dosen.gelar1', '=', 's1.id')
        ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
        ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
        ->select('dosen.id as id', 'dosen.nidn as nidn', 'dosen.name as name', 's1.gelar as gelar1', 's2.gelar as gelar2', 's3.gelar as gelar3', 's3.depan as depan',
        'dosen.jabatan_fungsional as jabatan', 'dosen.email as email')
        ->where('nidn', $data->anggota2)->first();

        return view ('dosen.ujian.dokumen.undangan_ujian_pdf',  compact('user', 'data', 'dosen1', 'dosen2', 'ketua', 'anggota1', 'anggota2'));
        
    }

    //Hasil Seminar
    public function viewHasilujian(){
        $user = Auth::user();
        $data = DB::table('hasil_ujian')
        ->join('mahasiswa', 'hasil_ujian.nim', '=', 'mahasiswa.nim')
        ->join('proposal', 'hasil_ujian.id_proposal', '=', 'proposal.id')
        ->join('jadwal_ujian', 'hasil_ujian.id_jadwal_ujian', '=', 'jadwal_ujian.id')
        ->join('plot_dosbing', 'proposal.id_plot_dosbing', '=', 'plot_dosbing.id')
        ->join('berkas_ujian', 'jadwal_ujian.id_berkas_ujian', '=', 'berkas_ujian.id')
        ->join('plot_penguji', 'berkas_ujian.id_plot_penguji', '=', 'plot_penguji.id')
        ->select('hasil_ujian.id as id', 'hasil_ujian.nim as nim', 'mahasiswa.name as nama', 'proposal.judul as judul', 'plot_penguji.ketua_penguji as ketua_penguji', 'plot_penguji.anggota_penguji_1 as anggota_penguji_1', 'plot_penguji.anggota_penguji_2 as anggota_penguji_2',
        'jadwal_ujian.tanggal as tanggal', 'jadwal_ujian.jam as jam', 'jadwal_ujian.tempat as tempat', 'jadwal_ujian.ket as ket', 'jadwal_ujian.status1 as status1', 'jadwal_ujian.status2 as status2', 'jadwal_ujian.status3 as status3', 'hasil_ujian.berita_acara as berita_acara')
        ->where(function ($query) {
            $user = Auth::user();
            $dosen = $user -> no_induk;
            $query ->where('plot_penguji.ketua_penguji', $dosen)
                    ->where('jadwal_ujian.status1', 'Sudah');
        })
        ->orWhere(function ($query) {
            $user = Auth::user();
            $dosen = $user -> no_induk;
            $query->where('plot_penguji.anggota_penguji_1', $dosen)
                    ->where('jadwal_ujian.status2', 'Sudah');
        })
        ->orWhere(function ($query) {
            $user = Auth::user();
            $dosen = $user -> no_induk;
            $query->where('plot_penguji.anggota_penguji_2', $dosen)
                    ->where('jadwal_ujian.status3', 'Sudah');
        })
        ->orderByRaw('hasil_ujian.id DESC')
        ->get();
        return view('dosen.ujian.readhasil', compact('data', 'user'));
    }

    public function viewDetailHasilUjian($id){
        $user = Auth::user();
        $data = DB::table('hasil_ujian')
        ->join('mahasiswa', 'hasil_ujian.nim', '=', 'mahasiswa.nim')
        ->join('proposal', 'hasil_ujian.id_proposal', '=', 'proposal.id')
        ->join('plot_dosbing', 'proposal.id_plot_dosbing', '=', 'plot_dosbing.id')
        ->join('jadwal_ujian', 'hasil_ujian.id_jadwal_ujian', '=', 'jadwal_ujian.id')
        ->join('berkas_ujian', 'jadwal_ujian.id_berkas_ujian', '=', 'berkas_ujian.id')
        ->join('plot_penguji', 'berkas_ujian.id_plot_penguji', '=', 'plot_penguji.id')
        ->select('hasil_ujian.id as id', 'hasil_ujian.nim as nim', 'mahasiswa.name as nama', 'proposal.judul as judul', 'hasil_ujian.berita_acara as berita_acara', 'jadwal_ujian.tanggal as tanggal', 'jadwal_ujian.jam as jam', 'jadwal_ujian.tempat as tempat',
        'plot_penguji.ketua_penguji as ketua', 'plot_penguji.anggota_penguji_1 as anggota_1', 'plot_penguji.anggota_penguji_2 as anggota_2',
        'hasil_ujian.sikap1 as sikap1', 'hasil_ujian.presentasi1 as presentasi1', 'hasil_ujian.teori1 as teori1', 'hasil_ujian.program1 as program1', 'hasil_ujian.jumlah1 as jumlah1', 'hasil_ujian.keterangan1 as keterangan1', 'hasil_ujian.revisi1 as revisi1',
        'hasil_ujian.sikap2 as sikap2', 'hasil_ujian.presentasi2 as presentasi2', 'hasil_ujian.teori2 as teori2', 'hasil_ujian.program2 as program2', 'hasil_ujian.jumlah2 as jumlah2', 'hasil_ujian.keterangan2 as keterangan2', 'hasil_ujian.revisi2 as revisi2',
        'hasil_ujian.sikap3 as sikap3', 'hasil_ujian.presentasi3 as presentasi3', 'hasil_ujian.teori3 as teori3', 'hasil_ujian.program3 as program3', 'hasil_ujian.jumlah3 as jumlah3', 'hasil_ujian.keterangan3 as keterangan3', 'hasil_ujian.revisi3 as revisi3',
        'plot_dosbing.dosbing1 as dosbing1', 'plot_dosbing.dosbing2 as dosbing2', 'jadwal_ujian.status1 as status1', 'jadwal_ujian.status2 as status2', 'jadwal_ujian.status3 as status3', 'jadwal_ujian.ket as ket', 'hasil_ujian.*')
        ->where('hasil_ujian.id', $id)
        ->get();

        // dd($data->dosbing1);

        $dosen1 = DB::table('dosen')
        ->join('s1', 'dosen.gelar1', '=', 's1.id')
        ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
        ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
        ->select('dosen.id as id', 'dosen.nidn as nidn', 'dosen.name as name', 'dosen.ttd as ttd','s1.gelar as gelar1', 's2.gelar as gelar2', 's3.gelar as gelar3', 's3.depan as depan',
        'dosen.jabatan_fungsional as jabatan', 'dosen.email as email')
        ->where('nidn', $data[0]->dosbing1)->first();
        $dosen2 = DB::table('dosen')
        ->join('s1', 'dosen.gelar1', '=', 's1.id')
        ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
        ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
        ->select('dosen.id as id', 'dosen.nidn as nidn', 'dosen.name as name', 'dosen.ttd as ttd','s1.gelar as gelar1', 's2.gelar as gelar2', 's3.gelar as gelar3', 's3.depan as depan',
        'dosen.jabatan_fungsional as jabatan', 'dosen.email as email')
        ->where('nidn', $data[0]->dosbing2)->first();

        $ketua = DB::table('dosen')
        ->join('s1', 'dosen.gelar1', '=', 's1.id')
        ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
        ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
        ->select('dosen.id as id', 'dosen.nidn as nidn', 'dosen.name as name', 'dosen.ttd as ttd','s1.gelar as gelar1', 's2.gelar as gelar2', 's3.gelar as gelar3', 's3.depan as depan',
        'dosen.jabatan_fungsional as jabatan', 'dosen.email as email')
        ->where('nidn', $data[0]->ketua)->first();
        $anggota1 = DB::table('dosen')
        ->join('s1', 'dosen.gelar1', '=', 's1.id')
        ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
        ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
        ->select('dosen.id as id', 'dosen.nidn as nidn', 'dosen.name as name', 'dosen.ttd as ttd','s1.gelar as gelar1', 's2.gelar as gelar2', 's3.gelar as gelar3', 's3.depan as depan',
        'dosen.jabatan_fungsional as jabatan', 'dosen.email as email')
        ->where('nidn', $data[0]->anggota_1)->first();
        $anggota2 = DB::table('dosen')
        ->join('s1', 'dosen.gelar1', '=', 's1.id')
        ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
        ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
        ->select('dosen.id as id', 'dosen.nidn as nidn', 'dosen.name as name', 'dosen.ttd as ttd','s1.gelar as gelar1', 's2.gelar as gelar2', 's3.gelar as gelar3', 's3.depan as depan',
        'dosen.jabatan_fungsional as jabatan', 'dosen.email as email')
        ->where('nidn', $data[0]->anggota_2)->first();

        // dd($data[0]->nim);

        return view('dosen.ujian.detailhasil', compact('data', 'user', 'dosen1', 'dosen2', 'ketua', 'anggota1', 'anggota2'));
    }

    public function insertHasilujian(Request $request){
        $this->validate($request, [
			'file_pendukung1' => 'max:30720',
            'file_pendukung2' => 'max:30720',
            'file_pendukung3' => 'max:30720',
		],
        [
            'file_pendukung1.max' => 'File terlalu besar, maksimal 30 mb',
            'file_pendukung2.max' => 'File terlalu besar, maksimal 30 mb',
            'file_pendukung3.max' => 'File terlalu besar, maksimal 30 mb',
        ]);

        $user = Auth::user();
        $dosen = $user -> no_induk;

        $ketua = DB::table('plot_penguji')
        ->select('plot_penguji.ketua_penguji as ketua')
        ->where('plot_penguji.nim', $request->nim)
        ->first();

        $anggota1 = DB::table('plot_penguji')
        ->select('plot_penguji.anggota_penguji_1 as anggota1')
        ->where('plot_penguji.nim', $request->nim)
        ->first();
        
        $anggota2 = DB::table('plot_penguji')
        ->select('plot_penguji.anggota_penguji_2 as anggota2')
        ->where('plot_penguji.nim', $request->nim)
        ->first();

        // dd($ketua);
        
        if(($ketua->ketua) == $dosen){
            $file1 = $request->file('file_pendukung1');

            if($file1 == null){
                $data = DB::table('hasil_ujian')
                ->where('id', $request->id_hasil_ujian)
                ->update(
                ['id_jadwal_ujian' => $request->id_jadwal_ujian,
                'berita_acara' => $request->berita_acara,
                'sikap1' => $request->sikap1,
                'presentasi1' => $request->presentasi1,
                'teori1' => $request->teori1,
                'program1' => $request->program1,
                'jumlah1' => $request->jumlah1,
                'keterangan1' => $request->keterangan1,
                'revisi1' => $request->revisi1]
                );
    
                $data = DB::table('jadwal_ujian')
                ->where('id', $request->id_jadwal_ujian)
                ->update(
                ['status1' => 'Sudah',]
                );
    

            }else{

                $tujuan_upload1 = 'filemhs/'.$request->nim.'/ujian/revisi dari dosen';
    
                $namafile1 = rand().$file1->getClientOriginalName();
    
                $file1->move($tujuan_upload1,$namafile1);
                
                $file1 = $namafile1;
    
                $data = DB::table('hasil_ujian')
                ->where('id', $request->id_hasil_ujian)
                ->update(
                ['id_jadwal_ujian' => $request->id_jadwal_ujian,
                'berita_acara' => $request->berita_acara,
                'sikap1' => $request->sikap1,
                'presentasi1' => $request->presentasi1,
                'teori1' => $request->teori1,
                'program1' => $request->program1,
                'jumlah1' => $request->jumlah1,
                'keterangan1' => $request->keterangan1,
                'revisi1' => $request->revisi1,
                'file1' => $file1]
                );
    
                $data = DB::table('jadwal_ujian')
                ->where('id', $request->id_jadwal_ujian)
                ->update(
                ['status1' => 'Sudah',]
                );
    
                
            }



        }else if(($anggota1->anggota1) == $dosen){
            $file2 = $request->file('file_pendukung2');

            if($file2 == null){
                $data = DB::table('hasil_ujian')
                ->where('id', $request->id_hasil_ujian)
                ->update(
                ['id_jadwal_ujian' => $request->id_jadwal_ujian,
                'sikap2' => $request->sikap2,
                'presentasi2' => $request->presentasi2,
                'teori2' => $request->teori2,
                'program2' => $request->program2,
                'jumlah2' => $request->jumlah2,
                'keterangan2' => $request->keterangan2,
                'revisi2' => $request->revisi2]
                );
    
                $data = DB::table('jadwal_ujian')
                ->where('id', $request->id_jadwal_ujian)
                ->update(
                ['status2' => 'Sudah',]
                );

            }else{

                $tujuan_upload2 = 'filemhs/'.$request->nim.'/ujian/revisi dari dosen';
    
                $namafile2 = rand().$file2->getClientOriginalName();
    
                $file2->move($tujuan_upload2,$namafile2);
                
                $file2 = $namafile2;
    
                $data = DB::table('hasil_ujian')
                ->where('id', $request->id_hasil_ujian)
                ->update(
                ['id_jadwal_ujian' => $request->id_jadwal_ujian,
                'sikap2' => $request->sikap2,
                'presentasi2' => $request->presentasi2,
                'teori2' => $request->teori2,
                'program2' => $request->program2,
                'jumlah2' => $request->jumlah2,
                'keterangan2' => $request->keterangan2,
                'revisi2' => $request->revisi2,
                'file2' => $file2]
                );
    
                $data = DB::table('jadwal_ujian')
                ->where('id', $request->id_jadwal_ujian)
                ->update(
                ['status2' => 'Sudah',]
                );
            }

        }else if(($anggota2->anggota2) == $dosen){
            $file3 = $request->file('file_pendukung3');

            if($file3 == null){
                $data = DB::table('hasil_ujian')
                ->where('id', $request->id_hasil_ujian)
                ->update(
                ['id_jadwal_ujian' => $request->id_jadwal_ujian,
                'sikap3' => $request->sikap3,
                'presentasi3' => $request->presentasi3,
                'teori3' => $request->teori3,
                'program3' => $request->program3,
                'jumlah3' => $request->jumlah3,
                'keterangan3' => $request->keterangan3,
                'revisi3' => $request->revisi3]
                );
    
                $data = DB::table('jadwal_ujian')
                ->where('id', $request->id_jadwal_ujian)
                ->update(
                ['status3' => 'Sudah',]
                );

            }else{

                $tujuan_upload3 = 'filemhs/'.$request->nim.'/ujian/revisi dari dosen';
    
                $namafile3 = rand().$file3->getClientOriginalName();
    
                $file3->move($tujuan_upload3,$namafile3);
                
                $file3 = $namafile3;
    
                $data = DB::table('hasil_ujian')
                ->where('id', $request->id_hasil_ujian)
                ->update(
                ['id_jadwal_ujian' => $request->id_jadwal_ujian,
                'sikap3' => $request->sikap3,
                'presentasi3' => $request->presentasi3,
                'teori3' => $request->teori3,
                'program3' => $request->program3,
                'jumlah3' => $request->jumlah3,
                'keterangan3' => $request->keterangan3,
                'revisi3' => $request->revisi3,
                'file3' => $file3]
                );
    
                $data = DB::table('jadwal_ujian')
                ->where('id', $request->id_jadwal_ujian)
                ->update(
                ['status3' => 'Sudah',]
                );
            }

        }

        $cek = DB::table('jadwal_ujian')
                    ->where('jadwal_ujian.id', $request->id_jadwal_ujian)
                    ->first();

        $cek2 = DB::table('hasil_ujian')
        ->where('hasil_ujian.id', $request->id_hasil_ujian)
        ->first();

        // dd($cek);

        if($cek->status1 == "Sudah" && $cek->status2 == "Sudah" && $cek->status3 == "Sudah" && $cek2->berita_acara == "Lulus"){
            $data = DB::table('status_skripsi')
                    ->where('id', $request->id_status_skripsi)
                    ->update(
                    ['status_skripsi' => 'Selesai',
                    'status_ujian' => $request->berita_acara,]
                    );
        
                    ///update mhs kolom status skripsi dan status ujian
                    $data = DB::table('mahasiswa')
                    ->where('nim', $request->nim)
                    ->update(
                    ['status_skripsi' => 'Selesai',
                    'status_ujian' => $request->berita_acara]);
        }



        return redirect('dosen/skripsi/hasil')->with(['success' => 'Berhasil']);
    }

    public function cetakDokumenUjian($id){
        $user = Auth::user();
        $data = DB::table('hasil_ujian')
        ->join('mahasiswa', 'hasil_ujian.nim', '=', 'mahasiswa.nim')
        ->join('proposal', 'hasil_ujian.id_proposal', '=', 'proposal.id')
        ->join('plot_dosbing', 'proposal.id_plot_dosbing', '=', 'plot_dosbing.id')
        ->join('jadwal_ujian', 'hasil_ujian.id_jadwal_ujian', '=', 'jadwal_ujian.id')
        ->join('berkas_ujian', 'jadwal_ujian.id_berkas_ujian', '=', 'berkas_ujian.id')
        ->join('plot_penguji', 'berkas_ujian.id_plot_penguji', '=', 'plot_penguji.id')
        ->select('hasil_ujian.id as id', 'hasil_ujian.nim as nim', 'mahasiswa.name as nama', 'proposal.judul as judul', 'hasil_ujian.berita_acara as berita_acara', 'jadwal_ujian.tanggal as tanggal', 'jadwal_ujian.jam as jam', 'jadwal_ujian.tempat as tempat',
        'plot_penguji.ketua_penguji as ketua', 'plot_penguji.anggota_penguji_1 as anggota_1', 'plot_penguji.anggota_penguji_2 as anggota_2',
        'hasil_ujian.sikap1 as sikap1', 'hasil_ujian.presentasi1 as presentasi1', 'hasil_ujian.teori1 as teori1', 'hasil_ujian.program1 as program1', 'hasil_ujian.jumlah1 as jumlah1', 'hasil_ujian.keterangan1 as keterangan1', 'hasil_ujian.revisi1 as revisi1',
        'hasil_ujian.sikap2 as sikap2', 'hasil_ujian.presentasi2 as presentasi2', 'hasil_ujian.teori2 as teori2', 'hasil_ujian.program2 as program2', 'hasil_ujian.jumlah2 as jumlah2', 'hasil_ujian.keterangan2 as keterangan2', 'hasil_ujian.revisi2 as revisi2',
        'hasil_ujian.sikap3 as sikap3', 'hasil_ujian.presentasi3 as presentasi3', 'hasil_ujian.teori3 as teori3', 'hasil_ujian.program3 as program3', 'hasil_ujian.jumlah3 as jumlah3', 'hasil_ujian.keterangan3 as keterangan3', 'hasil_ujian.revisi3 as revisi3',
        'plot_dosbing.dosbing1 as dosbing1', 'plot_dosbing.dosbing2 as dosbing2')
        ->where('hasil_ujian.id', $id)
        ->first();

        // dd($id);

        $dosen1 = DB::table('dosen')
        ->join('s1', 'dosen.gelar1', '=', 's1.id')
        ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
        ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
        ->select('dosen.id as id', 'dosen.nidn as nidn', 'dosen.name as name', 'dosen.ttd as ttd','s1.gelar as gelar1', 's2.gelar as gelar2', 's3.gelar as gelar3', 's3.depan as depan',
        'dosen.jabatan_fungsional as jabatan', 'dosen.email as email')
        ->where('nidn', $data->dosbing1)->first();
        $dosen2 = DB::table('dosen')
        ->join('s1', 'dosen.gelar1', '=', 's1.id')
        ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
        ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
        ->select('dosen.id as id', 'dosen.nidn as nidn', 'dosen.name as name', 'dosen.ttd as ttd','s1.gelar as gelar1', 's2.gelar as gelar2', 's3.gelar as gelar3', 's3.depan as depan',
        'dosen.jabatan_fungsional as jabatan', 'dosen.email as email')
        ->where('nidn', $data->dosbing2)->first();

        $ketua = DB::table('dosen')
        ->join('s1', 'dosen.gelar1', '=', 's1.id')
        ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
        ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
        ->select('dosen.id as id', 'dosen.nidn as nidn', 'dosen.name as name', 'dosen.ttd as ttd','s1.gelar as gelar1', 's2.gelar as gelar2', 's3.gelar as gelar3', 's3.depan as depan',
        'dosen.jabatan_fungsional as jabatan', 'dosen.email as email')
        ->where('nidn', $data->ketua)->first();
        $anggota1 = DB::table('dosen')
        ->join('s1', 'dosen.gelar1', '=', 's1.id')
        ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
        ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
        ->select('dosen.id as id', 'dosen.nidn as nidn', 'dosen.name as name', 'dosen.ttd as ttd','s1.gelar as gelar1', 's2.gelar as gelar2', 's3.gelar as gelar3', 's3.depan as depan',
        'dosen.jabatan_fungsional as jabatan', 'dosen.email as email')
        ->where('nidn', $data->anggota_1)->first();
        $anggota2 = DB::table('dosen')
        ->join('s1', 'dosen.gelar1', '=', 's1.id')
        ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
        ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
        ->select('dosen.id as id', 'dosen.nidn as nidn', 'dosen.name as name', 'dosen.ttd as ttd','s1.gelar as gelar1', 's2.gelar as gelar2', 's3.gelar as gelar3', 's3.depan as depan',
        'dosen.jabatan_fungsional as jabatan', 'dosen.email as email')
        ->where('nidn', $data->anggota_2)->first();

        return view ('dosen.ujian.dokumen.dokumen_ujian_pdf', compact('data', 'user', 'dosen1', 'dosen2', 'ketua', 'anggota1', 'anggota2', ));
        
    }
}
