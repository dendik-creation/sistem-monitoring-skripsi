<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Response;

use App\DosenModel;
use App\MahasiswaModel;
use App\PlotDosbingModel;
use App\PlotPengujiModel;
use App\Imports\PlotDosbingImport;
use App\Imports\PlotPengujiImport;
use App\Imports\UserImport;
use App\Imports\MahasiswaImport;
use Maatwebsite\Excel\Facades\Excel;
use App\ProposalModel;
use App\SemesterModel;
use App\BerkasSemproModel;
use App\JadwalSemproModel;
use App\HasilSemproModel;
use App\JadwalUjianModel;
use App\HasilUjianModel;
use App\S1Model;
use App\S2Model;
use App\S3Model;
use App\BidangModel;

class AdminController extends Controller
{
    //Dashboard
    public function index()
    {
        $user = Auth::user();
        $dosen = DosenModel::count();
        $mhs = MahasiswaModel::count();
        $jadwalsempro = DB::table('berkas_sempro')
        ->join('mahasiswa', 'berkas_sempro.nim', '=', 'mahasiswa.nim')
        ->select('berkas_sempro.id as id', 'berkas_sempro.nim as nim', 'mahasiswa.name as nama', 'berkas_sempro.berkas_sempro as berkas_sempro')
        ->where('berkas_sempro.status', 'Menunggu Dijadwalkan')
        ->count();
        $jadwalujian = DB::table('berkas_ujian')
        ->join('mahasiswa', 'berkas_ujian.nim', '=', 'mahasiswa.nim')
        ->select('berkas_ujian.id as id', 'berkas_ujian.nim as nim', 'mahasiswa.name as nama', 'berkas_ujian.berkas_ujian as berkas_ujian',
        'berkas_ujian.created_at as tgl_daftar')
        ->where('berkas_ujian.status', 'Menunggu Dijadwalkan')
        ->count();
        return view('admin.index', compact('user', 'dosen', 'mhs', 'jadwalsempro', 'jadwalujian'));
    }


    //Semester
    public function viewSemester(){
        $user = Auth::user();
        $data = DB::table('semester')
                ->where('aktif', 'Y')->get();
        return view('admin.semester.read', compact('data', 'user'));
    }
    public function formEditSemester($id){
        $user = Auth::user();
        $data = DB::table('semester')
                ->where('id', $id)->first();
        return view ('admin.semester.edit',  compact('data', 'user'));
    }
    public function updateSemester(Request $request, $id){
        $semester = $request->semester;
        $tahun = $request->tahun;
        
        $data = DB::table('semester')
        ->where('id', $id)
        ->update(
        ['aktif' => 'N']
        );

        $sModel = new SemesterModel;

        $sModel->semester = $request->semester;
        $sModel->tahun = $request->tahun;
        $sModel->aktif = 'Y';

        $sModel->save();

        return redirect('admin/semester')->with(['success' => 'Berhasil']);
    }
    //End Semester


    //Dosen
    public function viewDosen(){
        $user = Auth::user();
        $data = DB::table('dosen')
        ->join('s1', 'dosen.gelar1', '=', 's1.id')
        ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
        ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
        ->join('bidang', 'dosen.id_bidang', '=', 'bidang.id')
        ->select('dosen.id as id', 'dosen.nidn as nidn', 'dosen.name as name', 's1.gelar as gelar1', 's2.gelar as gelar2', 's3.gelar as gelar3',
        'dosen.jabatan_fungsional as jabatan', 'bidang.nama_bidang as bidang', 'dosen.email as email')
        ->get();
        // dd($data);
        return view('admin.dosen.read', compact('data', 'user'));
    }
    public function formAddDosen(){
        $user = Auth::user();
        $gelar1 = DB::table('s1')->get();
        $gelar2 = DB::table('s2')->get();
        $gelar3 = DB::table('s3')->get();
        $bidang = DB::table('bidang')->get();
        return view ('admin.dosen.add', compact('user', 'gelar1', 'gelar2', 'gelar3', 'bidang'));
    }
    public function insertDosen(Request $request){
        $dModel = new DosenModel;

        $dModel->nidn = $request->nidn;
        $dModel->name = $request->name;
        $dModel->email = $request->email;
        $dModel->gelar1 = $request->gelar1;
        $dModel->gelar2 = $request->gelar2;
        $dModel->gelar3 = $request->gelar3;
        $dModel->jabatan_fungsional = $request->jabatan;
        $dModel->id_bidang = $request->id_bidang;
        
        $dModel->save();

        $get = DB::table('dosen')
        ->join('s1', 'dosen.gelar1', '=', 's1.id')
        ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
        ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
        ->select('dosen.id as id', 'dosen.nidn as nidn', 'dosen.name as name', 's1.gelar as gelar1', 's2.gelar as gelar2', 's3.gelar as gelar3',
        'dosen.jabatan_fungsional as jabatan', 'dosen.email as email')
        ->where('nidn', $request->nidn)->first();
        
        $fullname = $get->gelar3." ".$get->name.", ".$get->gelar1.", ".$get->gelar2;

        DB::insert('insert into users (no_induk, name, username, email, password, role) values (?, ?, ?, ?, ?, ?)', [$request->nidn, $fullname, $request->nidn, $request->email, Hash::make($request->nidn), 'dosen']);

        return redirect('admin/dosen')->with(['success' => 'Berhasil']);
    }
    public function formEditDosen($id){
        $user = Auth::user();
        $data = DB::table('dosen')
        ->join('bidang', 'dosen.id_bidang', '=', 'bidang.id')
        ->join('s1', 'dosen.gelar1', '=', 's1.id')
        ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
        ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
        ->select('dosen.id as id', 'dosen.nidn as nidn', 'dosen.name as name', 's1.gelar as gelar1', 's2.gelar as gelar2', 's3.gelar as gelar3', 's1.id as id_gelar1', 's2.id as id_gelar2', 's3.id as id_gelar3',
        'dosen.jabatan_fungsional as jabatan', 'dosen.email as email', 'bidang.nama_bidang as bidang', 'bidang.id as id_bidang')
        ->where('nidn', $id)->first();
        $gelar1 = DB::table('s1')->get();
        $gelar2 = DB::table('s2')->get();
        $gelar3 = DB::table('s3')->get();
        $bidang = DB::table('bidang')->get();
        return view ('admin.dosen.edit',  compact('data', 'user', 'gelar1', 'gelar2', 'gelar3', 'bidang'));
    }
    public function updateDosen(Request $request, $id){
        $nidn = $request->nidn;
        $name = $request->name;
        $gelar1 = $request->gelar1;
        $gelar2 = $request->gelar2;
        $gelar3 = $request->gelar3;
        $jabatan_fungsional = $request->jabatan;
        $id_bidang = $request->id_bidang;
        $email = $request->email;
        
        $data = DB::table('dosen')
        ->where('nidn', $id)
        ->update(
        ['name' => $name,
        'email' => $email,
        'gelar1' => $gelar1,
        'gelar2' => $gelar2,
        'gelar3' => $gelar3,
        'jabatan_fungsional' => $jabatan_fungsional,
        'id_bidang' => $id_bidang,]
        );

        $get = DB::table('dosen')
        ->join('s1', 'dosen.gelar1', '=', 's1.id')
        ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
        ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
        ->select('dosen.id as id', 'dosen.nidn as nidn', 'dosen.name as name', 's1.gelar as gelar1', 's2.gelar as gelar2', 's3.gelar as gelar3',
        'dosen.jabatan_fungsional as jabatan', 'dosen.email as email')
        ->where('nidn', $nidn)->first();
        
        $fullname = $get->gelar3." ".$get->name.", ".$get->gelar1.", ".$get->gelar2;

        $update = DB::table('users')
        ->where('no_induk', $nidn)
        ->update(
        ['name' => $fullname,
        'email' => $email,]
        );

        return redirect('admin/dosen')->with(['success' => 'Berhasil']);
    }
    public function deleteDosen($id){
        $user = DB::table('users')
            ->where('no_induk', $id)->delete();

        $data = DB::table('dosen')
            ->where('nidn', $id)->delete();

        return back()->with(['success' => 'Berhasil']);
    }
    //End Dosen


    //Mahasiswa
    public function viewMahasiswa(){
        $user = Auth::user();
        $data = MahasiswaModel::all();
        return view('admin.mahasiswa.read', compact('data', 'user'));
    }
    public function formAddMahasiswa(){
        $user = Auth::user();
        return view ('admin.mahasiswa.add', compact('user'));
    }
    public function insertMahasiswa(Request $request){
        $mModel = new MahasiswaModel;

        $mModel->nim = $request->nim;
        $mModel->name = $request->name;
        $mModel->email = $request->email;
        $mModel->hp = $request->hp;

        $mModel->save();

        DB::insert('insert into users (no_induk, name, username, password, role) values (?, ?, ?, ?, ?)', [$request->nim, $request->name, $request->nim, Hash::make($request->nim), 'mahasiswa']);

        return redirect('admin/mahasiswa')->with(['success' => 'Berhasil']);
    }
    public function formEditMahasiswa($id){
        $user = Auth::user();
        $data = DB::table('mahasiswa')
                ->where('nim', $id)->first();
        return view ('admin.mahasiswa.edit',  compact('data', 'user'));
    }
    public function updateMahasiswa(Request $request, $id){
        $nim = $request->nim;
        $name = $request->name;
        $email = $request->email;
        $hp = $request->hp;
        
        $data = DB::table('mahasiswa')
        ->where('nim', $id)
        ->update(
        ['name' => $name,
        'email' => $email,
        'hp' => $hp]
        );

        return redirect('admin/mahasiswa')->with(['success' => 'Berhasil']);
    }
    public function deleteMahasiswa($id){
        $user = DB::table('users')
            ->where('no_induk', $id)->delete();
        
        $data = DB::table('mahasiswa')
            ->where('nim', $id)->delete();

        return back()->with(['success' => 'Berhasil']);
    }
    //End Mahasiswa


    //Proposal Plotting
    public function viewProposalPlotting(){
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
        's12.gelar as gelar12', 's22.gelar as gelar22', 's32.gelar as gelar32')
        ->get();
        // dd($data);

        // $data = PlotDosbingModel::all();

        // $sempro =  DB::table('jadwal_sempro')->where('nim', $data->nim)->first();

        // $data = DB::table('jadwal_sempro')
        // ->join('mahasiswa', 'jadwal_sempro.nim', '=', 'mahasiswa.nim')
        // ->join('berkas_sempro', 'jadwal_sempro.id_berkas_sempro', '=', 'berkas_sempro.id')
        // ->join('proposal', 'berkas_sempro.id_proposal', '=', 'proposal.id')
        // ->join('plot_dosbing', 'berkas_sempro.id_plot_dosbing', '=', 'plot_dosbing.id')
        // ->select('jadwal_sempro.id as id', 'jadwal_sempro.nim as nim', 'mahasiswa.name as nama', 'berkas_sempro.id as id_berkas_sempro', 'berkas_sempro.status as status', 'proposal.judul as judul', 
        // 'plot_dosbing.dosbing1 as dosbing1', 'plot_dosbing.dosbing2 as dosbing2' ,'jadwal_sempro.tanggal as tanggal',
        // 'jadwal_sempro.jam as jam', 'jadwal_sempro.tempat as tempat', 'jadwal_sempro.ket as ket')
        // ->get();
        // dd($sempro);
        return view('admin.proposal.plotting.read', compact('data', 'user'));
    }

    public function plotDosbingImportExcel(Request $request) 
	{
		// validasi
		$this->validate($request, [
			'file' => 'required|mimes:csv,xls,xlsx'
		]);
 
		// menangkap file excel
		$file = $request->file('file');
 
		// membuat nama file unik
		$nama_file = rand().$file->getClientOriginalName();
 
		// upload ke folder file_siswa di dalam folder public
		$file->move('file_excel',$nama_file);
 
		// import data
		Excel::import(new PlotDosbingImport, public_path('/file_excel/'.$nama_file));
        Excel::import(new UserImport, public_path('/file_excel/'.$nama_file));
        Excel::import(new MahasiswaImport, public_path('/file_excel/'.$nama_file));
 
		return redirect('admin/proposal/plotting')->with(['success' => 'Berhasil']);
	}

    public function formAddSatuMahasiswa(){
        $user = Auth::user();
        $smt = DB::table('semester')
                ->where('aktif', 'Y')->first();
                
        $dosen1 = DB::table('dosen')
        ->join('s1', 'dosen.gelar1', '=', 's1.id')
        ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
        ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
        ->select('dosen.id as id', 'dosen.nidn as nidn', 'dosen.name as name', 's1.gelar as gelar1', 's2.gelar as gelar2', 's3.gelar as gelar3',
        'dosen.jabatan_fungsional as jabatan', 'dosen.email as email')
        ->get();
        $dosen2 = DB::table('dosen')
        ->join('s1', 'dosen.gelar1', '=', 's1.id')
        ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
        ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
        ->select('dosen.id as id', 'dosen.nidn as nidn', 'dosen.name as name', 's1.gelar as gelar1', 's2.gelar as gelar2', 's3.gelar as gelar3',
        'dosen.jabatan_fungsional as jabatan', 'dosen.email as email')
        ->get();

        return view ('admin.proposal.plotting.add', compact('smt', 'dosen1', 'dosen2', 'user'));
    }
    public function insertSatuMahasiswa(Request $request){
        $mModel = new MahasiswaModel;

        $mModel->nim = $request->nim;
        $mModel->name = $request->name;

        $mModel->save();

        DB::insert('insert into users (no_induk, name, username, password, role) values (?, ?, ?, ?, ?)', [$request->nim, $request->name, $request->nim, Hash::make($request->nim), 'mahasiswa']);

        DB::insert('insert into plot_dosbing (smt, nim, name, dosbing1, dosbing2) values (?, ?, ?, ?, ?)', [$request->smt, $request->nim, $request->name, $request->dosbing1, $request->dosbing2]);

        return redirect('admin/proposal/plotting')->with(['success' => 'Berhasil']);
    }


    //Proposal Monitoring
    public function viewProposalMonitoring(){
        $user = Auth::user();
        $data = DB::table('proposal')
        ->join('mahasiswa', 'proposal.nim', '=', 'mahasiswa.nim')
        ->join('plot_dosbing', 'proposal.id_plot_dosbing', '=', 'plot_dosbing.id')

        ->join('dosen as dos1', 'plot_dosbing.dosbing1', '=', 'dos1.nidn')
        ->join('dosen as dos2', 'plot_dosbing.dosbing2', '=', 'dos2.nidn')
        
        ->join('s1 as s11', 'dos1.gelar1', '=', 's11.id')
        ->leftJoin('s2 as s21', 'dos1.gelar2', '=', 's21.id')
        ->leftJoin('s3 as s31', 'dos1.gelar3', '=', 's31.id')

        ->join('s1 as s12', 'dos2.gelar1', '=', 's12.id')
        ->leftJoin('s2 as s22', 'dos2.gelar2', '=', 's22.id')
        ->leftJoin('s3 as s32', 'dos2.gelar3', '=', 's32.id')

        ->join('semester', 'proposal.id_semester', '=', 'semester.id')

        ->select('proposal.id as id', 'proposal.nim as nim', 'mahasiswa.name as nama', 'proposal.judul as judul', 'proposal.ket1 as ket1' ,'proposal.ket2 as ket2',
        'proposal.proposal as proposal', 'semester.semester as semester', 'semester.tahun as tahun', 'plot_dosbing.dosbing1 as dosbing1', 'plot_dosbing.dosbing2 as dosbing2',
        'dos1.name as dosbing1', 'dos2.name as dosbing2', 's11.gelar as gelar11', 's21.gelar as gelar21', 's31.gelar as gelar31',
        's12.gelar as gelar12', 's22.gelar as gelar22', 's32.gelar as gelar32')
        ->get();
        return view('admin.proposal.monitoring.read', compact('data', 'user'));
    }


    //Proposal Data Pendaftar
    public function viewProposalPendaftar(){
        $user = Auth::user();
        $data = DB::table('berkas_sempro')
        ->join('mahasiswa', 'berkas_sempro.nim', '=', 'mahasiswa.nim')
        ->join('plot_dosbing', 'berkas_sempro.id_plot_dosbing', '=', 'plot_dosbing.id')
        ->join('proposal', 'berkas_sempro.id_proposal', '=', 'proposal.id')
        ->join('semester', 'proposal.id_semester', '=', 'semester.id')
        ->select('berkas_sempro.id as id', 'berkas_sempro.nim as nim', 'mahasiswa.name as nama', 'berkas_sempro.berkas_sempro as berkas_sempro',
        'berkas_sempro.created_at as tgl_daftar', 'semester.semester as semester', 'semester.tahun as tahun')
        ->where('berkas_sempro.status', 'Menunggu Dijadwalkan')
        ->get();
        return view('admin.proposal.pendaftar.read', compact('data', 'user'));
    }

    public function viewProposalPendaftarDetail($id){
        $user = Auth::user();
        $data = DB::table('berkas_sempro')
        ->join('mahasiswa', 'berkas_sempro.nim', '=', 'mahasiswa.nim')
        ->join('plot_dosbing', 'berkas_sempro.id_plot_dosbing', '=', 'plot_dosbing.id')
        ->join('proposal', 'berkas_sempro.id_proposal', '=', 'proposal.id')
        ->select('berkas_sempro.id as id', 'berkas_sempro.nim as nim', 'mahasiswa.name as nama', 'mahasiswa.hp as hp', 'proposal.judul as judul', 'proposal.id as id_proposal', 
        'plot_dosbing.dosbing1 as dosbing1', 'plot_dosbing.dosbing2 as dosbing2' ,'berkas_sempro.berkas_sempro as berkas_sempro', 'berkas_sempro.created_at as tgl_daftar')
        ->where('berkas_sempro.id', $id)
        ->get();
        $dosen1 = DB::table('dosen')
        ->join('s1', 'dosen.gelar1', '=', 's1.id')
        ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
        ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
        ->select('dosen.id as id', 'dosen.nidn as nidn', 'dosen.name as name', 's1.gelar as gelar1', 's2.gelar as gelar2', 's3.gelar as gelar3',
        'dosen.jabatan_fungsional as jabatan', 'dosen.email as email')
        ->where('nidn', $data[0]->dosbing1)->first();
        $dosen2 = DB::table('dosen')
        ->join('s1', 'dosen.gelar1', '=', 's1.id')
        ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
        ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
        ->select('dosen.id as id', 'dosen.nidn as nidn', 'dosen.name as name', 's1.gelar as gelar1', 's2.gelar as gelar2', 's3.gelar as gelar3',
        'dosen.jabatan_fungsional as jabatan', 'dosen.email as email')
        ->where('nidn', $data[0]->dosbing2)->first();
        return view('admin.proposal.pendaftar.detail', compact('data', 'user', 'dosen1', 'dosen2'));
    }

    public function insertJadwalSempro(Request $request){
        $jsModel = new JadwalSemproModel;

        $jsModel->nim = $request->nim;
        $jsModel->id_berkas_sempro = $request->id_berkas_sempro;
        $jsModel->tanggal = $request->tanggal;
        $jsModel->jam = $request->jam;
        $jsModel->tempat = $request->tempat;
        $jsModel->ket = $request->ket;
        $jsModel->created_at = Carbon::now();
        $jsModel->updated_at = Carbon::now();

        $jsModel->save();

        $data = DB::table('berkas_sempro')
        ->where('nim', $request->nim)
        ->orderByRaw('berkas_sempro.id DESC')
        ->update(
        ['status' => 'Terjadwal']
        );

        $hsModel = new HasilSemproModel;
        $hsModel->nim = $request->nim;
        $hsModel->id_proposal = $request->id_proposal;
        $hsModel->save();

        return redirect('admin/proposal/pendaftar')->with(['success' => 'Berhasil']);
    }


    //Proposal Data Penjadwalan
    public function viewProposalPenjadwalan(){
        $user = Auth::user();
        $data = DB::table('jadwal_sempro')
        ->join('mahasiswa', 'jadwal_sempro.nim', '=', 'mahasiswa.nim')
        ->join('berkas_sempro', 'jadwal_sempro.id_berkas_sempro', '=', 'berkas_sempro.id')
        ->join('proposal', 'berkas_sempro.id_proposal', '=', 'proposal.id')
        ->join('plot_dosbing', 'berkas_sempro.id_plot_dosbing', '=', 'plot_dosbing.id')
        ->join('semester', 'proposal.id_semester', '=', 'semester.id')

        ->join('dosen as dos1', 'plot_dosbing.dosbing1', '=', 'dos1.nidn')
        ->join('dosen as dos2', 'plot_dosbing.dosbing2', '=', 'dos2.nidn')
        
        ->join('s1 as s11', 'dos1.gelar1', '=', 's11.id')
        ->leftJoin('s2 as s21', 'dos1.gelar2', '=', 's21.id')
        ->leftJoin('s3 as s31', 'dos1.gelar3', '=', 's31.id')

        ->join('s1 as s12', 'dos2.gelar1', '=', 's12.id')
        ->leftJoin('s2 as s22', 'dos2.gelar2', '=', 's22.id')
        ->leftJoin('s3 as s32', 'dos2.gelar3', '=', 's32.id')

        ->select('jadwal_sempro.id as id', 'jadwal_sempro.nim as nim', 'mahasiswa.name as nama', 'berkas_sempro.id as id_berkas_sempro', 'proposal.judul as judul', 
        'plot_dosbing.dosbing1 as dosbing1', 'plot_dosbing.dosbing2 as dosbing2' ,'jadwal_sempro.tanggal as tanggal', 'semester.semester as semester', 'semester.tahun as tahun',
        'jadwal_sempro.jam as jam', 'jadwal_sempro.tempat as tempat', 'jadwal_sempro.ket as ket', 'jadwal_sempro.status1 as status1', 'jadwal_sempro.status2 as status2',
        'dos1.name as dosbing1', 'dos2.name as dosbing2', 's11.gelar as gelar11', 's21.gelar as gelar21', 's31.gelar as gelar31',
        's12.gelar as gelar12', 's22.gelar as gelar22', 's32.gelar as gelar32')
        ->get();

        return view('admin.proposal.penjadwalan.read', compact('data', 'user'));
    }

    public function viewDetailJadwalSempro($id){
        $user = Auth::user();
        $data = DB::table('jadwal_sempro')
        ->join('mahasiswa', 'jadwal_sempro.nim', '=', 'mahasiswa.nim')
        ->join('berkas_sempro', 'jadwal_sempro.id_berkas_sempro', '=', 'berkas_sempro.id')
        ->join('proposal', 'berkas_sempro.id_proposal', '=', 'proposal.id')
        ->join('plot_dosbing', 'berkas_sempro.id_plot_dosbing', '=', 'plot_dosbing.id')

        ->join('dosen as dos1', 'plot_dosbing.dosbing1', '=', 'dos1.nidn')
        ->join('dosen as dos2', 'plot_dosbing.dosbing2', '=', 'dos2.nidn')
        
        ->join('s1 as s11', 'dos1.gelar1', '=', 's11.id')
        ->leftJoin('s2 as s21', 'dos1.gelar2', '=', 's21.id')
        ->leftJoin('s3 as s31', 'dos1.gelar3', '=', 's31.id')

        ->join('s1 as s12', 'dos2.gelar1', '=', 's12.id')
        ->leftJoin('s2 as s22', 'dos2.gelar2', '=', 's22.id')
        ->leftJoin('s3 as s32', 'dos2.gelar3', '=', 's32.id')

        ->select('jadwal_sempro.id as id', 'jadwal_sempro.nim as nim', 'mahasiswa.name as nama', 'mahasiswa.hp as hp', 'berkas_sempro.id as id_berkas_sempro', 'proposal.judul as judul', 
        'plot_dosbing.dosbing1 as dosbing1', 'plot_dosbing.dosbing2 as dosbing2' ,'jadwal_sempro.tanggal as tanggal',
        'jadwal_sempro.jam as jam', 'jadwal_sempro.tempat as tempat', 'jadwal_sempro.ket as ket', 'jadwal_sempro.status1 as status1', 'jadwal_sempro.status2 as status2',
        'dos1.name as dosbing1', 'dos2.name as dosbing2', 's11.gelar as gelar11', 's21.gelar as gelar21', 's31.gelar as gelar31',
        's12.gelar as gelar12', 's22.gelar as gelar22', 's32.gelar as gelar32')
        ->where('jadwal_sempro.id', $id)
        ->get();

        $hasil_sempro = DB::table('hasil_sempro')
        ->select('hasil_sempro.id as id')
        ->where('hasil_sempro.nim', $data[0]->nim)
        ->first();
        return view('admin.proposal.penjadwalan.detail', compact('data', 'user', 'hasil_sempro'));
    }




    //Skripsi Monitoring
    public function viewSkripsiMonitoring(){
        $user = Auth::user();

        $data = DB::table('status_skripsi')
            ->join('mahasiswa', 'status_skripsi.nim', '=', 'mahasiswa.nim')
            ->join('proposal', 'status_skripsi.id_proposal', '=', 'proposal.id')
            ->join('plot_dosbing', 'proposal.id_plot_dosbing', '=', 'plot_dosbing.id')
            ->join('semester', 'proposal.id_semester', '=', 'semester.id')
            ->select('status_skripsi.id as id', 'status_skripsi.nim as nim', 'mahasiswa.name as nama', 'proposal.judul as judul', 
            'semester.semester as semester', 'semester.tahun as tahun', 'status_skripsi.status_skripsi as status_skripsi', 'status_skripsi.status_ujian as status_ujian',
            'plot_dosbing.dosbing1 as dosbing1', 'plot_dosbing.dosbing2 as dosbing2')
            ->get();
        // dd($dosbing);
        return view('admin.skripsi.monitoring.read', compact('data', 'user'));
    }


    //Penguji Plotting
    public function viewPengujiPlotting(){
        $user = Auth::user();
        $data = DB::table('plot_penguji')
        ->join('dosen as dos1', 'plot_penguji.ketua_penguji', '=', 'dos1.nidn')
        ->join('dosen as dos2', 'plot_penguji.anggota_penguji_1', '=', 'dos2.nidn')
        ->join('dosen as dos3', 'plot_penguji.anggota_penguji_2', '=', 'dos3.nidn')
        
        ->join('s1 as s11', 'dos1.gelar1', '=', 's11.id')
        ->leftJoin('s2 as s21', 'dos1.gelar2', '=', 's21.id')
        ->leftJoin('s3 as s31', 'dos1.gelar3', '=', 's31.id')

        ->join('s1 as s12', 'dos2.gelar1', '=', 's12.id')
        ->leftJoin('s2 as s22', 'dos2.gelar2', '=', 's22.id')
        ->leftJoin('s3 as s32', 'dos2.gelar3', '=', 's32.id')

        ->join('s1 as s13', 'dos3.gelar1', '=', 's13.id')
        ->leftJoin('s2 as s23', 'dos3.gelar2', '=', 's23.id')
        ->leftJoin('s3 as s33', 'dos3.gelar3', '=', 's33.id')

        ->select('plot_penguji.id as id', 'plot_penguji.smt as smt', 'plot_penguji.nim as nim', 'plot_penguji.name as name', 
        'dos1.name as dosen1', 'dos2.name as dosen2', 'dos3.name as dosen3', 's11.gelar as gelar11', 's21.gelar as gelar21', 's31.gelar as gelar31',
        's12.gelar as gelar12', 's22.gelar as gelar22', 's32.gelar as gelar32', 's13.gelar as gelar13', 's23.gelar as gelar23', 's33.gelar as gelar33')
        ->get();
        
        return view('admin.skripsi.plotting.read', compact('data', 'user'));
    }

    public function plotPengujiImportExcel(Request $request) 
	{
		// validasi
		$this->validate($request, [
			'file' => 'required|mimes:csv,xls,xlsx'
		]);
 
		// menangkap file excel
		$file = $request->file('file');
 
		// membuat nama file unik
		$nama_file = rand().$file->getClientOriginalName();
 
		// upload ke folder file_siswa di dalam folder public
		$file->move('file_excel',$nama_file);
 
		// import data
		Excel::import(new PlotPengujiImport, public_path('/file_excel/'.$nama_file));
 
		return redirect('admin/skripsi/plotting')->with(['success' => 'Berhasil']);
	}

    public function formPengujiAddSatuMahasiswa(){
        $user = Auth::user();
        $smt = DB::table('semester')
                ->where('aktif', 'Y')->first();
                
        $dosen1 = DB::table('dosen')
        ->join('s1', 'dosen.gelar1', '=', 's1.id')
        ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
        ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
        ->select('dosen.id as id', 'dosen.nidn as nidn', 'dosen.name as name', 's1.gelar as gelar1', 's2.gelar as gelar2', 's3.gelar as gelar3',
        'dosen.jabatan_fungsional as jabatan', 'dosen.email as email')
        ->get();
        $dosen2 = DB::table('dosen')
        ->join('s1', 'dosen.gelar1', '=', 's1.id')
        ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
        ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
        ->select('dosen.id as id', 'dosen.nidn as nidn', 'dosen.name as name', 's1.gelar as gelar1', 's2.gelar as gelar2', 's3.gelar as gelar3',
        'dosen.jabatan_fungsional as jabatan', 'dosen.email as email')
        ->get();
        $dosen3 = DB::table('dosen')
        ->join('s1', 'dosen.gelar1', '=', 's1.id')
        ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
        ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
        ->select('dosen.id as id', 'dosen.nidn as nidn', 'dosen.name as name', 's1.gelar as gelar1', 's2.gelar as gelar2', 's3.gelar as gelar3',
        'dosen.jabatan_fungsional as jabatan', 'dosen.email as email')
        ->get();

        return view ('admin.skripsi.plotting.add', compact('smt', 'dosen1', 'dosen2', 'dosen3', 'user'));
    }
    public function insertPengujiSatuMahasiswa(Request $request){
        DB::insert('insert into plot_penguji (smt, nim, name, ketua_penguji, anggota_penguji_1, anggota_penguji_2) values (?, ?, ?, ?, ?, ?)', [$request->smt, $request->nim, $request->name, $request->ketua, $request->anggota1, $request->anggota2]);

        return redirect('admin/skripsi/plotting')->with(['success' => 'Berhasil']);
    }


    //Proposal Data Pendaftar
    public function viewSkripsiPendaftar(){
        $user = Auth::user();
        $data = DB::table('berkas_ujian')
        ->join('mahasiswa', 'berkas_ujian.nim', '=', 'mahasiswa.nim')
        ->join('proposal', 'berkas_ujian.id_proposal', '=', 'proposal.id')
        ->join('semester', 'proposal.id_semester', '=', 'semester.id')
        ->select('berkas_ujian.id as id', 'berkas_ujian.nim as nim', 'mahasiswa.name as nama', 'berkas_ujian.berkas_ujian as berkas_ujian',
        'berkas_ujian.created_at as tgl_daftar', 'semester.semester as semester', 'semester.tahun as tahun')
        ->where('berkas_ujian.status', 'Menunggu Dijadwalkan')
        ->get();
        return view('admin.skripsi.pendaftar.read', compact('data', 'user'));
    }

    public function viewSkripsiPendaftarDetail($id){
        $user = Auth::user();
        $data = DB::table('berkas_ujian')
        ->join('mahasiswa', 'berkas_ujian.nim', '=', 'mahasiswa.nim')
        ->join('plot_penguji', 'berkas_ujian.id_plot_penguji', '=', 'plot_penguji.id')
        ->join('proposal', 'berkas_ujian.id_proposal', '=', 'proposal.id')
        ->join('plot_dosbing', 'proposal.id_plot_dosbing', '=', 'plot_dosbing.id')
        ->select('berkas_ujian.id as id', 'berkas_ujian.nim as nim', 'mahasiswa.name as nama', 'mahasiswa.hp as hp', 'mahasiswa.email as email', 'proposal.judul as judul', 'proposal.id as id_proposal', 
        'plot_penguji.ketua_penguji as ketua_penguji', 'plot_penguji.anggota_penguji_1 as anggota_penguji_1', 'plot_penguji.anggota_penguji_2 as anggota_penguji_2', 'berkas_ujian.berkas_ujian as berkas_ujian', 
        'berkas_ujian.created_at as tgl_daftar', 'plot_dosbing.dosbing1 as dosbing1', 'plot_dosbing.dosbing2 as dosbing2')
        ->where('berkas_ujian.id', $id)
        ->get();
        $dosen1 = DB::table('dosen')
        ->join('s1', 'dosen.gelar1', '=', 's1.id')
        ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
        ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
        ->select('dosen.id as id', 'dosen.nidn as nidn', 'dosen.name as name', 's1.gelar as gelar1', 's2.gelar as gelar2', 's3.gelar as gelar3',
        'dosen.jabatan_fungsional as jabatan', 'dosen.email as email')
        ->where('nidn', $data[0]->dosbing1)->first();
        $dosen2 = DB::table('dosen')
        ->join('s1', 'dosen.gelar1', '=', 's1.id')
        ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
        ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
        ->select('dosen.id as id', 'dosen.nidn as nidn', 'dosen.name as name', 's1.gelar as gelar1', 's2.gelar as gelar2', 's3.gelar as gelar3',
        'dosen.jabatan_fungsional as jabatan', 'dosen.email as email')
        ->where('nidn', $data[0]->dosbing2)->first();

        $ketua = DB::table('dosen')
        ->join('s1', 'dosen.gelar1', '=', 's1.id')
        ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
        ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
        ->select('dosen.id as id', 'dosen.nidn as nidn', 'dosen.name as name', 's1.gelar as gelar1', 's2.gelar as gelar2', 's3.gelar as gelar3',
        'dosen.jabatan_fungsional as jabatan', 'dosen.email as email')
        ->where('nidn', $data[0]->ketua_penguji)->first();
        $anggota1 = DB::table('dosen')
        ->join('s1', 'dosen.gelar1', '=', 's1.id')
        ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
        ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
        ->select('dosen.id as id', 'dosen.nidn as nidn', 'dosen.name as name', 's1.gelar as gelar1', 's2.gelar as gelar2', 's3.gelar as gelar3',
        'dosen.jabatan_fungsional as jabatan', 'dosen.email as email')
        ->where('nidn', $data[0]->anggota_penguji_1)->first();
        $anggota2 = DB::table('dosen')
        ->join('s1', 'dosen.gelar1', '=', 's1.id')
        ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
        ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
        ->select('dosen.id as id', 'dosen.nidn as nidn', 'dosen.name as name', 's1.gelar as gelar1', 's2.gelar as gelar2', 's3.gelar as gelar3',
        'dosen.jabatan_fungsional as jabatan', 'dosen.email as email')
        ->where('nidn', $data[0]->anggota_penguji_2)->first();
        return view('admin.skripsi.pendaftar.detail', compact('data', 'user', 'dosen1', 'dosen2', 'ketua', 'anggota1', 'anggota2'));
    }

    public function insertJadwalUjian(Request $request){
        $jsModel = new JadwalUjianModel;

        $jsModel->nim = $request->nim;
        $jsModel->id_berkas_ujian = $request->id_berkas_ujian;
        $jsModel->tanggal = $request->tanggal;
        $jsModel->jam = $request->jam;
        $jsModel->tempat = $request->tempat;
        $jsModel->ket = $request->ket;
        $jsModel->created_at = Carbon::now();
        $jsModel->updated_at = Carbon::now();

        $jsModel->save();

        $data = DB::table('berkas_ujian')
        ->where('nim', $request->nim)
        ->orderByRaw('berkas_ujian.id DESC')
        ->update(
        ['status' => 'Terjadwal']
        );

        $huModel = new HasilUjianModel;
        $huModel->nim = $request->nim;
        $huModel->id_proposal = $request->id_proposal;
        $huModel->save();

        return redirect('admin/skripsi/pendaftar')->with(['success' => 'Berhasil']);
    }


    //Ujian Skripsi Data Penjadwalan
    public function viewSkripsiPenjadwalan(){
        $user = Auth::user();
        $data = DB::table('jadwal_ujian')
        ->join('mahasiswa', 'jadwal_ujian.nim', '=', 'mahasiswa.nim')
        ->join('berkas_ujian', 'jadwal_ujian.id_berkas_ujian', '=', 'berkas_ujian.id')
        ->join('proposal', 'berkas_ujian.id_proposal', '=', 'proposal.id')
        ->join('plot_penguji', 'berkas_ujian.id_plot_penguji', '=', 'plot_penguji.id')
        ->join('plot_dosbing', 'proposal.id_plot_dosbing', '=', 'plot_dosbing.id')
        ->join('semester', 'proposal.id_semester', '=', 'semester.id')

        ->join('dosen as dos1', 'plot_dosbing.dosbing1', '=', 'dos1.nidn')
        ->join('dosen as dos2', 'plot_dosbing.dosbing2', '=', 'dos2.nidn')

        ->join('dosen as dos3', 'plot_penguji.ketua_penguji', '=', 'dos3.nidn')
        ->join('dosen as dos4', 'plot_penguji.anggota_penguji_1', '=', 'dos4.nidn')
        ->join('dosen as dos5', 'plot_penguji.anggota_penguji_2', '=', 'dos5.nidn')
        
        ->join('s1 as s11', 'dos1.gelar1', '=', 's11.id')
        ->leftJoin('s2 as s21', 'dos1.gelar2', '=', 's21.id')
        ->leftJoin('s3 as s31', 'dos1.gelar3', '=', 's31.id')

        ->join('s1 as s12', 'dos2.gelar1', '=', 's12.id')
        ->leftJoin('s2 as s22', 'dos2.gelar2', '=', 's22.id')
        ->leftJoin('s3 as s32', 'dos2.gelar3', '=', 's32.id')

        ->join('s1 as s13', 'dos3.gelar1', '=', 's13.id')
        ->leftJoin('s2 as s23', 'dos3.gelar2', '=', 's23.id')
        ->leftJoin('s3 as s33', 'dos3.gelar3', '=', 's33.id')

        ->join('s1 as s14', 'dos4.gelar1', '=', 's14.id')
        ->leftJoin('s2 as s24', 'dos4.gelar2', '=', 's24.id')
        ->leftJoin('s3 as s34', 'dos4.gelar3', '=', 's34.id')

        ->join('s1 as s15', 'dos5.gelar1', '=', 's15.id')
        ->leftJoin('s2 as s25', 'dos5.gelar2', '=', 's25.id')
        ->leftJoin('s3 as s35', 'dos5.gelar3', '=', 's35.id')

        ->select('jadwal_ujian.id as id', 'jadwal_ujian.nim as nim', 'mahasiswa.name as nama', 'berkas_ujian.id as id_berkas_ujian', 'proposal.judul as judul', 
        'plot_dosbing.dosbing1 as dosbing1', 'plot_dosbing.dosbing2 as dosbing2' ,'jadwal_ujian.tanggal as tanggal', 'semester.semester as semester', 'semester.tahun as tahun',
        'jadwal_ujian.jam as jam', 'jadwal_ujian.tempat as tempat', 'jadwal_ujian.ket as ket', 'jadwal_ujian.status1 as status1', 'jadwal_ujian.status2 as status2',
        'dos1.name as dosbing1', 'dos2.name as dosbing2', 's11.gelar as gelar11', 's21.gelar as gelar21', 's31.gelar as gelar31',
        's12.gelar as gelar12', 's22.gelar as gelar22', 's32.gelar as gelar32',
        'dos3.name as ketua', 'dos4.name as anggota1', 'dos5.name as anggota2',
        's11.gelar as gelar13', 's21.gelar as gelar23', 's31.gelar as gelar33',
        's11.gelar as gelar14', 's21.gelar as gelar24', 's31.gelar as gelar34',
        's11.gelar as gelar15', 's21.gelar as gelar25', 's31.gelar as gelar35')
        ->get();

        return view('admin.skripsi.penjadwalan.read', compact('data', 'user'));
    }

    public function viewDetailJadwalUjian($id){
        $user = Auth::user();
        $data = DB::table('jadwal_ujian')
        ->join('mahasiswa', 'jadwal_ujian.nim', '=', 'mahasiswa.nim')
        ->join('berkas_ujian', 'jadwal_ujian.id_berkas_ujian', '=', 'berkas_ujian.id')
        ->join('proposal', 'berkas_ujian.id_proposal', '=', 'proposal.id')
        ->join('plot_penguji', 'berkas_ujian.id_plot_penguji', '=', 'plot_penguji.id')
        ->join('plot_dosbing', 'proposal.id_plot_dosbing', '=', 'plot_dosbing.id')

        ->select('jadwal_ujian.id as id', 'jadwal_ujian.nim as nim', 'mahasiswa.name as nama', 'mahasiswa.hp as hp', 'mahasiswa.email as email', 'berkas_ujian.id as id_berkas_ujian', 'proposal.judul as judul',
        'plot_dosbing.dosbing1 as dosbing1', 'plot_dosbing.dosbing2 as dosbing2' ,'jadwal_ujian.tanggal as tanggal', 'berkas_ujian.created_at as tgl_daftar',
        'jadwal_ujian.jam as jam', 'jadwal_ujian.tempat as tempat', 'jadwal_ujian.ket as ket', 'jadwal_ujian.status1 as status1', 'jadwal_ujian.status2 as status2', 'jadwal_ujian.status3 as status3',
        'plot_penguji.ketua_penguji as ketua_penguji', 'plot_penguji.anggota_penguji_1 as anggota_penguji_1', 'plot_penguji.anggota_penguji_2 as anggota_penguji_2',)
        ->where('jadwal_ujian.id', $id)
        ->get();

        $dosen1 = DB::table('dosen')
        ->join('s1', 'dosen.gelar1', '=', 's1.id')
        ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
        ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
        ->select('dosen.id as id', 'dosen.nidn as nidn', 'dosen.name as name', 's1.gelar as gelar1', 's2.gelar as gelar2', 's3.gelar as gelar3',
        'dosen.jabatan_fungsional as jabatan', 'dosen.email as email')
        ->where('nidn', $data[0]->dosbing1)->first();
        $dosen2 = DB::table('dosen')
        ->join('s1', 'dosen.gelar1', '=', 's1.id')
        ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
        ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
        ->select('dosen.id as id', 'dosen.nidn as nidn', 'dosen.name as name', 's1.gelar as gelar1', 's2.gelar as gelar2', 's3.gelar as gelar3',
        'dosen.jabatan_fungsional as jabatan', 'dosen.email as email')
        ->where('nidn', $data[0]->dosbing2)->first();

        $ketua = DB::table('dosen')
        ->join('s1', 'dosen.gelar1', '=', 's1.id')
        ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
        ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
        ->select('dosen.id as id', 'dosen.nidn as nidn', 'dosen.name as name', 's1.gelar as gelar1', 's2.gelar as gelar2', 's3.gelar as gelar3',
        'dosen.jabatan_fungsional as jabatan', 'dosen.email as email')
        ->where('nidn', $data[0]->ketua_penguji)->first();
        $anggota1 = DB::table('dosen')
        ->join('s1', 'dosen.gelar1', '=', 's1.id')
        ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
        ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
        ->select('dosen.id as id', 'dosen.nidn as nidn', 'dosen.name as name', 's1.gelar as gelar1', 's2.gelar as gelar2', 's3.gelar as gelar3',
        'dosen.jabatan_fungsional as jabatan', 'dosen.email as email')
        ->where('nidn', $data[0]->anggota_penguji_1)->first();
        $anggota2 = DB::table('dosen')
        ->join('s1', 'dosen.gelar1', '=', 's1.id')
        ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
        ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
        ->select('dosen.id as id', 'dosen.nidn as nidn', 'dosen.name as name', 's1.gelar as gelar1', 's2.gelar as gelar2', 's3.gelar as gelar3',
        'dosen.jabatan_fungsional as jabatan', 'dosen.email as email')
        ->where('nidn', $data[0]->anggota_penguji_2)->first();

        $hasil_ujian = DB::table('hasil_ujian')
        ->select('hasil_ujian.id as id')
        ->where('hasil_ujian.nim', $data[0]->nim)
        ->first();
        return view('admin.skripsi.penjadwalan.detail', compact('data', 'user', 'dosen1', 'dosen2', 'ketua', 'anggota1', 'anggota2', 'hasil_ujian'));
    }


    //S1
    public function viewS1(){
        $user = Auth::user();
        $data = S1Model::all();
        return view('admin.dosen.s1.read', compact('data', 'user'));
    }
    public function formAddS1(){
        $user = Auth::user();
        
        return view ('admin.dosen.s1.add', compact('user'));
    }
    public function insertS1(Request $request){
        $s1Model = new S1Model;

        $s1Model->gelar = $request->gelar;
                
        $s1Model->save();

        return redirect('admin/dosen/s1')->with(['success' => 'Berhasil']);
    }
    public function formEditS1($id){
        $user = Auth::user();
        $data = DB::table('s1')
        ->where('s1.id', $id)->first();
        return view ('admin.dosen.s1.edit',  compact('data', 'user'));
    }
    public function updateS1(Request $request, $id){
        $gelar = $request->gelar;
        
        
        $data = DB::table('s1')
        ->where('id', $id)
        ->update(
        ['gelar' => $gelar]
        );

        return redirect('admin/dosen/s1')->with(['success' => 'Berhasil']);
    }


    //S2
    public function viewS2(){
        $user = Auth::user();
        $data = S2Model::all();
        return view('admin.dosen.s2.read', compact('data', 'user'));
    }
    public function formAddS2(){
        $user = Auth::user();
        
        return view ('admin.dosen.s2.add', compact('user'));
    }
    public function insertS2(Request $request){
        $s2Model = new S2Model;

        $s2Model->gelar = $request->gelar;
                
        $s2Model->save();

        return redirect('admin/dosen/s2')->with(['success' => 'Berhasil']);
    }
    public function formEditS2($id){
        $user = Auth::user();
        $data = DB::table('s2')
        ->where('s2.id', $id)->first();
        return view ('admin.dosen.s2.edit',  compact('data', 'user'));
    }
    public function updateS2(Request $request, $id){
        $gelar = $request->gelar;
        
        
        $data = DB::table('s2')
        ->where('id', $id)
        ->update(
        ['gelar' => $gelar]
        );

        return redirect('admin/dosen/s2')->with(['success' => 'Berhasil']);
    }


    //S3
    public function viewS3(){
        $user = Auth::user();
        $data = S3Model::all();
        return view('admin.dosen.s3.read', compact('data', 'user'));
    }
    public function formAddS3(){
        $user = Auth::user();
        
        return view ('admin.dosen.s3.add', compact('user'));
    }
    public function insertS3(Request $request){
        $s3Model = new S3Model;

        $s3Model->gelar = $request->gelar;
                
        $s3Model->save();

        return redirect('admin/dosen/s3')->with(['success' => 'Berhasil']);
    }
    public function formEditS3($id){
        $user = Auth::user();
        $data = DB::table('s3')
        ->where('s3.id', $id)->first();
        return view ('admin.dosen.s3.edit',  compact('data', 'user'));
    }
    public function updateS3(Request $request, $id){
        $gelar = $request->gelar;
        
        
        $data = DB::table('s3')
        ->where('id', $id)
        ->update(
        ['gelar' => $gelar]
        );

        return redirect('admin/dosen/s3')->with(['success' => 'Berhasil']);
    }
    

    //Bidang
    public function viewBidang(){
        $user = Auth::user();
        $data = BidangModel::all();
        return view('admin.dosen.bidang.read', compact('data', 'user'));
    }
    public function formAddBidang(){
        $user = Auth::user();
        
        return view ('admin.dosen.bidang.add', compact('user'));
    }
    public function insertBidang(Request $request){
        $bidangModel = new BidangModel;

        $bidangModel->nama_bidang = $request->nama_bidang;
                
        $bidangModel->save();

        return redirect('admin/dosen/bidang')->with(['success' => 'Berhasil']);
    }
    public function formEditBidang($id){
        $user = Auth::user();
        $data = DB::table('bidang')
        ->where('bidang.id', $id)->first();
        return view ('admin.dosen.bidang.edit',  compact('data', 'user'));
    }
    public function updateBidang(Request $request, $id){
        $nama_bidang = $request->nama_bidang;
        
        
        $data = DB::table('bidang')
        ->where('id', $id)
        ->update(
        ['nama_bidang' => $nama_bidang]
        );

        return redirect('admin/dosen/bidang')->with(['success' => 'Berhasil']);
    }
}
