<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Response;
use Illuminate\Support\Facades\Validator;

use App\PlotDosbingModel;
use App\MahasiswaModel;
use App\ProposalModel;
use App\BerkasSemproModel;
use App\SemesterModel;
use App\BimbinganModel;
use App\PesanBimbinganModel;
use App\BerkasUjianModel;
use App\PlotPengujiModel;
use App\BidangModel;
use ZipArchive;
use File;

class MahasiswaController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $data = PlotDosbingModel::all()->where('nim', $user -> no_induk)->first();
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

        $pengajuan = DB::table('proposal')
                    ->where('proposal.nim', $user->no_induk)
                    ->where('proposal.ket1', 'Disetujui')->where('proposal.ket2', 'Disetujui')
                    ->count();
        $sempro = DB::table('jadwal_sempro')
                ->where('jadwal_sempro.nim', $user->no_induk)
                ->first();
        $bimbingan = DB::table('bimbingan')
                ->where('bimbingan.nim', $user->no_induk)
                ->orderByRaw('bimbingan.bimbingan_ke DESC')
                ->first();
        $status = DB::table('status_skripsi')
                ->where('status_skripsi.nim', $user->no_induk)
                ->first();

        $mhs = MahasiswaModel::all()->where('nim', $user -> no_induk)->first();
        // dd($mhs[1]);
        return view('mahasiswa.index', compact('dosen1', 'dosen2', 'user', 'mhs', 'pengajuan', 'sempro', 'bimbingan', 'status'));
    }

    public function formEditProfil(){
        $user = Auth::user();
        $data = DB::table('mahasiswa')
                ->where('nim', $user->no_induk)->first();
        return view ('mahasiswa.edit',  compact('data', 'user'));
    }
    public function updateProfil(Request $request, $id){
        $this->validate($request, [
			'photo' => 'max:2048',
		],
        [
            'photo.max' => 'File terlalu besar, maksimal 2 mb',
        ]);
        
        $nim = $request->nim;
        $name = $request->name;
        $email = $request->email;
        $hp = $request->hp;

        $photo = $request->file('photo');

        // Kalo ganti gambar 
        if($photo) {
            $tujuan_upload = 'photo';
    
            $photo->move($tujuan_upload,$photo->getClientOriginalName());
            
            $photo = $photo->getClientOriginalName();

            $data = DB::table('users')
            ->where('no_induk', $id)
            ->update(
            ['photo' => $photo,]
            );
        }

        $data = DB::table('mahasiswa')
        ->where('nim', $id)
        ->update(
        ['name' => $name,
        'email' => $email,
        'hp' => $hp]
        );

        $data = DB::table('users')
        ->where('no_induk', $id)
        ->update(
        ['email' => $email,]
        );

        return redirect('mahasiswa')->with(['success' => 'Berhasil']);
    }


    // Pengajuan Proposal
    public function viewPengajuanProposal(){
        $user = Auth::user();
        $data = DB::table('proposal')
        ->join('mahasiswa', 'proposal.nim', '=', 'mahasiswa.nim')
        ->join('plot_dosbing', 'proposal.id_plot_dosbing', '=', 'plot_dosbing.id')
        ->join('semester', 'proposal.id_semester', '=', 'semester.id')
        ->select('plot_dosbing.dosbing2 as dosbing2', 'proposal.id as id', 'semester.semester as smt', 'semester.tahun as thn', 'proposal.nim as nim', 'proposal.topik as topik', 'proposal.judul as judul', 'proposal.proposal as proposal',
        'proposal.ket1 as ket1', 'proposal.ket2 as ket2', 'proposal.komentar1 as komentar1', 'proposal.komentar2 as komentar2', 'mahasiswa.name as name')
        ->where('proposal.nim', $user->no_induk)
        ->orderByRaw('proposal.id DESC')
        ->get();
        return view('mahasiswa.proposal.pengajuan.read', compact('data', 'user'));
    }
    public function viewDetailProposal($id){
        $user = Auth::user();
        $data = DB::table('proposal')
        ->join('mahasiswa', 'proposal.nim', '=', 'mahasiswa.nim')
        ->join('plot_dosbing', 'proposal.id_plot_dosbing', '=', 'plot_dosbing.id')
        ->select('proposal.id as id', 'proposal.nim as nim', 'proposal.topik as topik', 'proposal.judul as judul', 'proposal.proposal as proposal', 'proposal.komentar as komentar',
        'proposal.ket1 as ket1', 'proposal.ket2 as ket2', 'proposal.komentar1 as komentar1', 'proposal.komentar2 as komentar2', 'mahasiswa.name as name',
        'plot_dosbing.dosbing1 as dosbing1', 'plot_dosbing.dosbing2 as dosbing2', 'proposal.file1 as file1', 'proposal.file2 as file2' )
        ->where('proposal.nim', $user->no_induk)
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
        // dd($data);
        return view('mahasiswa.proposal.pengajuan.detail', compact('data', 'user', 'dosen1', 'dosen2'));
    }

    public function formAddProposal(){
        $user = Auth::user();
        $data = PlotDosbingModel::all()->where('nim', $user -> no_induk)->first();
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
        $smt = SemesterModel::all()->where('aktif', 'Y')->first();
        $bidang = DB::table('bidang')->get();
        return view ('mahasiswa.proposal.pengajuan.add', compact('dosen1', 'dosen2', 'data', 'smt', 'user', 'bidang'));
    }
    public function insertProposal(Request $request){
        $this->validate($request, [
			'proposal' => 'max:10240',
		],
        [
            'proposal.max' => 'File terlalu besar, maksimal 10 mb',
        ]);

        $cek = ProposalModel::where('judul', $request->judul)->first();
        
        if($cek){
            return back()->with('error','Judul sama dengan proposal dari nim '.$cek->nim.', silahkan cari judul yang lain');
        }else{
            $pModel = new ProposalModel;

            $pModel->id_semester = $request->smt;
            $pModel->nim = $request->nim;
            $pModel->topik = $request->topik;
            $pModel->judul = $request->judul;
            $pModel->id_plot_dosbing = $request->id_plot_dosbing;
            $pModel->komentar = $request->komentar;


            $file = $request->file('proposal');

            $tujuan_upload = 'filemhs/'.$request->nim.'/proposal';

            $namafile = rand().$file->getClientOriginalName();

            $file->move($tujuan_upload,$namafile);

            $pModel->proposal = $namafile;

            if($request->dosbing2=='-'){
                $pModel->ket2 = "Disetujui";
                $pModel->save();
            }else{
                $pModel->save();
            }

        }

        return redirect('mahasiswa/proposal/pengajuan')->with(['success' => 'Berhasil']);
    }
    public function downloadProposal($nim, $id)
    {
        $filepath = public_path('filemhs/'.$nim.'/proposal'.'/'.$id);
        return Response::download($filepath); 
    }

    public function editProposal(Request $request, $id){
        $this->validate($request, [
			'proposal' => 'max:10240',
		],
        [
            'proposal.max' => 'File terlalu besar, maksimal 10 mb',
        ]);
            
        $komentar = $request->komentar;

        $file = $request->file('proposal');

        $tujuan_upload = 'filemhs/'.$request->nim.'/proposal';

        $namafile = rand().$file->getClientOriginalName();

        $file->move($tujuan_upload,$namafile);

        $cek = DB::table('proposal')
                    ->where('proposal.id', $id)
                    ->orderByRaw('proposal.id DESC')
                    ->first();
        
        // dd($cek);

        if($cek->ket1 == "Disetujui" && $cek->ket2 == "Revisi"){
            $data = DB::table('proposal')
                ->where('id', $id)
                ->update(
                ['proposal' => $namafile,
                'komentar' => $komentar,
                'ket1' => 'Disetujui',
                'ket2' => 'Menunggu ACC']
                );
        }else if($cek->ket2 == "Disetujui" && $cek->ket1 == "Revisi"){
            $data = DB::table('proposal')
                ->where('id', $id)
                ->update(
                ['proposal' => $namafile,
                'komentar' => $komentar,
                'ket2' => 'Disetujui',
                'ket1' => 'Menunggu ACC']
                );
        }else if($cek->ket2 == "Revisi" && $cek->ket1 == "Revisi"){
            $data = DB::table('proposal')
            ->where('id', $id)
            ->update(
            ['proposal' => $namafile,
            'komentar' => $komentar,
            'ket2' => 'Menunggu ACC',
            'ket1' => 'Menunggu ACC']
            );
        }
            return redirect('mahasiswa/proposal/pengajuan')->with(['success' => 'Berhasil']);
    }


    ///Daftar Sempro
    public function viewDaftarSempro(){
        $user = Auth::user();
        $data = DB::table('berkas_sempro')
        ->join('mahasiswa', 'berkas_sempro.nim', '=', 'mahasiswa.nim')
        ->join('plot_dosbing', 'berkas_sempro.id_plot_dosbing', '=', 'plot_dosbing.id')
        ->join('proposal', 'berkas_sempro.id_proposal', '=', 'proposal.id')
        ->join('semester', 'berkas_sempro.id_semester', '=', 'semester.id')
        ->select('berkas_sempro.id as id', 'berkas_sempro.nim as nim', 'semester.semester as smt', 'semester.tahun as thn', 'mahasiswa.name as nama', 'mahasiswa.hp as hp', 'proposal.judul as judul', 'mahasiswa.status_sempro as status_sempro',
        'plot_dosbing.dosbing1 as dosbing1', 'plot_dosbing.dosbing2 as dosbing2' ,'berkas_sempro.*', 'berkas_sempro.status as status', 'berkas_sempro.komentar_admin as komentar')
        ->where('berkas_sempro.nim', $user->no_induk)
        ->where('proposal.ket1', 'Disetujui')->where('proposal.ket2', 'Disetujui')
        ->orderByRaw('berkas_sempro.id DESC')
        ->get();
        
        $dataprop = ProposalModel::all()->where('nim', $user -> no_induk)->where('ket1', 'Disetujui')->where('ket2', 'Disetujui')->first();
        
        return view('mahasiswa.proposal.pendaftaran.read', compact('data', 'dataprop', 'user'));
    }
    public function formAddSempro(){
        $user = Auth::user();
        $datamhs = MahasiswaModel::all()->where('nim', $user -> no_induk)->first();
        $datadosbing = PlotDosbingModel::all()->where('nim', $user -> no_induk)->first();
        $dosen1 = DB::table('dosen')
        ->join('s1', 'dosen.gelar1', '=', 's1.id')
        ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
        ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
        ->select('dosen.id as id', 'dosen.nidn as nidn', 'dosen.name as name', 's1.gelar as gelar1', 's2.gelar as gelar2', 's3.gelar as gelar3', 's3.depan as depan',
        'dosen.jabatan_fungsional as jabatan', 'dosen.email as email')
        ->where('nidn', $datadosbing->dosbing1)->first();
        $dosen2 = DB::table('dosen')
        ->join('s1', 'dosen.gelar1', '=', 's1.id')
        ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
        ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
        ->select('dosen.id as id', 'dosen.nidn as nidn', 'dosen.name as name', 's1.gelar as gelar1', 's2.gelar as gelar2', 's3.gelar as gelar3', 's3.depan as depan',
        'dosen.jabatan_fungsional as jabatan', 'dosen.email as email')
        ->where('nidn', $datadosbing->dosbing2)->first();
        $dataprop = ProposalModel::all()->where('nim', $user -> no_induk)->where('ket1', 'Disetujui')->where('ket2', 'Disetujui')->first();
        // dd($dataprop);
        return view ('mahasiswa.proposal.pendaftaran.add', compact('dosen1', 'dosen2', 'datamhs', 'datadosbing', 'dataprop', 'user'));
    }
    public function insertBerkas(Request $request){
        $this->validate($request, [
			'berkassempro' => 'max:20480',
		],
        [
            'berkassempro.max' => 'File terlalu besar, maksimal 20 mb',
        ]);

        $smt = SemesterModel::all()->where('aktif', 'Y')->first();

        $bsModel = new BerkasSemproModel;

        $bsModel->id_semester = $smt->id;

        $bsModel->nim = $request->nim;
        $bsModel->id_proposal = $request->id_proposal;
        $bsModel->id_plot_dosbing = $request->id_plot_dosbing;

		$berkassempro = $request->file('berkassempro');
        // $proposal = $request->file('proposal');
        // $krs = $request->file('krs');
        // $transkrip = $request->file('transkrip');

        $tujuan_upload = 'filemhs/'.$request->nim.'/berkas_sempro';

        $berkas = rand().$berkassempro->getClientOriginalName();
        // $namaproposal = rand().$proposal->getClientOriginalName();
        // $namakrs = rand().$krs->getClientOriginalName();
        // $namatranskrip = rand().$transkrip->getClientOriginalName();

        $berkassempro->move($tujuan_upload,$berkas);
        // $proposal->move($tujuan_upload,$namaproposal);
        // $krs->move($tujuan_upload,$namakrs);
        // $transkrip->move($tujuan_upload,$namatranskrip);

        $bsModel->berkas_sempro = $berkas;
        // $bsModel->proposal = $namaproposal;
        // $bsModel->krs = $namakrs;
        // $bsModel->transkrip = $namatranskrip;

        $bsModel->created_at = Carbon::now('GMT+7');

        $bsModel->save();

        $zip = new ZipArchive;
        $res = $zip->open('filemhs/'.$request->nim.'/berkas_sempro/'.$berkas);
        $zip->extractTo('filemhs/'.$request->nim.'/berkas_sempro/extract');
        $zip->close();
       

        return redirect('mahasiswa/proposal/daftarsempro')->with(['success' => 'Berhasil']);
    }
    public function downloadBerkasSempro($nim, $id)
    {
        $filepath = public_path('filemhs/'.$nim.'/berkas_sempro'.'/'.$id);
        return Response::download($filepath); 
    }

    //editberkas
    public function editBerkas(Request $request, $id){

        $delberkaslama = DB::table('berkas_sempro')
                    ->where('berkas_sempro.id', $id)
                    ->first();

        // unlink('filemhs/'.$request->nim.'/berkas_sempro'.'/'.$delberkaslama->berkas_sempro);

        $berkassempro = $request->file('berkassempro');
        // $proposal = $request->file('proposal');
        // $krs = $request->file('krs');
        // $transkrip = $request->file('transkrip');

        $tujuan_upload = 'filemhs/'.$request->nim.'/berkas_sempro';

        $berkas = rand().$berkassempro->getClientOriginalName();
        // $namaproposal = rand().$proposal->getClientOriginalName();
        // $namakrs = rand().$krs->getClientOriginalName();
        // $namatranskrip = rand().$transkrip->getClientOriginalName();

        $berkassempro->move($tujuan_upload,$berkas);
        // $proposal->move($tujuan_upload,$namaproposal);
        // $krs->move($tujuan_upload,$namakrs);
        // $transkrip->move($tujuan_upload,$namatranskrip);

        $data = DB::table('berkas_sempro')
            ->where('id', $id)
            ->update(
            ['berkas_sempro' => $berkas,
            // 'proposal' => $namaproposal,
            // 'krs' => $namakrs,
            // 'transkrip' => $namatranskrip,
            'status' => 'Menunggu Verifikasi']);

        $zip = new ZipArchive;
        $res = $zip->open('filemhs/'.$request->nim.'/berkas_sempro/'.$berkas);
        $zip->extractTo('filemhs/'.$request->nim.'/berkas_sempro/extract');
        $zip->close();
        
        return redirect('mahasiswa/proposal/daftarsempro')->with(['success' => 'Berhasil']);
    }

    //Jadwal Sempro
    public function viewJadwalSempro($id){
        $user = Auth::user();
        $data = DB::table('jadwal_sempro')
        ->join('mahasiswa', 'jadwal_sempro.nim', '=', 'mahasiswa.nim')
        ->join('berkas_sempro', 'jadwal_sempro.id_berkas_sempro', '=', 'berkas_sempro.id')
        ->join('proposal', 'berkas_sempro.id_proposal', '=', 'proposal.id')
        ->join('plot_dosbing', 'berkas_sempro.id_plot_dosbing', '=', 'plot_dosbing.id')
        ->join('semester', 'jadwal_sempro.id_semester', '=', 'semester.id')
        ->select('jadwal_sempro.id as id', 'semester.semester as smt', 'semester.tahun as thn', 'jadwal_sempro.nim as nim', 'mahasiswa.name as nama', 'berkas_sempro.id as id_berkas_sempro', 'berkas_sempro.status as status', 'proposal.judul as judul', 
        'plot_dosbing.dosbing1 as dosbing1', 'plot_dosbing.dosbing2 as dosbing2' ,'jadwal_sempro.tanggal as tanggal',
        'jadwal_sempro.jam as jam', 'jadwal_sempro.tempat as tempat', 'jadwal_sempro.ket as ket')
        ->where('jadwal_sempro.nim', $user->no_induk)
        ->where('jadwal_sempro.id', $id)
        // ->orderByRaw('jadwal_sempro.id DESC')
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
        // dd($data);
        return view('mahasiswa.proposal.penjadwalan.read', compact('data', 'user', 'dosen1', 'dosen2'));
    }


    //Hasil Sempro
    public function viewHasilSempro(){
        $user = Auth::user();
        $data = DB::table('hasil_sempro')
        ->join('mahasiswa', 'hasil_sempro.nim', '=', 'mahasiswa.nim')
        ->join('proposal', 'hasil_sempro.id_proposal', '=', 'proposal.id')
        ->join('jadwal_sempro', 'hasil_sempro.id_jadwal_sempro', '=', 'jadwal_sempro.id')
        ->join('plot_dosbing', 'proposal.id_plot_dosbing', '=', 'plot_dosbing.id')
        ->join('semester', 'proposal.id_semester', '=', 'semester.id')
        ->select('hasil_sempro.id as id', 'semester.semester as smt', 'semester.tahun as thn', 'hasil_sempro.nim as nim', 'mahasiswa.name as nama', 'proposal.judul as judul',
        'jadwal_sempro.tanggal as tanggal', 'jadwal_sempro.jam as jam', 'jadwal_sempro.tempat as tempat', 'jadwal_sempro.ket as ket',
        'jadwal_sempro.status1 as status1', 'jadwal_sempro.status2 as status2', 'hasil_sempro.berita_acara as berita_acara', 'hasil_sempro.*')
        ->where('hasil_sempro.nim', $user->no_induk)
        ->orderByRaw('hasil_sempro.id DESC')
        ->get();
        return view('mahasiswa.proposal.hasil.read', compact('data', 'user'));
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
        ->where('hasil_sempro.nim', $user->no_induk)
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

        return view('mahasiswa.proposal.hasil.detail', compact('data', 'user', 'dosen1', 'dosen2'));
    }



    //Skripsi
    //Monitoring
    public function viewSkripsi(){
        $user = Auth::user();

        $data = DB::table('status_skripsi')
            ->join('mahasiswa', 'status_skripsi.nim', '=', 'mahasiswa.nim')
            ->join('proposal', 'status_skripsi.id_proposal', '=', 'proposal.id')
            ->join('plot_dosbing', 'proposal.id_plot_dosbing', '=', 'plot_dosbing.id')
            ->join('semester', 'proposal.id_semester', '=', 'semester.id')
            ->select('status_skripsi.id as id', 'status_skripsi.nim as nim', 'mahasiswa.name as nama', 'proposal.judul as judul', 
            'semester.semester as semester', 'semester.tahun as tahun', 'status_skripsi.status_skripsi as status_skripsi', 'status_skripsi.status_ujian as status_ujian',
            'plot_dosbing.dosbing1 as dosbing1', 'plot_dosbing.dosbing2 as dosbing2')
            ->where('status_skripsi.nim', $user->no_induk)
            ->get();
        // dd($dosbing);
        return view('mahasiswa.skripsi.monitoring.read', compact('data', 'user'));
    }

    // View Bimbingan
    public function viewBimbingan(){
        $user = Auth::user();
        $plot = DB::table('plot_dosbing')->where('nim', $user -> no_induk)->orderByRaw('id DESC')->first();

        $data1 = DB::table('bimbingan')
        ->join('mahasiswa', 'bimbingan.nim', '=', 'mahasiswa.nim')
        ->join('dosen as dos1', 'bimbingan.bimbingan_kepada', '=', 'dos1.nidn')
        ->join('semester', 'bimbingan.id_semester', '=', 'semester.id')
        
        ->join('s1 as s11', 'dos1.gelar1', '=', 's11.id')
        ->leftJoin('s2 as s21', 'dos1.gelar2', '=', 's21.id')
        ->leftJoin('s3 as s31', 'dos1.gelar3', '=', 's31.id')

        ->select('bimbingan.id as id', 'semester.semester as smt', 'semester.tahun as thn', 'bimbingan.nim as nim', 'mahasiswa.name as nama', 'bimbingan.bimbingan_ke as bimbingan_ke', 'bimbingan.file as file',
        'bimbingan.komentar as komentar', 'bimbingan.ket1 as ket1', 'bimbingan.ket2 as ket2',
        'dos1.name as dosbing1', 's11.gelar as gelar11', 's21.gelar as gelar21', 's31.gelar as gelar31',
        's31.depan as depan1',)
        ->where('bimbingan.nim', $user -> no_induk)
        ->where('bimbingan.bimbingan_kepada', '=', $plot->dosbing1)
        ->orderByRaw('bimbingan.id ASC')
        ->get();

        $data2 = DB::table('bimbingan')
        ->join('mahasiswa', 'bimbingan.nim', '=', 'mahasiswa.nim')
        ->join('dosen as dos1', 'bimbingan.bimbingan_kepada', '=', 'dos1.nidn')
        ->join('semester', 'bimbingan.id_semester', '=', 'semester.id')
        
        ->join('s1 as s11', 'dos1.gelar1', '=', 's11.id')
        ->leftJoin('s2 as s21', 'dos1.gelar2', '=', 's21.id')
        ->leftJoin('s3 as s31', 'dos1.gelar3', '=', 's31.id')

        ->select('bimbingan.id as id', 'semester.semester as smt', 'semester.tahun as thn', 'bimbingan.nim as nim', 'mahasiswa.name as nama', 'bimbingan.bimbingan_ke as bimbingan_ke', 'bimbingan.file as file',
        'bimbingan.komentar as komentar', 'bimbingan.ket1 as ket1', 'bimbingan.ket2 as ket2',
        'dos1.name as dosbing1', 's11.gelar as gelar11', 's21.gelar as gelar21', 's31.gelar as gelar31',
        's31.depan as depan1',)
        ->where('bimbingan.nim', $user -> no_induk)
        ->where('bimbingan.bimbingan_kepada', '=', $plot->dosbing2)
        ->orderByRaw('bimbingan.id ASC')
        ->get();

        $cekbimbinganselesai = DB::table('bimbingan')
        ->join('mahasiswa', 'bimbingan.nim', '=', 'mahasiswa.nim')
        ->select('bimbingan.id as id', 'bimbingan.nim as nim', 'mahasiswa.name as nama', 'bimbingan.bimbingan_ke as bimbingan_ke', 'bimbingan.file as file',
        'bimbingan.komentar as komentar')
        ->where('bimbingan.nim', $user -> no_induk)
        ->where('bimbingan.ket1', 'Selesai Bimbingan')
        ->where('bimbingan.ket2', 'Selesai Bimbingan')
        ->orderByRaw('bimbingan.bimbingan_ke DESC')
        ->first();
        // dd($cekbimbinganselesai);
        return view('mahasiswa.skripsi.bimbingan.read', compact('data1', 'data2', 'user', 'cekbimbinganselesai', 'plot'));
    }
    public function formAddBimbingan(){
        $user = Auth::user();
        $data = DB::table('plot_dosbing')
        ->join('dosen as dos1', 'plot_dosbing.dosbing1', '=', 'dos1.nidn')
        ->leftJoin('dosen as dos2', 'plot_dosbing.dosbing2', '=', 'dos2.nidn')
        
        ->join('s1 as s11', 'dos1.gelar1', '=', 's11.id')
        ->leftJoin('s2 as s21', 'dos1.gelar2', '=', 's21.id')
        ->leftJoin('s3 as s31', 'dos1.gelar3', '=', 's31.id')

        ->leftJoin('s1 as s12', 'dos2.gelar1', '=', 's12.id')
        ->leftJoin('s2 as s22', 'dos2.gelar2', '=', 's22.id')
        ->leftJoin('s3 as s32', 'dos2.gelar3', '=', 's32.id')

        ->select('plot_dosbing.id as id', 'plot_dosbing.smt as smt', 'plot_dosbing.nim as nim', 'plot_dosbing.name as name', 
        'dos1.name as dosbing1', 'dos2.name as dosbing2', 's11.gelar as gelar11', 's21.gelar as gelar21', 's31.gelar as gelar31',
        's12.gelar as gelar12', 's22.gelar as gelar22', 's32.gelar as gelar32', 's32.depan as depan2', 's31.depan as depan1', 'plot_dosbing.dosbing1 as nidn1', 'plot_dosbing.dosbing2 as nidn2')
        ->where('nim', $user -> no_induk)->first();

        // dd($data);

        $smt = SemesterModel::all()->where('aktif', 'Y')->first();
        $dataprop = ProposalModel::all()->where('nim', $user -> no_induk)->where('ket1', 'Disetujui')->where('ket2', 'Disetujui')->first();
        return view ('mahasiswa.skripsi.bimbingan.add', compact('data', 'smt', 'dataprop', 'user'));
    }

    public function formAddBimbingan2(){
        $user = Auth::user();
        $data = DB::table('plot_dosbing')
        ->join('dosen as dos1', 'plot_dosbing.dosbing1', '=', 'dos1.nidn')
        ->join('dosen as dos2', 'plot_dosbing.dosbing2', '=', 'dos2.nidn')
        
        ->join('s1 as s11', 'dos1.gelar1', '=', 's11.id')
        ->leftJoin('s2 as s21', 'dos1.gelar2', '=', 's21.id')
        ->leftJoin('s3 as s31', 'dos1.gelar3', '=', 's31.id')

        ->join('s1 as s12', 'dos2.gelar1', '=', 's12.id')
        ->leftJoin('s2 as s22', 'dos2.gelar2', '=', 's22.id')
        ->leftJoin('s3 as s32', 'dos2.gelar3', '=', 's32.id')

        ->select('plot_dosbing.id as id', 'plot_dosbing.smt as smt', 'plot_dosbing.nim as nim', 'plot_dosbing.name as name', 
        'dos1.name as dosbing1', 'dos2.name as dosbing2', 's11.gelar as gelar11', 's21.gelar as gelar21', 's31.gelar as gelar31',
        's12.gelar as gelar12', 's22.gelar as gelar22', 's32.gelar as gelar32', 's32.depan as depan2', 's31.depan as depan1', 'plot_dosbing.dosbing1 as nidn1', 'plot_dosbing.dosbing2 as nidn2')
        ->where('nim', $user -> no_induk)->first();

        $smt = SemesterModel::all()->where('aktif', 'Y')->first();
        $dataprop = ProposalModel::all()->where('nim', $user -> no_induk)->where('ket1', 'Disetujui')->where('ket2', 'Disetujui')->first();
        return view ('mahasiswa.skripsi.bimbingan.add2', compact('data', 'smt', 'dataprop', 'user'));
    }


    public function insertBimbingan(Request $request){
        $this->validate($request, [
			'file_bimbingan' => 'max:30720',
		],
        [
            'file_bimbingan.max' => 'File terlalu besar, maksimal 30 mb',
        ]);
        $bModel = new BimbinganModel;

        $bModel->id_semester = $request->smt;
        $bModel->nim = $request->nim;
        $bModel->id_proposal = $request->id_proposal;
        $bModel->id_plot_dosbing = $request->id_plot_dosbing;
        $bModel->bimbingan_ke = $request->bimbingan_ke;
        $bModel->bimbingan_kepada = $request->bimbingan_kepada;
        $bModel->komentar = $request->komentar;

		$file = $request->file('file_bimbingan');

        $tujuan_upload = 'filemhs/'.$request->nim.'/bimbingan';

        $namafile = rand().$file->getClientOriginalName();

        $file->move($tujuan_upload,$namafile);

        $bModel->file = $namafile;

        $bModel->ket1 = 'Review';

        $bModel->created_at = Carbon::now('GMT+7');
        $bModel->save();
        
        return redirect('mahasiswa/skripsi/bimbingan')->with(['success' => 'Berhasil']);
    }

    public function insertBimbingan2(Request $request){
        $this->validate($request, [
			'file_bimbingan' => 'max:30720',
		],
        [
            'file_bimbingan.max' => 'File terlalu besar, maksimal 30 mb',
        ]);
        $bModel = new BimbinganModel;

        $bModel->id_semester = $request->smt;
        $bModel->nim = $request->nim;
        $bModel->id_proposal = $request->id_proposal;
        $bModel->id_plot_dosbing = $request->id_plot_dosbing;
        $bModel->bimbingan_ke = $request->bimbingan_ke;
        $bModel->bimbingan_kepada = $request->bimbingan_kepada;
        $bModel->komentar = $request->komentar;

		$file = $request->file('file_bimbingan');

        $tujuan_upload = 'filemhs/'.$request->nim.'/bimbingan';

        $namafile = rand().$file->getClientOriginalName();

        $file->move($tujuan_upload,$namafile);

        $bModel->file = $namafile;

        $bModel->ket2 = 'Review';

        $bModel->created_at = Carbon::now('GMT+7');
        $bModel->save();
        
        return redirect('mahasiswa/skripsi/bimbingan')->with(['success' => 'Berhasil']);
    }

    public function viewBimbinganDetail($id){
        $user = Auth::user();
        $data = DB::table('bimbingan')
        ->join('mahasiswa', 'bimbingan.nim', '=', 'mahasiswa.nim')
        ->join('proposal', 'bimbingan.id_proposal', '=', 'proposal.id')
        ->join('plot_dosbing', 'bimbingan.id_plot_dosbing', '=', 'plot_dosbing.id')
        ->select('bimbingan.id as id', 'bimbingan.nim as nim', 'mahasiswa.name as nama', 'proposal.judul as judul', 
        'plot_dosbing.dosbing1 as dosbing1', 'plot_dosbing.dosbing2 as dosbing2', 'bimbingan.bimbingan_ke as bimbingan_ke',
        'bimbingan.file as file', 'bimbingan.komentar as komentar', 'bimbingan.ket1 as ket1', 'bimbingan.ket2 as ket2', 'bimbingan.created_at as tgl', 'bimbingan.bimbingan_kepada as bimbingan_kepada')
        ->where('bimbingan.nim', $user -> no_induk)
        ->where('bimbingan.id', $id)
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
        
        $id_bim = $data->id;

        $pesan = DB::table('pesan_bimbingan')
        ->join('users', 'pesan_bimbingan.id_user', '=', 'users.id')
        ->select('pesan_bimbingan.id as id', 'pesan_bimbingan.pesan as pesan', 'pesan_bimbingan.id_user as id_user', 'users.name as name', 'pesan_bimbingan.created_at as waktu',
        'pesan_bimbingan.file_pendukung as file_pendukung')
        ->where('id_bimbingan', $id_bim)
        ->orderByRaw('pesan_bimbingan.id ASC')
        ->get();
        return view('mahasiswa.skripsi.bimbingan.detail', compact('data', 'user', 'pesan', 'dosen1', 'dosen2'));
    }

    public function insertPesan(Request $request){
        $pbModel = new PesanBimbinganModel;

        $pbModel->id_bimbingan = $request->id_bimbingan;
        $pbModel->id_user = $request->id_user;
        $pbModel->pesan = $request->pesan;

		// $file = $request->file('file_bimbingan');

        // $tujuan_upload = 'bimbingan/'.$request->nim;

        // $file->move($tujuan_upload,$namafile);

        // $bModel->file = $namafile;

        $pbModel->created_at = Carbon::now('GMT+7');
        $pbModel->save();
        
        return redirect()->back()->with(['success' => 'Berhasil']);
    }
    public function downloadSkripsi($nim, $id)
    {
        $filepath = public_path('filemhs/'.$nim.'/bimbingan'.'/'.$id);
        return Response::download($filepath); 
    }

    public function downloadFormatPlottingDosbing()
    {
        $filepath = public_path('file_excel/Format Plotting Dosen Pembimbing.xlsx');
        return Response::download($filepath);
    }

    public function downloadFormatPlottingPenguji()
    {
        $filepath = public_path('file_excel/Format Plotting Dosen Penguji.xlsx');
        return Response::download($filepath);
    }

    public function downloadRevisiProposal($nim, $id)
    {
        $filepath = public_path('filemhs/'.$nim.'/proposal/revisi dari dosen'.'/'.$id);
        return Response::download($filepath); 
    }

    public function downloadRevisiBimbingan($nim, $id)
    {
        $filepath = public_path('filemhs/'.$nim.'/bimbingan/revisi dari dosen'.'/'.$id);
        return Response::download($filepath); 
    }

    public function downloadRevisiUjian($nim, $id)
    {
        $filepath = public_path('filemhs/'.$nim.'/ujian/revisi dari dosen'.'/'.$id);
        return Response::download($filepath); 
    }


    ///Daftar Ujian
    public function viewDaftarUjian(){
        $user = Auth::user();
        $data = DB::table('berkas_ujian')
        ->join('mahasiswa', 'berkas_ujian.nim', '=', 'mahasiswa.nim')
        ->join('proposal', 'berkas_ujian.id_proposal', '=', 'proposal.id')
        ->join('semester', 'berkas_ujian.id_semester', '=', 'semester.id')
        ->select('berkas_ujian.id as id', 'semester.semester as smt', 'semester.tahun as thn', 'berkas_ujian.nim as nim', 'mahasiswa.name as nama', 'mahasiswa.hp as hp', 'proposal.judul as judul', 'mahasiswa.status_ujian as status_ujian',
        'berkas_ujian.*', 'berkas_ujian.status as status', 'berkas_ujian.komentar_admin as komentar')
        ->where('berkas_ujian.nim', $user->no_induk)
        ->where('proposal.ket1', 'Disetujui')->where('proposal.ket2', 'Disetujui')
        ->orderByRaw('berkas_ujian.id DESC')
        ->get();

        // dd($data);
        
        $databim = DB::table('bimbingan')
        ->where('nim', $user -> no_induk)
        ->orderByRaw('bimbingan.bimbingan_ke DESC')
        ->first();

        // $datapenguji = PlotPengujiModel::all()->where('nim', $user -> no_induk)->first();
        
        return view('mahasiswa.skripsi.pendaftaran.read', compact('data', 'databim', 'user', ));
    }
    public function formAddUjian(){
        $user = Auth::user();
        $datamhs = MahasiswaModel::all()->where('nim', $user -> no_induk)->first();
        $datadosbing = PlotDosbingModel::all()->where('nim', $user -> no_induk)->first();
        // $datapenguji = PlotPengujiModel::all()->where('nim', $user -> no_induk)->first();
        $dosen1 = DB::table('dosen')
        ->join('s1', 'dosen.gelar1', '=', 's1.id')
        ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
        ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
        ->select('dosen.id as id', 'dosen.nidn as nidn', 'dosen.name as name', 's1.gelar as gelar1', 's2.gelar as gelar2', 's3.gelar as gelar3', 's3.depan as depan',
        'dosen.jabatan_fungsional as jabatan', 'dosen.email as email')
        ->where('nidn', $datadosbing->dosbing1)->first();
        $dosen2 = DB::table('dosen')
        ->join('s1', 'dosen.gelar1', '=', 's1.id')
        ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
        ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
        ->select('dosen.id as id', 'dosen.nidn as nidn', 'dosen.name as name', 's1.gelar as gelar1', 's2.gelar as gelar2', 's3.gelar as gelar3', 's3.depan as depan',
        'dosen.jabatan_fungsional as jabatan', 'dosen.email as email')
        ->where('nidn', $datadosbing->dosbing2)->first();
        $dataprop = ProposalModel::all()->where('nim', $user -> no_induk)->where('ket1', 'Disetujui')->where('ket2', 'Disetujui')->first();
        // dd($dataprop);
        return view ('mahasiswa.skripsi.pendaftaran.add', compact('dosen1', 'dosen2', 'datamhs', 'datadosbing', 'dataprop', 'user'));
    }
    public function insertBerkasUjian(Request $request){
        $this->validate($request, [
			'berkasujian' => 'max:3072',
		],
        [
            'berkasujian.max' => 'File terlalu besar, maksimal 30 mb',
        ]);

        $smt = SemesterModel::all()->where('aktif', 'Y')->first();

        $buModel = new BerkasUjianModel;

        $buModel->id_semester = $smt->id;

        $buModel->nim = $request->nim;
        $buModel->id_proposal = $request->id_proposal;
        // $buModel->id_plot_penguji = $request->id_plot_penguji;

        $berkasujian = $request->file('berkasujian');

        $tujuan_upload = 'filemhs/'.$request->nim.'/berkas_ujian';

        $berkas = rand().$berkasujian->getClientOriginalName();

        $berkasujian->move($tujuan_upload,$berkas);

        $buModel->berkas_ujian = $berkas;

        

		// $file = $request->file('berkas_ujian');

        // $tujuan_upload = 'filemhs/'.$request->nim.'/berkas_ujian';

        // $namafile = rand().$file->getClientOriginalName();

        // $file->move($tujuan_upload,$namafile);

        // $buModel->berkas_ujian = $namafile;

        $buModel->created_at = Carbon::now('GMT+7');

        $buModel->save();

        $zip = new ZipArchive;
        $res = $zip->open('filemhs/'.$request->nim.'/berkas_ujian/'.$berkas);
        $zip->extractTo('filemhs/'.$request->nim.'/berkas_ujian/extract');
        $zip->close();

        return redirect('mahasiswa/skripsi/daftarujian')->with(['success' => 'Berhasil']);
    }
    public function downloadBerkasUjian($nim, $id)
    {
        $filepath = public_path('filemhs/'.$nim.'/berkas_ujian'.'/'.$id);
        return Response::download($filepath); 
    }

    //editberkasujian
    public function editBerkasUjian(Request $request, $id){

        $delberkaslama = DB::table('berkas_ujian')
                    ->where('berkas_ujian.id', $id)
                    ->first();

        // unlink('filemhs/'.$request->nim.'/berkas_ujian'.'/'.$delberkaslama->berkas_ujian);

        $berkasujian = $request->file('berkasujian');

        $tujuan_upload = 'filemhs/'.$request->nim.'/berkas_ujian';

        $berkas = rand().$berkasujian->getClientOriginalName();

        $berkasujian->move($tujuan_upload,$berkas);

        $data = DB::table('berkas_ujian')
            ->where('id', $id)
            ->update(
            ['berkas_ujian' => $berkas,
            'status' => 'Menunggu Verifikasi']);

        $zip = new ZipArchive;
        $res = $zip->open('filemhs/'.$request->nim.'/berkas_ujian/'.$berkas);
        $zip->extractTo('filemhs/'.$request->nim.'/berkas_ujian/extract');
        $zip->close();
        
        return redirect('mahasiswa/skripsi/daftarujian')->with(['success' => 'Berhasil']);
    }


    //Jadwal Sempro
    public function viewJadwalUjian($id){
        $user = Auth::user();
        $data = DB::table('jadwal_ujian')
        ->join('mahasiswa', 'jadwal_ujian.nim', '=', 'mahasiswa.nim')
        ->join('berkas_ujian', 'jadwal_ujian.id_berkas_ujian', '=', 'berkas_ujian.id')
        ->join('proposal', 'berkas_ujian.id_proposal', '=', 'proposal.id')
        ->join('plot_dosbing', 'proposal.id_plot_dosbing', '=', 'plot_dosbing.id')
        ->join('semester', 'jadwal_ujian.id_semester', '=', 'semester.id')
        // ->join('plot_penguji', 'berkas_ujian.id_plot_penguji', '=', 'plot_penguji.id')
        ->select('jadwal_ujian.id as id', 'semester.semester as smt', 'semester.tahun as thn', 'jadwal_ujian.nim as nim', 'mahasiswa.name as nama', 'berkas_ujian.id as id_berkas_ujian', 'berkas_ujian.status as status', 'proposal.judul as judul', 
        'plot_dosbing.dosbing1 as dosbing1', 'plot_dosbing.dosbing2 as dosbing2' ,'jadwal_ujian.tanggal as tanggal',
        'jadwal_ujian.jam as jam', 'jadwal_ujian.tempat as tempat', 'jadwal_ujian.ket as ket')
        ->where('jadwal_ujian.nim', $user->no_induk)
        // ->orderByRaw('jadwal_ujian.id DESC')
        // ->where('jadwal_ujian.nim', $user->no_induk)
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
        // dd($data);
        return view('mahasiswa.skripsi.penjadwalan.read', compact('data', 'user', 'dosen1', 'dosen2'));
    }

    public function viewHasilUjian(){
        $user = Auth::user();
        $data = DB::table('hasil_ujian')
        ->join('mahasiswa', 'hasil_ujian.nim', '=', 'mahasiswa.nim')
        ->join('proposal', 'hasil_ujian.id_proposal', '=', 'proposal.id')
        ->join('jadwal_ujian', 'hasil_ujian.id_jadwal_ujian', '=', 'jadwal_ujian.id')
        ->join('plot_dosbing', 'proposal.id_plot_dosbing', '=', 'plot_dosbing.id')
        ->join('semester', 'hasil_ujian.id_semester', '=', 'semester.id')
        ->select('hasil_ujian.id as id', 'semester.semester as smt', 'semester.tahun as thn', 'hasil_ujian.nim as nim', 'mahasiswa.name as nama', 'proposal.judul as judul',
        'jadwal_ujian.tanggal as tanggal', 'jadwal_ujian.jam as jam', 'jadwal_ujian.tempat as tempat', 'jadwal_ujian.ket as ket',
        'jadwal_ujian.status1 as status1', 'jadwal_ujian.status2 as status2', 'jadwal_ujian.status3 as status3', 'hasil_ujian.berita_acara as berita_acara', 'hasil_ujian.*')
        ->where('hasil_ujian.nim', $user->no_induk)
        ->orderByRaw('hasil_ujian.id DESC')
        ->get();
        return view('mahasiswa.skripsi.hasil.read', compact('data', 'user'));
    }

    public function viewDetailHasilUjian($id){
        $user = Auth::user();
        $data = DB::table('hasil_ujian')
        ->join('mahasiswa', 'hasil_ujian.nim', '=', 'mahasiswa.nim')
        ->join('proposal', 'hasil_ujian.id_proposal', '=', 'proposal.id')
        ->join('plot_dosbing', 'proposal.id_plot_dosbing', '=', 'plot_dosbing.id')
        ->join('jadwal_ujian', 'hasil_ujian.id_jadwal_ujian', '=', 'jadwal_ujian.id')
        ->join('berkas_ujian', 'jadwal_ujian.id_berkas_ujian', '=', 'berkas_ujian.id')
        // ->join('plot_penguji', 'berkas_ujian.id_plot_penguji', '=', 'plot_penguji.id')
        ->select('hasil_ujian.id as id', 'hasil_ujian.nim as nim', 'mahasiswa.name as nama', 'proposal.judul as judul', 'hasil_ujian.berita_acara as berita_acara', 'jadwal_ujian.tanggal as tanggal', 'jadwal_ujian.jam as jam', 'jadwal_ujian.tempat as tempat',
        'jadwal_ujian.ketua_penguji as ketua', 'jadwal_ujian.anggota_penguji_1 as anggota_1', 'jadwal_ujian.anggota_penguji_2 as anggota_2',
        'hasil_ujian.sikap1 as sikap1', 'hasil_ujian.presentasi1 as presentasi1', 'hasil_ujian.teori1 as teori1', 'hasil_ujian.program1 as program1', 'hasil_ujian.jumlah1 as jumlah1', 'hasil_ujian.keterangan1 as keterangan1', 'hasil_ujian.revisi1 as revisi1',
        'hasil_ujian.sikap2 as sikap2', 'hasil_ujian.presentasi2 as presentasi2', 'hasil_ujian.teori2 as teori2', 'hasil_ujian.program2 as program2', 'hasil_ujian.jumlah2 as jumlah2', 'hasil_ujian.keterangan2 as keterangan2', 'hasil_ujian.revisi2 as revisi2',
        'hasil_ujian.sikap3 as sikap3', 'hasil_ujian.presentasi3 as presentasi3', 'hasil_ujian.teori3 as teori3', 'hasil_ujian.program3 as program3', 'hasil_ujian.jumlah3 as jumlah3', 'hasil_ujian.keterangan3 as keterangan3', 'hasil_ujian.revisi3 as revisi3',
        'plot_dosbing.dosbing1 as dosbing1', 'plot_dosbing.dosbing2 as dosbing2', 'hasil_ujian.*', 
        'jadwal_ujian.status1 as status1', 'jadwal_ujian.status2 as status2',  'jadwal_ujian.status3 as status3', 'jadwal_ujian.ket as ket')
        ->where('hasil_ujian.nim', $user->no_induk)
        ->where('hasil_ujian.id', $id)
        ->get();

        // dd($id);

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
        ->where('nidn', $data[0]->ketua)->first();
        $anggota1 = DB::table('dosen')
        ->join('s1', 'dosen.gelar1', '=', 's1.id')
        ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
        ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
        ->select('dosen.id as id', 'dosen.nidn as nidn', 'dosen.name as name', 's1.gelar as gelar1', 's2.gelar as gelar2', 's3.gelar as gelar3', 's3.depan as depan',
        'dosen.jabatan_fungsional as jabatan', 'dosen.email as email')
        ->where('nidn', $data[0]->anggota_1)->first();
        $anggota2 = DB::table('dosen')
        ->join('s1', 'dosen.gelar1', '=', 's1.id')
        ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
        ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
        ->select('dosen.id as id', 'dosen.nidn as nidn', 'dosen.name as name', 's1.gelar as gelar1', 's2.gelar as gelar2', 's3.gelar as gelar3', 's3.depan as depan',
        'dosen.jabatan_fungsional as jabatan', 'dosen.email as email')
        ->where('nidn', $data[0]->anggota_2)->first();

        // dd($data);

        return view('mahasiswa.skripsi.hasil.detail', compact('data', 'user', 'dosen1', 'dosen2', 'ketua', 'anggota1', 'anggota2'));
    }

    public function cetakDokumenSemproMhs($id){
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
        ->where('hasil_sempro.nim', $user->no_induk)
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

    public function cetakDokumenUjianMhs($id){
        $user = Auth::user();
        $data = DB::table('hasil_ujian')
        ->join('mahasiswa', 'hasil_ujian.nim', '=', 'mahasiswa.nim')
        ->join('proposal', 'hasil_ujian.id_proposal', '=', 'proposal.id')
        ->join('plot_dosbing', 'proposal.id_plot_dosbing', '=', 'plot_dosbing.id')
        ->join('jadwal_ujian', 'hasil_ujian.id_jadwal_ujian', '=', 'jadwal_ujian.id')
        ->join('berkas_ujian', 'jadwal_ujian.id_berkas_ujian', '=', 'berkas_ujian.id')
        // ->join('plot_penguji', 'berkas_ujian.id_plot_penguji', '=', 'plot_penguji.id')
        ->select('hasil_ujian.id as id', 'hasil_ujian.nim as nim', 'mahasiswa.name as nama', 'proposal.judul as judul', 'hasil_ujian.berita_acara as berita_acara', 'jadwal_ujian.tanggal as tanggal', 'jadwal_ujian.jam as jam', 'jadwal_ujian.tempat as tempat',
        'jadwal_ujian.ketua_penguji as ketua', 'jadwal_ujian.anggota_penguji_1 as anggota_1', 'jadwal_ujian.anggota_penguji_2 as anggota_2',
        'hasil_ujian.sikap1 as sikap1', 'hasil_ujian.presentasi1 as presentasi1', 'hasil_ujian.teori1 as teori1', 'hasil_ujian.program1 as program1', 'hasil_ujian.jumlah1 as jumlah1', 'hasil_ujian.keterangan1 as keterangan1', 'hasil_ujian.revisi1 as revisi1',
        'hasil_ujian.sikap2 as sikap2', 'hasil_ujian.presentasi2 as presentasi2', 'hasil_ujian.teori2 as teori2', 'hasil_ujian.program2 as program2', 'hasil_ujian.jumlah2 as jumlah2', 'hasil_ujian.keterangan2 as keterangan2', 'hasil_ujian.revisi2 as revisi2',
        'hasil_ujian.sikap3 as sikap3', 'hasil_ujian.presentasi3 as presentasi3', 'hasil_ujian.teori3 as teori3', 'hasil_ujian.program3 as program3', 'hasil_ujian.jumlah3 as jumlah3', 'hasil_ujian.keterangan3 as keterangan3', 'hasil_ujian.revisi3 as revisi3',
        'plot_dosbing.dosbing1 as dosbing1', 'plot_dosbing.dosbing2 as dosbing2')
        ->where('hasil_ujian.nim', $user->no_induk)
        ->where('hasil_ujian.id', $id)
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

        $ketua = DB::table('dosen')
        ->join('s1', 'dosen.gelar1', '=', 's1.id')
        ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
        ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
        ->select('dosen.id as id', 'dosen.nidn as nidn', 'dosen.name as name', 'dosen.ttd as ttd', 's1.gelar as gelar1', 's2.gelar as gelar2', 's3.gelar as gelar3', 's3.depan as depan',
        'dosen.jabatan_fungsional as jabatan', 'dosen.email as email')
        ->where('nidn', $data->ketua)->first();
        $anggota1 = DB::table('dosen')
        ->join('s1', 'dosen.gelar1', '=', 's1.id')
        ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
        ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
        ->select('dosen.id as id', 'dosen.nidn as nidn', 'dosen.name as name', 'dosen.ttd as ttd', 's1.gelar as gelar1', 's2.gelar as gelar2', 's3.gelar as gelar3', 's3.depan as depan',
        'dosen.jabatan_fungsional as jabatan', 'dosen.email as email')
        ->where('nidn', $data->anggota_1)->first();
        $anggota2 = DB::table('dosen')
        ->join('s1', 'dosen.gelar1', '=', 's1.id')
        ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
        ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
        ->select('dosen.id as id', 'dosen.nidn as nidn', 'dosen.name as name', 'dosen.ttd as ttd', 's1.gelar as gelar1', 's2.gelar as gelar2', 's3.gelar as gelar3', 's3.depan as depan',
        'dosen.jabatan_fungsional as jabatan', 'dosen.email as email')
        ->where('nidn', $data->anggota_2)->first();

        // dd($anggota1);

        return view ('dosen.ujian.dokumen.dokumen_ujian_pdf', compact('data', 'user', 'dosen1', 'dosen2', 'ketua', 'anggota1', 'anggota2', ));
        
    }

    public function tampilBimbinganMhs(){
        $user = Auth::user();
        $plot = DB::table('plot_dosbing')->where('nim', $user -> no_induk)->orderByRaw('id DESC')->first();
        // dd($plot);

        $data1 =  DB::table('bimbingan')
        ->join('users', 'bimbingan.bimbingan_kepada', '=', 'users.no_induk')
        ->join('dosen', 'bimbingan.bimbingan_kepada', '=', 'dosen.nidn')
        // ->join('pesan_bimbingan', 'bimbingan.bimbingan_kepada', '=', 'users.no_induk')
        ->select('bimbingan.*', 'users.name as name', 'dosen.ttd as ttd', 'dosen.nidn as nidn')
        ->where('bimbingan.nim', '=', $user->no_induk)
        ->where('bimbingan.bimbingan_kepada', '=', $plot->dosbing1)
        ->orderByRaw('bimbingan.id ASC')
        ->get();

        $data2 =  DB::table('bimbingan')
        ->join('users', 'bimbingan.bimbingan_kepada', '=', 'users.no_induk')
        ->join('dosen', 'bimbingan.bimbingan_kepada', '=', 'dosen.nidn')
        // ->join('pesan_bimbingan', 'bimbingan.bimbingan_kepada', '=', 'users.no_induk')
        ->select('bimbingan.*', 'users.name as name', 'dosen.ttd as ttd', 'dosen.nidn as nidn')
        ->where('bimbingan.nim', '=', $user->no_induk)
        ->where('bimbingan.bimbingan_kepada', '=', $plot->dosbing2)
        ->orderByRaw('bimbingan.id ASC')
        ->get();

        // dd($data);


        return view ('mahasiswa.skripsi.bimbingan.cetakbim',  compact('user', 'data1', 'data2'));
        
    }

    public function cetakBimbinganMhs(){
        $user = Auth::user();
        $plot = DB::table('plot_dosbing')->where('nim', $user -> no_induk)->orderByRaw('id DESC')->first();
        $prop = DB::table('proposal')->where('nim', $user -> no_induk)->orderByRaw('id DESC')->first();

        $dosen1 = DB::table('dosen')
        ->join('s1', 'dosen.gelar1', '=', 's1.id')
        ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
        ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
        ->select('dosen.id as id', 'dosen.nidn as nidn', 'dosen.ttd as ttd', 'dosen.name as name', 's1.gelar as gelar1', 's2.gelar as gelar2', 's3.gelar as gelar3', 's3.depan as depan',
        'dosen.jabatan_fungsional as jabatan', 'dosen.email as email')
        ->where('nidn', $plot->dosbing1)->first();
        $dosen2 = DB::table('dosen')
        ->join('s1', 'dosen.gelar1', '=', 's1.id')
        ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
        ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
        ->select('dosen.id as id', 'dosen.nidn as nidn', 'dosen.ttd as ttd', 'dosen.name as name', 's1.gelar as gelar1', 's2.gelar as gelar2', 's3.gelar as gelar3', 's3.depan as depan',
        'dosen.jabatan_fungsional as jabatan', 'dosen.email as email')
        ->where('nidn', $plot->dosbing2)->first();


        // dd($plot);
        $data1 =  DB::table('bimbingan')
        ->join('users', 'bimbingan.bimbingan_kepada', '=', 'users.no_induk')
        ->join('dosen', 'bimbingan.bimbingan_kepada', '=', 'dosen.nidn')
        // ->join('pesan_bimbingan', 'bimbingan.bimbingan_kepada', '=', 'users.no_induk')
        ->select('bimbingan.*', 'users.name as name', 'dosen.ttd as ttd', 'dosen.nidn as nidn')
        ->where('bimbingan.nim', '=', $user->no_induk)
        ->where('bimbingan.bimbingan_kepada', '=', $plot->dosbing1)
        ->orderByRaw('bimbingan.id ASC')
        ->get();

        $data2 =  DB::table('bimbingan')
        ->join('users', 'bimbingan.bimbingan_kepada', '=', 'users.no_induk')
        ->join('dosen', 'bimbingan.bimbingan_kepada', '=', 'dosen.nidn')
        // ->join('pesan_bimbingan', 'bimbingan.bimbingan_kepada', '=', 'users.no_induk')
        ->select('bimbingan.*', 'users.name as name', 'dosen.ttd as ttd', 'dosen.nidn as nidn')
        ->where('bimbingan.nim', '=', $user->no_induk)
        ->where('bimbingan.bimbingan_kepada', '=', $plot->dosbing2)
        ->orderByRaw('bimbingan.id ASC')
        ->get();

        // dd($data);


        return view ('mahasiswa.skripsi.bimbingan.bimbingan_pdf',  compact('user', 'data1', 'data2', 'prop', 'dosen1', 'dosen2'));
        
    }
}
