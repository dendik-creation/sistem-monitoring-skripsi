<?php

namespace App\Http\Controllers;

use Response;
use ZipArchive;
use App\S1Model;
use App\S2Model;
use App\S3Model;
use Carbon\Carbon;
use App\DosenModel;
use App\BidangModel;

use App\ProposalModel;
use App\SemesterModel;
use App\MahasiswaModel;
use App\HasilUjianModel;
use App\PengumumanModel;
use App\HasilSemproModel;
use App\JadwalUjianModel;
use App\PlotDosbingModel;
use App\PlotPengujiModel;
use App\BerkasSemproModel;
use App\JadwalSemproModel;
use App\Imports\UserImport;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Imports\MahasiswaImport;
use App\Imports\HasilUjianImport;
use App\Imports\HasilSemproImport;
use App\Imports\PlotDosbingImport;
use App\Imports\PlotPengujiImport;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PendaftarUjianExport;
use App\Imports\PendaftarUjianImport;
use App\Exports\PendaftarSemproExport;
use App\Imports\PendaftarSemproImport;

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
            ->where('berkas_sempro.status', 'Menunggu Verifikasi')
            ->count();
        $jadwalujian = DB::table('berkas_ujian')
            ->join('mahasiswa', 'berkas_ujian.nim', '=', 'mahasiswa.nim')
            ->select(
                'berkas_ujian.id as id',
                'berkas_ujian.nim as nim',
                'mahasiswa.name as nama',
                'berkas_ujian.berkas_ujian as berkas_ujian',
                'berkas_ujian.created_at as tgl_daftar'
            )
            ->where('berkas_ujian.status', 'Menunggu Verifikasi')
            ->count();
        return view('admin.index', compact('user', 'dosen', 'mhs', 'jadwalsempro', 'jadwalujian'));
    }


    //Semester
    public function viewSemester()
    {
        $user = Auth::user();
        $data = DB::table('semester')
            ->where('aktif', 'Y')->get();
        return view('admin.semester.read', compact('data', 'user'));
    }
    public function formEditSemester($id)
    {
        $user = Auth::user();
        $data = DB::table('semester')
            ->where('id', $id)->first();
        return view('admin.semester.edit',  compact('data', 'user'));
    }
    public function updateSemester(Request $request, $id)
    {
        $request->validate(
            [
                'semester' => 'required',
                'tahun' => ['required', 'regex:/^\d{4}\/\d{4}$/'],
            ],
            [
                'semester.required' => 'Semester tidak boleh kosong',
                'tahun.required' => 'Tahun tidak boleh kosong',
                'tahun.regex' => 'Format tahun tidak sesuai',
            ]
        );

        $semester = $request->semester;
        $tahun = $request->tahun;
        $data = DB::table('semester')
            ->where('id', $id)
            ->update(
                ['aktif' => 'N']
            );

        $cek = DB::table('semester')
            ->where('semester', $semester)
            ->where('tahun', $tahun)->first();

        // dd($cek->id);

        if ($cek) {
            $data = DB::table('semester')
                ->where('id', $cek->id)
                ->update(
                    ['aktif' => 'Y']
                );
        } else {
            $sModel = new SemesterModel;

            $sModel->semester = $request->semester;
            $sModel->tahun = $request->tahun;
            $sModel->aktif = 'Y';

            $sModel->save();
        }


        return redirect('admin/semester')->with(['success' => 'Berhasil']);
    }
    //End Semester


    //Dosen
    public function viewDosen()
    {
        $user = Auth::user();
        $data = DB::table('dosen')
            ->join('s1', 'dosen.gelar1', '=', 's1.id')
            ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
            ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
            ->join('bidang', 'dosen.id_bidang', '=', 'bidang.id')
            ->select(
                'dosen.id as id',
                'dosen.nidn as nidn',
                'dosen.name as name',
                's1.gelar as gelar1',
                's2.gelar as gelar2',
                's3.gelar as gelar3',
                's3.depan as depan',
                'dosen.jabatan_fungsional as jabatan',
                'bidang.nama_bidang as bidang',
                'dosen.email as email'
            )
            ->orderByRaw('dosen.id DESC')
            ->get();
        // dd($data);
        return view('admin.dosen.read', compact('data', 'user'));
    }
    public function formAddDosen()
    {
        $user = Auth::user();
        $gelar1 = DB::table('s1')->get();
        $gelar2 = DB::table('s2')->get();
        $gelar3depan = DB::table('s3')->where('depan', 'Y')->get();
        $gelar3belakang = DB::table('s3')->where('depan', 'N')->get();
        $bidang = DB::table('bidang')->get();
        return view('admin.dosen.add', compact('user', 'gelar1', 'gelar2', 'gelar3depan', 'gelar3belakang', 'bidang'));
    }
    public function insertDosen(Request $request)
    {
        $request->validate(
            [
                'nidn' => 'required|numeric',
                'name' => 'required',
                'email' => 'required|email',
                'gelar1' => 'required',
                'jabatan' => 'required',
                'id_bidang' => 'required',
                'ttd' => 'max:2048',
            ],
            [
                'ttd.required' => 'Tanda tangan tidak boleh kosong',
                'ttd.max' => 'File terlalu besar, maksimal 2 mb',
                'nidn.required' => 'NIDN tidak boleh kosong',
                'nidn.numeric' => 'NIDN harus berupa angka',
                'name.required' => 'Nama tidak boleh kosong',
                'email.required' => 'Email tidak boleh kosong',
                'email.email' => 'Format email tidak sesuai',
                'gelar1.required' => 'Gelar 1 tidak boleh kosong',
                'jabatan.required' => 'Jabatan tidak boleh kosong',
                'id_bidang.required' => 'Bidang tidak boleh kosong',
            ]
        );

        // Flash old input values to session
        session()->flash('nidn', $request->nidn);
        session()->flash('name', $request->name);
        session()->flash('email', $request->email);
        session()->flash('gelar1', $request->gelar1);
        session()->flash('jabatan', $request->jabatan);
        session()->flash('id_bidang', $request->id_bidang);

        $ttd = $request->file('ttd');


        $cek = DosenModel::where('nidn', $request->nidn)->first();
        $dModel = new DosenModel;

        if ($cek) {
            return back()->with('error', 'Data Dosen ' . $cek->nidn . ' sudah ada');
        } else {
            // Kalo ganti gambar
            if ($ttd) {
                $tujuan_upload = 'ttd/' . $request->nidn;

                $ttd->move($tujuan_upload, $ttd->getClientOriginalName());

                $ttd = $ttd->getClientOriginalName();


                if ($request->gelar3d == null) {
                    $dModel->nidn = $request->nidn;
                    $dModel->name = $request->name;
                    $dModel->email = $request->email;
                    $dModel->gelar1 = $request->gelar1;
                    $dModel->gelar2 = $request->gelar2;
                    $dModel->gelar3 = $request->gelar3b;
                    $dModel->jabatan_fungsional = $request->jabatan;
                    $dModel->id_bidang = $request->id_bidang;
                    $dModel->ttd = $ttd;

                    $dModel->save();
                } else {
                    $dModel->nidn = $request->nidn;
                    $dModel->name = $request->name;
                    $dModel->email = $request->email;
                    $dModel->gelar1 = $request->gelar1;
                    $dModel->gelar2 = $request->gelar2;
                    $dModel->gelar3 = $request->gelar3d;
                    $dModel->jabatan_fungsional = $request->jabatan;
                    $dModel->id_bidang = $request->id_bidang;
                    $dModel->ttd = $ttd;

                    $dModel->save();
                }
            } else {
                if ($request->gelar3d == null) {
                    $dModel->nidn = $request->nidn;
                    $dModel->name = $request->name;
                    $dModel->email = $request->email;
                    $dModel->gelar1 = $request->gelar1;
                    $dModel->gelar2 = $request->gelar2;
                    $dModel->gelar3 = $request->gelar3b;
                    $dModel->jabatan_fungsional = $request->jabatan;
                    $dModel->id_bidang = $request->id_bidang;

                    $dModel->save();
                } else {
                    $dModel->nidn = $request->nidn;
                    $dModel->name = $request->name;
                    $dModel->email = $request->email;
                    $dModel->gelar1 = $request->gelar1;
                    $dModel->gelar2 = $request->gelar2;
                    $dModel->gelar3 = $request->gelar3d;
                    $dModel->jabatan_fungsional = $request->jabatan;
                    $dModel->id_bidang = $request->id_bidang;

                    $dModel->save();
                }
            }


            $get = DB::table('dosen')
                ->join('s1', 'dosen.gelar1', '=', 's1.id')
                ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
                ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
                ->select(
                    'dosen.id as id',
                    'dosen.nidn as nidn',
                    'dosen.name as name',
                    's1.gelar as gelar1',
                    's2.gelar as gelar2',
                    's3.gelar as gelar3',
                    's3.depan as depan',
                    'dosen.jabatan_fungsional as jabatan',
                    'dosen.email as email'
                )
                ->where('nidn', $request->nidn)->first();

            if ($get->depan == "Y") {
                $fullname = $get->gelar3 . " " . $get->name . ", " . $get->gelar1 . ", " . $get->gelar2;
            } else {
                if ($get->depan == null) {
                    $fullname = $get->name . ", " . $get->gelar1 . ", " . $get->gelar2;
                } else {
                    $fullname = $get->name . ", " . $get->gelar1 . ", " . $get->gelar2 . ", " . $get->gelar3;
                }
            }

            DB::insert('insert into users (no_induk, name, username, email, password, role) values (?, ?, ?, ?, ?, ?)', [$request->nidn, $fullname, $request->nidn, $request->email, Hash::make($request->nidn), 'dosen']);

            return redirect('admin/dosen')->with(['success' => 'Berhasil']);
        }
    }
    public function formEditDosen($id)
    {
        $user = Auth::user();
        $data = DB::table('dosen')
            ->join('bidang', 'dosen.id_bidang', '=', 'bidang.id')
            ->join('s1', 'dosen.gelar1', '=', 's1.id')
            ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
            ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
            ->select(
                'dosen.id as id',
                'dosen.nidn as nidn',
                'dosen.name as name',
                's1.gelar as gelar1',
                's2.gelar as gelar2',
                's3.gelar as gelar3',
                's3.depan as depan',
                's3.depan as depan',
                's1.id as id_gelar1',
                's2.id as id_gelar2',
                's3.id as id_gelar3',
                'dosen.jabatan_fungsional as jabatan',
                'dosen.email as email',
                'bidang.nama_bidang as bidang',
                'bidang.id as id_bidang',
                'dosen.ttd as ttd'
            )
            ->where('nidn', $id)->first();
        $gelar1 = DB::table('s1')->get();
        $gelar2 = DB::table('s2')->get();
        $gelar3depan = DB::table('s3')->where('depan', 'Y')->get();
        $gelar3belakang = DB::table('s3')->where('depan', 'N')->get();
        $bidang = DB::table('bidang')->get();
        return view('admin.dosen.edit',  compact('data', 'user', 'gelar1', 'gelar2', 'gelar3depan', 'gelar3belakang', 'bidang'));
    }
    public function updateDosen(Request $request, $id)
    {
        $request->validate(
            [
                'nidn' => 'required',
                'name' => 'required',
                'email' => 'required|email',
                'gelar1' => 'required',
                'jabatan' => 'required',
                'id_bidang' => 'required',
                'ttd' => 'max:2048',
            ],
            [
                'ttd.required' => 'Tanda tangan tidak boleh kosong',
                'ttd.max' => 'File terlalu besar, maksimal 2 mb',
                'nidn.required' => 'NIDN tidak boleh kosong',
                'name.required' => 'Nama tidak boleh kosong',
                'email.required' => 'Email tidak boleh kosong',
                'email.email' => 'Format email tidak sesuai',
                'gelar1.required' => 'Gelar 1 tidak boleh kosong',
                'jabatan.required' => 'Jabatan tidak boleh kosong',
                'id_bidang.required' => 'Bidang tidak boleh kosong',
            ]
        );
        $ttd = $request->file('ttd');

        $nidn = $request->nidn;
        $name = $request->name;
        $gelar1 = $request->gelar1;
        $gelar2 = $request->gelar2;
        $gelar3d = $request->gelar3d;
        $gelar3b = $request->gelar3b;
        $jabatan_fungsional = $request->jabatan;
        $id_bidang = $request->id_bidang;
        $email = $request->email;

        if ($ttd != null) {
            $tujuan_upload = 'ttd/' . $request->nidn;
            $ttd->move($tujuan_upload, $ttd->getClientOriginalName());
            $ttd = $ttd->getClientOriginalName();

            if ($gelar3d == null) {
                $data = DB::table('dosen')
                    ->where('nidn', $id)
                    ->update(
                        [
                            'name' => $name,
                            'email' => $email,
                            'gelar1' => $gelar1,
                            'gelar2' => $gelar2,
                            'gelar3' => $gelar3b,
                            'jabatan_fungsional' => $jabatan_fungsional,
                            'id_bidang' => $id_bidang,
                            'ttd' => $ttd
                        ]
                    );
            } else {
                $data = DB::table('dosen')
                    ->where('nidn', $id)
                    ->update(
                        [
                            'name' => $name,
                            'email' => $email,
                            'gelar1' => $gelar1,
                            'gelar2' => $gelar2,
                            'gelar3' => $gelar3d,
                            'jabatan_fungsional' => $jabatan_fungsional,
                            'id_bidang' => $id_bidang,
                            'ttd' => $ttd
                        ]
                    );
            }
        } else {
            if ($gelar3d == null) {
                $data = DB::table('dosen')
                    ->where('nidn', $id)
                    ->update(
                        [
                            'name' => $name,
                            'email' => $email,
                            'gelar1' => $gelar1,
                            'gelar2' => $gelar2,
                            'gelar3' => $gelar3b,
                            'jabatan_fungsional' => $jabatan_fungsional,
                            'id_bidang' => $id_bidang
                        ]
                    );
            } else {
                $data = DB::table('dosen')
                    ->where('nidn', $id)
                    ->update(
                        [
                            'name' => $name,
                            'email' => $email,
                            'gelar1' => $gelar1,
                            'gelar2' => $gelar2,
                            'gelar3' => $gelar3d,
                            'jabatan_fungsional' => $jabatan_fungsional,
                            'id_bidang' => $id_bidang
                        ]
                    );
            }
        }

        $get = DB::table('dosen')
            ->join('s1', 'dosen.gelar1', '=', 's1.id')
            ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
            ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
            ->select(
                'dosen.id as id',
                'dosen.nidn as nidn',
                'dosen.name as name',
                's1.gelar as gelar1',
                's2.gelar as gelar2',
                's3.gelar as gelar3',
                's3.depan as depan',
                'dosen.jabatan_fungsional as jabatan',
                'dosen.email as email'
            )
            ->where('nidn', $nidn)->first();

        if ($get->depan == "Y") {
            $fullname = $get->gelar3 . " " . $get->name . ", " . $get->gelar1 . ", " . $get->gelar2;
        } else {
            $fullname = $get->name . ", " . $get->gelar1 . ", " . $get->gelar2 . ", " . $get->gelar3;
        }

        $update = DB::table('users')
            ->where('no_induk', $nidn)
            ->update(
                [
                    'name' => $fullname,
                    'email' => $email,
                ]
            );

        return redirect('admin/dosen')->with(['success' => 'Berhasil']);
    }
    public function deleteDosen($id)
    {
        $user = DB::table('users')
            ->where('no_induk', $id)->delete();

        $data = DB::table('dosen')
            ->where('nidn', $id)->delete();

        return back()->with(['success' => 'Berhasil']);
    }
    //End Dosen


    //Mahasiswa
    public function viewMahasiswa()
    {
        $user = Auth::user();
        $data = MahasiswaModel::all()->sortByDesc("id");
        return view('admin.mahasiswa.read', compact('data', 'user'));
    }
    public function formAddMahasiswa()
    {
        $user = Auth::user();
        return view('admin.mahasiswa.add', compact('user'));
    }
    public function insertMahasiswa(Request $request)
    {
        $request->validate([
            'nim' => 'required|numeric',
            'name' => 'required',
            'email' => 'required|email',
            'hp' => 'required|numeric',
        ], [
            'nim.required' => 'NIM tidak boleh kosong',
            'nim.numeric' => 'NIM harus berupa angka',
            'name.required' => 'Nama tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Format email tidak sesuai',
            'hp.required' => 'No HP tidak boleh kosong',
            'hp.numeric' => 'No HP harus berupa angka',
        ]);

        session()->flash('nim', $request->nim);
        session()->flash('name', $request->name);
        session()->flash('email', $request->email);
        session()->flash('hp', $request->hp);

        $mModel = new MahasiswaModel;
        $mModel->nim = $request->nim;
        $mModel->name = $request->name;
        $mModel->email = $request->email;
        $mModel->hp = $request->hp;

        $mModel->save();

        DB::insert('insert into users (no_induk, name, username, password, role) values (?, ?, ?, ?, ?)', [$request->nim, $request->name, $request->nim, Hash::make($request->nim), 'mahasiswa']);

        return redirect('admin/mahasiswa')->with(['success' => 'Berhasil']);
    }
    public function formEditMahasiswa($id)
    {
        $user = Auth::user();
        $data = DB::table('mahasiswa')
            ->where('nim', $id)->first();
        return view('admin.mahasiswa.edit',  compact('data', 'user'));
    }
    public function updateMahasiswa(Request $request, $id)
    {
        $request->validate([
            'nim' => 'required|numeric',
            'name' => 'required',
            'email' => 'required|email',
            'hp' => 'required|numeric',
        ], [
            'nim.required' => 'NIM tidak boleh kosong',
            'nim.numeric' => 'NIM harus berupa angka',
            'name.required' => 'Nama tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Format email tidak sesuai',
            'hp.required' => 'No HP tidak boleh kosong',
            'hp.numeric' => 'No HP harus berupa angka',
        ]);

        $nim = $request->nim;
        $name = $request->name;
        $email = $request->email;
        $hp = $request->hp;

        $data = DB::table('mahasiswa')
            ->where('nim', $id)
            ->update(
                [
                    'name' => $name,
                    'email' => $email,
                    'hp' => $hp
                ]
            );

        return redirect('admin/mahasiswa')->with(['success' => 'Berhasil']);
    }
    public function deleteMahasiswa($id)
    {
        $user = DB::table('users')
            ->where('no_induk', $id)->delete();


        $del = DB::table('hasil_ujian')
            ->where('nim', $id)->delete();
        $del = DB::table('jadwal_ujian')
            ->where('nim', $id)->delete();
        $del = DB::table('berkas_ujian')
            ->where('nim', $id)->delete();
        $delb = DB::table('pesan_bimbingan')
            ->join('bimbingan', 'pesan_bimbingan.id_bimbingan', '=', 'bimbingan.id')
            ->where('bimbingan.nim', $id)->delete();
        // dd($delb);
        $del = DB::table('bimbingan')
            // ->join('pesan_bimbingan', 'bimbingan.id', '=', 'pesan_bimbingan.id_bimbingan')
            ->where('bimbingan.nim', $id)->delete();
        $del = DB::table('status_skripsi')
            ->where('nim', $id)->delete();
        $del = DB::table('hasil_sempro')
            ->where('nim', $id)->delete();
        $del = DB::table('jadwal_sempro')
            ->where('nim', $id)->delete();
        $del = DB::table('berkas_sempro')
            ->where('nim', $id)->delete();
        // // $ambil =

        $del = DB::table('proposal')
            ->where('nim', $id)->delete();
        $del = DB::table('plot_dosbing')
            ->where('nim', $id)->delete();
        $data = DB::table('mahasiswa')
            ->where('nim', $id)->delete();

        return back()->with(['success' => 'Berhasil Hapus Data']);
    }

    public function resetMahasiswa(Request $request, $id)
    {
        $request->validate([
            'nim' => 'required|numeric',
        ], [
            'nim.required' => 'NIM tidak boleh kosong',
            'nim.numeric' => 'NIM harus berupa angka',
        ]);
        $nim = $request->nim;
        $data = DB::table('users')
            ->where('no_induk', $id)
            ->update(
                ['password' => Hash::make($nim)]
            );
        return back()->with(['success' => 'Berhasil Reset Password']);
    }
    //End Mahasiswa


    //Proposal Plotting
    public function viewProposalPlotting()
    {
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
            ->join('mahasiswa as mhs', 'plot_dosbing.nim', '=', 'mhs.nim')
            ->select(
                'plot_dosbing.id as id',
                'plot_dosbing.smt as smt',
                'plot_dosbing.nim as nim',
                'mhs.name as name',
                'dos1.name as dosbing1',
                'dos2.name as dosbing2',
                's11.gelar as gelar11',
                's21.gelar as gelar21',
                's31.gelar as gelar31',
                's12.gelar as gelar12',
                's22.gelar as gelar22',
                's32.gelar as gelar32',
                's31.depan as depan1',
                's32.depan as depan2'
            )
            ->orderByRaw('plot_dosbing.id DESC')
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
        // $this->validate($request, [
        // 	'file' => 'required|mimes:csv,xls,xlsx'
        // ]);

        // menangkap file excel
        $file = $request->file('file');

        // membuat nama file unik
        $nama_file = rand() . $file->getClientOriginalName();

        // upload ke folder file_siswa di dalam folder public
        $file->move('file_excel', $nama_file);

        //1
        $import1 = new plotDosbingImport;
        // $import2 = new mahasiswaImport;
        // $import3 = new userImport;
        $import1->import(public_path('/file_excel/' . $nama_file));
        // $import2->import(public_path('/file_excel/' . $nama_file));
        // $import3->import(public_path('/file_excel/' . $nama_file));
        // dd($import1);

        if ($import1->failures()->isNotEmpty()) {
            return back()->withFailures($import1->failures());
        }


        return redirect('admin/proposal/plotting')->with(['success' => 'Berhasil']);
    }

    public function formAddSatuMahasiswa()
    {
        $user = Auth::user();
        $smt = DB::table('semester')
            ->where('aktif', 'Y')->first();

        $dosen1 = DB::table('dosen')
            ->join('s1', 'dosen.gelar1', '=', 's1.id')
            ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
            ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
            ->select(
                'dosen.id as id',
                'dosen.nidn as nidn',
                'dosen.name as name',
                's1.gelar as gelar1',
                's2.gelar as gelar2',
                's3.gelar as gelar3',
                's3.depan as depan',
                'dosen.jabatan_fungsional as jabatan',
                'dosen.email as email'
            )
            ->get();
        $dosen2 = DB::table('dosen')
            ->join('s1', 'dosen.gelar1', '=', 's1.id')
            ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
            ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
            ->select(
                'dosen.id as id',
                'dosen.nidn as nidn',
                'dosen.name as name',
                's1.gelar as gelar1',
                's2.gelar as gelar2',
                's3.gelar as gelar3',
                's3.depan as depan',
                'dosen.jabatan_fungsional as jabatan',
                'dosen.email as email'
            )
            ->get();

        $mahasiswa = DB::table('mahasiswa')
            ->leftJoin('plot_dosbing as ptb', 'mahasiswa.nim', '=', 'ptb.nim')
            ->select('mahasiswa.nim', 'mahasiswa.name')
            ->whereNull('ptb.nim')
            ->get();


        return view('admin.proposal.plotting.add', compact('smt', 'dosen1', 'dosen2', 'user', 'mahasiswa'));
    }
    public function insertSatuMahasiswa(Request $request)
    {
        //[Syahrul][15/95/2925] perubahan rule mahasiswa dengan relasi table mahasiswa
        $request->validate([
            'nim' => 'required|numeric|unique:plot_dosbing,nim',
            // 'name' => 'required|string|max:255',
            'smt' => 'required|string|max:255',
            'dosbing1' => 'required|string|max:255',
            'dosbing2' => 'nullable|string|max:255',
        ], [
            'nim.required' => 'Mahasiswa tidak boleh kosong',
            'nim.numeric' => 'NIM harus berupa angka',
            'nim.unique' => 'Data Mahasiswa dengan NIM ini sudah ada',
            // 'name.required' => 'Nama tidak boleh kosong',
            'smt.required' => 'Semester tidak boleh kosong',
            'dosbing1.required' => 'Dosen pembimbing 1 tidak boleh kosong',
        ]);

        // $existingMahasiswa = MahasiswaModel::where('nim', $request->nim)->first();
        // if ($existingMahasiswa) {
        //     return back()->with('error', 'Data Mahasiswa dengan NIM ini sudah ada');
        // }
        $same_dosbing = $request->dosbing1 == $request->dosbing2;
        if ($same_dosbing) {
            return back()->with('error', 'Dosen pembimbing tidak boleh sama');
        }

        DB::transaction(function () use ($request) {
            //sudah dilakukan saat input mahassiwa
            // MahasiswaModel::create([
            //     'nim' => $request->nim,
            //     'name' => $request->name,
            // ]);

            // DB::table('users')->insert([
            //     'no_induk' => $request->nim,
            //     'name' => $request->name,
            //     'username' => $request->nim,
            //     'password' => Hash::make($request->nim),
            //     'role' => 'mahasiswa',
            // ]);

            PlotDosbingModel::create([
                'smt' => $request->smt,
                'nim' => $request->nim,
                'dosbing1' => $request->dosbing1,
                'dosbing2' => $request->dosbing2,
            ]);
        });

        return redirect('admin/proposal/plotting')->with(['success' => 'Berhasil']);
    }

    public function formEditPlotDosbing($id)
    {
        $user = Auth::user();
        $data = DB::table('plot_dosbing')->join('mahasiswa as mhs', 'plot_dosbing.nim', '=', 'mhs.nim')->select(
            'plot_dosbing.id',
            'plot_dosbing.smt',
            'plot_dosbing.nim',
            'mhs.name',
            'plot_dosbing.dosbing1',
            'plot_dosbing.dosbing2',
        )
            ->where('plot_dosbing.id', $id)->first();

        $dosen1 = DB::table('dosen')
            ->join('s1', 'dosen.gelar1', '=', 's1.id')
            ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
            ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
            ->select(
                'dosen.id as id',
                'dosen.nidn as nidn',
                'dosen.name as name',
                's1.gelar as gelar1',
                's2.gelar as gelar2',
                's3.gelar as gelar3',
                's3.depan as depan',
                'dosen.jabatan_fungsional as jabatan',
                'dosen.email as email'
            )
            // ->where('nidn', $data->dosbing1)
            ->get();
        $dosen2 = DB::table('dosen')
            ->join('s1', 'dosen.gelar1', '=', 's1.id')
            ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
            ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
            ->select(
                'dosen.id as id',
                'dosen.nidn as nidn',
                'dosen.name as name',
                's1.gelar as gelar1',
                's2.gelar as gelar2',
                's3.gelar as gelar3',
                's3.depan as depan',
                'dosen.jabatan_fungsional as jabatan',
                'dosen.email as email'
            )
            // ->where('nidn', $data->dosbing2)
            ->get();



        return view('admin.proposal.plotting.edit', compact('data', 'dosen1', 'dosen2', 'user'));
    }

    public function updatePlotDosbing(Request $request, $id)
    {
        $dosbing1 = $request->dosbing1;
        $dosbing2 = $request->dosbing2;

        if ($dosbing1 == $dosbing2) {
            return back()->with('error', 'Dosen pembimbing tidak boleh sama');
        }

        $data = DB::table('plot_dosbing')
            ->where('id', $id)
            ->update(
                [
                    'dosbing1' => $dosbing1,
                    'dosbing2' => $dosbing2,
                ]
            );

        return redirect('admin/proposal/plotting')->with(['success' => 'Berhasil']);
    }

    //Proposal Monitoring
    public function viewProposalMonitoring()
    {
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

            ->select(
                'proposal.id as id',
                'proposal.nim as nim',
                'mahasiswa.name as nama',
                'proposal.judul as judul',
                'proposal.ket1 as ket1',
                'proposal.ket2 as ket2',
                'proposal.proposal as proposal',
                'semester.semester as semester',
                'semester.tahun as tahun',
                'plot_dosbing.dosbing1 as dosbing1',
                'plot_dosbing.dosbing2 as dosbing2',
                'dos1.name as dosbing1',
                'dos2.name as dosbing2',
                's11.gelar as gelar11',
                's21.gelar as gelar21',
                's31.gelar as gelar31',
                's12.gelar as gelar12',
                's22.gelar as gelar22',
                's32.gelar as gelar32',
                's31.depan as depan1',
                's32.depan as depan2'
            )
            ->orderByRaw('proposal.id DESC')
            ->get();
        return view('admin.proposal.monitoring.read', compact('data', 'user'));
    }


    //Proposal Data Pendaftar
    public function viewProposalPendaftar()
    {
        $user = Auth::user();
        $data = DB::table('berkas_sempro')
            ->join('mahasiswa', 'berkas_sempro.nim', '=', 'mahasiswa.nim')
            ->join('plot_dosbing', 'berkas_sempro.id_plot_dosbing', '=', 'plot_dosbing.id')
            ->join('proposal', 'berkas_sempro.id_proposal', '=', 'proposal.id')
            ->join('semester', 'berkas_sempro.id_semester', '=', 'semester.id')
            ->select(
                'berkas_sempro.id as id',
                'berkas_sempro.nim as nim',
                'mahasiswa.name as nama',
                'berkas_sempro.*',
                'berkas_sempro.created_at as tgl_daftar',
                'semester.semester as semester',
                'semester.tahun as tahun',
                'berkas_sempro.status as status',
                'berkas_sempro.komentar_admin as komentar'
            )
            ->where('berkas_sempro.status', 'Menunggu Verifikasi')
            ->orderByRaw('berkas_sempro.id DESC')
            ->get();
        return view('admin.proposal.pendaftar.read', compact('data', 'user'));
    }

    //berkasok
    public function berkasSemproOk($id)
    {
        $user = Auth::user();

        $data = DB::table('berkas_sempro')
            ->where('id', $id)
            ->update(
                ['status' => 'Berkas OK']
            );

        return redirect('admin/proposal/penjadwalan');
    }

    //berkaskurang
    public function berkasSemproKurang(Request $request, $id)
    {
        $user = Auth::user();

        $data = DB::table('berkas_sempro')
            ->where('id', $id)
            ->update(
                [
                    'status' => 'Berkas tidak lengkap',
                    'komentar_admin' => $request->komentar_admin
                ]
            );

        return redirect('admin/proposal/pendaftar');
    }

    public function exportBerkasSempro()
    {
        return Excel::download(new PendaftarSemproExport, 'Pendaftar Sempro Berkas OK.xlsx');
    }

    public function viewProposalPendaftarCekBerkas($id)
    {
        $user = Auth::user();
        $data = DB::table('berkas_sempro')
            ->join('mahasiswa', 'berkas_sempro.nim', '=', 'mahasiswa.nim')
            ->join('plot_dosbing', 'berkas_sempro.id_plot_dosbing', '=', 'plot_dosbing.id')
            ->join('proposal', 'berkas_sempro.id_proposal', '=', 'proposal.id')
            ->select(
                'berkas_sempro.id as id',
                'berkas_sempro.nim as nim',
                'mahasiswa.name as nama',
                'mahasiswa.hp as hp',
                'proposal.judul as judul',
                'proposal.id as id_proposal',
                'plot_dosbing.dosbing1 as dosbing1',
                'plot_dosbing.dosbing2 as dosbing2',
                'berkas_sempro.*',
                'berkas_sempro.created_at as tgl_daftar'
            )
            ->where('berkas_sempro.id', $id)
            ->get();
        $dosen1 = DB::table('dosen')
            ->join('s1', 'dosen.gelar1', '=', 's1.id')
            ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
            ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
            ->select(
                'dosen.id as id',
                'dosen.nidn as nidn',
                'dosen.name as name',
                's1.gelar as gelar1',
                's2.gelar as gelar2',
                's3.gelar as gelar3',
                's3.depan as depan',
                'dosen.jabatan_fungsional as jabatan',
                'dosen.email as email'
            )
            ->where('nidn', $data[0]->dosbing1)->first();
        $dosen2 = DB::table('dosen')
            ->join('s1', 'dosen.gelar1', '=', 's1.id')
            ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
            ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
            ->select(
                'dosen.id as id',
                'dosen.nidn as nidn',
                'dosen.name as name',
                's1.gelar as gelar1',
                's2.gelar as gelar2',
                's3.gelar as gelar3',
                's3.depan as depan',
                'dosen.jabatan_fungsional as jabatan',
                'dosen.email as email'
            )
            ->where('nidn', $data[0]->dosbing2)->first();

        // $zip = new ZipArchive;
        // $res = $zip->open('filemhs/'.$data[0]->nim.'/berkas_sempro/'.$data[0]->berkas_sempro);
        // if (!File::exists('filemhs/'.$data[0]->nim.'/berkas_sempro/extract')) {
        //     $zip->extractTo('filemhs/'.$data[0]->nim.'/berkas_sempro/extract');
        //     $zip->close();
        //     // $heh = "ya";
        // } else {
        //     // $heh = "tidak";
        // }

        //[Syahrul][05/05/2025] extract dihilangkan karena sudah ada file asli
        // $path = public_path('filemhs/'.$data[0]->nim.'/berkas_sempro/extract');
        // dd($data);
        // $path = public_path('filemhs/' . $data[0]->nim . '/berkas_sempro/'.$data[0]->berkas_sempro);
        // $path = public_path('filemhs' . DIRECTORY_SEPARATOR . $data[0]->nim . DIRECTORY_SEPARATOR . 'berkas_sempro' );


        // $allFiles = scandir($path);
        // $files = array_diff($allFiles, array('.', '..'));

        //[Syahrul][06/05/2025] hilangkan extract zip karena yang disimpan secara database hanya 1
        $file = null;

        $path = public_path('filemhs' . DIRECTORY_SEPARATOR . $data[0]->nim . DIRECTORY_SEPARATOR . 'berkas_sempro');
        $filePath = $path . DIRECTORY_SEPARATOR . $data[0]->berkas_sempro;

        if (File::exists($filePath)) {
            $file = $data[0]->berkas_sempro;
        }

        return view('admin.proposal.pendaftar.detailberkas', compact('data', 'user', 'dosen1', 'dosen2', 'file'));
    }

    public function hapusBerkasSempro($nim, $file)
    {
        unlink('filemhs/' . $nim . '/berkas_sempro/extract/' . $file);
        return back();
    }

    public function hapusBerkasUjian($nim, $file)
    {
        // unlink('filemhs/' . $nim . '/berkas_ujian/extract/' . $file);
        unlink('filemhs/' . $nim . '/berkas_ujian/' . $file);
        return back();
    }

    public function viewProposalPendaftarDetail($id)
    {
        $user = Auth::user();
        $data = DB::table('berkas_sempro')
            ->join('mahasiswa', 'berkas_sempro.nim', '=', 'mahasiswa.nim')
            ->join('plot_dosbing', 'berkas_sempro.id_plot_dosbing', '=', 'plot_dosbing.id')
            ->join('proposal', 'berkas_sempro.id_proposal', '=', 'proposal.id')
            ->select(
                'berkas_sempro.id as id',
                'berkas_sempro.nim as nim',
                'mahasiswa.name as nama',
                'mahasiswa.hp as hp',
                'proposal.judul as judul',
                'proposal.id as id_proposal',
                'plot_dosbing.dosbing1 as dosbing1',
                'plot_dosbing.dosbing2 as dosbing2',
                'berkas_sempro.*',
                'berkas_sempro.created_at as tgl_daftar'
            )
            ->where('berkas_sempro.id', $id)
            ->get();
        $dosen1 = DB::table('dosen')
            ->join('s1', 'dosen.gelar1', '=', 's1.id')
            ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
            ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
            ->select(
                'dosen.id as id',
                'dosen.nidn as nidn',
                'dosen.name as name',
                's1.gelar as gelar1',
                's2.gelar as gelar2',
                's3.gelar as gelar3',
                's3.depan as depan',
                'dosen.jabatan_fungsional as jabatan',
                'dosen.email as email'
            )
            ->where('nidn', $data[0]->dosbing1)->first();
        $dosen2 = DB::table('dosen')
            ->join('s1', 'dosen.gelar1', '=', 's1.id')
            ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
            ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
            ->select(
                'dosen.id as id',
                'dosen.nidn as nidn',
                'dosen.name as name',
                's1.gelar as gelar1',
                's2.gelar as gelar2',
                's3.gelar as gelar3',
                's3.depan as depan',
                'dosen.jabatan_fungsional as jabatan',
                'dosen.email as email'
            )
            ->where('nidn', $data[0]->dosbing2)->first();

        return view('admin.proposal.pendaftar.detail', compact('data', 'user', 'dosen1', 'dosen2',));
    }

    public function insertJadwalSempro(Request $request)
    {
        // [Syahrul][06/05/2025] penambahan validasi dan keterangan
        $this->validate(
            $request,
            [
                'tanggal' => 'required|date',
                'jam' => 'required|date_format:H:i',
                'tempat' => 'required|string|max:255',
                'ket' => 'required|string|max:255',
                'nim' => 'required|numeric|digits_between:8,12',
                'id_berkas_sempro' => 'required|integer',
                'id_proposal' => 'required|integer',
            ],
            [
                'tanggal.required' => 'Tanggal wajib diisi.',
                'tanggal.date' => 'Tanggal harus dalam format yang benar (yyyy-mm-dd).',

                'jam.required' => 'Jam wajib diisi.',
                'jam.date_format' => 'Format jam harus benar (contoh: 13:30).',

                'tempat.required' => 'Tempat wajib diisi.',
                'tempat.string' => 'Tempat harus berupa teks.',

                'ket.required' => 'Keterangan wajib diisi.',
                'ket.string' => 'Keterangan harus berupa teks.',

                'nim.required' => 'NIM wajib diisi.',
                'id_berkas_sempro.required' => 'ID Berkas Sempro wajib diisi.',
                'id_proposal.required' => 'ID Proposal wajib diisi.',
            ]
        );


        $smt = SemesterModel::all()->where('aktif', 'Y')->first();

        $jsModel = new JadwalSemproModel;

        $jsModel->nim = $request->nim;
        $jsModel->id_semester = $smt->id;
        $jsModel->id_berkas_sempro = $request->id_berkas_sempro;
        $jsModel->tanggal = $request->tanggal;
        $jsModel->jam = $request->jam;
        $jsModel->tempat = $request->tempat;
        $jsModel->ket = $request->ket;
        $jsModel->created_at = Carbon::now();
        $jsModel->updated_at = Carbon::now();

        $jsModel->save();


        $data = DB::table('berkas_sempro')
            ->where('id', $request->id_berkas_sempro)
            ->update(
                [
                    'status' => 'Terjadwal',
                    'komentar_admin' => 'Terjadwal'
                ]
            );

        $hsModel = new HasilSemproModel;
        $hsModel->id_semester = $smt->id;
        $hsModel->nim = $request->nim;
        $hsModel->id_proposal = $request->id_proposal;
        $hsModel->save();

        return redirect('admin/proposal/penjadwalan')->with(['success' => 'Berhasil']);
    }

    public function penjadwalanSemproImportExcel(Request $request)
    {
        // validasi
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        // menangkap file excel
        $file = $request->file('file');

        // membuat nama file unik
        $nama_file = rand() . $file->getClientOriginalName();

        // upload ke folder file_siswa di dalam folder public
        $file->move('file_excel', $nama_file);

        // import data
        Excel::import(new PendaftarSemproImport, public_path('/file_excel/' . $nama_file));
        Excel::import(new HasilSemproImport, public_path('/file_excel/' . $nama_file));

        $data = DB::table('berkas_sempro')
            ->where('status', 'Berkas OK')
            ->update(
                [
                    'status' => 'Terjadwal',
                    'komentar_admin' => 'Terjadwal'
                ]
            );

        return redirect('admin/proposal/penjadwalan')->with(['success' => 'Berhasil']);
    }


    //Proposal Data Penjadwalan
    public function viewProposalPenjadwalan()
    {
        $user = Auth::user();
        // $data = DB::table('jadwal_sempro')
        // ->join('mahasiswa', 'jadwal_sempro.nim', '=', 'mahasiswa.nim')
        // ->join('berkas_sempro', 'jadwal_sempro.id_berkas_sempro', '=', 'berkas_sempro.id')
        // ->join('proposal', 'berkas_sempro.id_proposal', '=', 'proposal.id')
        // ->join('plot_dosbing', 'berkas_sempro.id_plot_dosbing', '=', 'plot_dosbing.id')
        // ->join('semester', 'proposal.id_semester', '=', 'semester.id')
        // // ->join('hasil_sempro', 'hasil_sempro.id', '=', 'jadwal_sempro.id')

        // ->join('dosen as dos1', 'plot_dosbing.dosbing1', '=', 'dos1.nidn')
        // ->join('dosen as dos2', 'plot_dosbing.dosbing2', '=', 'dos2.nidn')

        // ->join('s1 as s11', 'dos1.gelar1', '=', 's11.id')
        // ->leftJoin('s2 as s21', 'dos1.gelar2', '=', 's21.id')
        // ->leftJoin('s3 as s31', 'dos1.gelar3', '=', 's31.id')

        // ->join('s1 as s12', 'dos2.gelar1', '=', 's12.id')
        // ->leftJoin('s2 as s22', 'dos2.gelar2', '=', 's22.id')
        // ->leftJoin('s3 as s32', 'dos2.gelar3', '=', 's32.id')

        // ->select('jadwal_sempro.id as id', 'jadwal_sempro.nim as nim', 'mahasiswa.name as nama', 'berkas_sempro.id as id_berkas_sempro', 'proposal.judul as judul',
        // 'plot_dosbing.dosbing1 as dosbing1', 'plot_dosbing.dosbing2 as dosbing2' ,'jadwal_sempro.tanggal as tanggal', 'semester.semester as semester', 'semester.tahun as tahun',
        // 'jadwal_sempro.jam as jam', 'jadwal_sempro.tempat as tempat', 'jadwal_sempro.ket as ket', 'jadwal_sempro.status1 as status1', 'jadwal_sempro.status2 as status2',
        // 'dos1.name as dosbing1', 'dos2.name as dosbing2', 's11.gelar as gelar11', 's21.gelar as gelar21', 's31.gelar as gelar31',
        // 's12.gelar as gelar12', 's22.gelar as gelar22', 's32.gelar as gelar32', )
        // // ->where('status', 'Berkas OK')
        // // ->orWhere('status', 'Terjadwal')
        // ->orderByRaw('jadwal_sempro.id DESC')
        // ->get();

        // $data = DB::table('hasil_sempro')
        // ->join('mahasiswa', 'hasil_sempro.nim', '=', 'mahasiswa.nim')
        // ->join('proposal', 'hasil_sempro.id_proposal', '=', 'proposal.id')
        // ->join('jadwal_sempro', 'hasil_sempro.id_jadwal_sempro', '=', 'jadwal_sempro.id')
        // ->join('plot_dosbing', 'proposal.id_plot_dosbing', '=', 'plot_dosbing.id')
        // ->join('semester', 'proposal.id_semester', '=', 'semester.id')
        // ->select('jadwal_sempro.id as id', 'hasil_sempro.nim as nim','semester.semester as semester', 'semester.tahun as tahun', 'mahasiswa.name as nama', 'proposal.judul as judul', 'jadwal_sempro.status1 as status1', 'jadwal_sempro.status2 as status2', 'hasil_sempro.berita_acara as berita_acara',
        // 'jadwal_sempro.tanggal as tanggal', 'jadwal_sempro.jam as jam', 'jadwal_sempro.tempat as tempat', 'jadwal_sempro.ket as ket',)
        // ->get();

        $data = DB::table('berkas_sempro')
            ->join('mahasiswa', 'berkas_sempro.nim', '=', 'mahasiswa.nim')
            ->join('proposal', 'berkas_sempro.id_proposal', '=', 'proposal.id')
            ->join('plot_dosbing', 'berkas_sempro.id_plot_dosbing', '=', 'plot_dosbing.id')
            ->join('semester', 'berkas_sempro.id_semester', '=', 'semester.id')

            ->join('dosen as dos1', 'plot_dosbing.dosbing1', '=', 'dos1.nidn')
            ->leftJoin('dosen as dos2', 'plot_dosbing.dosbing2', '=', 'dos2.nidn')

            ->join('s1 as s11', 'dos1.gelar1', '=', 's11.id')
            ->leftJoin('s2 as s21', 'dos1.gelar2', '=', 's21.id')
            ->leftJoin('s3 as s31', 'dos1.gelar3', '=', 's31.id')

            ->leftJoin('s1 as s12', 'dos2.gelar1', '=', 's12.id')
            ->leftJoin('s2 as s22', 'dos2.gelar2', '=', 's22.id')
            ->leftJoin('s3 as s32', 'dos2.gelar3', '=', 's32.id')

            ->select(
                'berkas_sempro.id as id',
                'berkas_sempro.nim as nim',
                'mahasiswa.name as nama',
                'proposal.judul as judul',
                'plot_dosbing.dosbing1 as dosbing1',
                'plot_dosbing.dosbing2 as dosbing2',
                'semester.semester as semester',
                'semester.tahun as tahun',
                'berkas_sempro.status as status',
                'dos1.name as dosbing1',
                'dos2.name as dosbing2',
                's11.gelar as gelar11',
                's21.gelar as gelar21',
                's31.gelar as gelar31',
                's12.gelar as gelar12',
                's22.gelar as gelar22',
                's32.gelar as gelar32',
            )
            ->where('status', 'Berkas OK')
            ->orWhere('status', 'Terjadwal')
            ->orderByRaw('berkas_sempro.id DESC')
            ->get();
        // dd($data);

        // $ba = DB::table('jadwal_sempro')->where('id_berkas_sempro', $data->id)->first();

        return view('admin.proposal.penjadwalan.read', compact('data', 'user'));
    }

    //filtering
    public function viewProposalPenjadwalanFilter($id)
    {
        $user = Auth::user();

        if ($id == 1) {
            $data = DB::table('berkas_sempro')
                ->join('mahasiswa', 'berkas_sempro.nim', '=', 'mahasiswa.nim')
                ->join('proposal', 'berkas_sempro.id_proposal', '=', 'proposal.id')
                ->join('plot_dosbing', 'berkas_sempro.id_plot_dosbing', '=', 'plot_dosbing.id')
                ->join('semester', 'berkas_sempro.id_semester', '=', 'semester.id')

                ->join('dosen as dos1', 'plot_dosbing.dosbing1', '=', 'dos1.nidn')
                ->join('dosen as dos2', 'plot_dosbing.dosbing2', '=', 'dos2.nidn')

                ->join('s1 as s11', 'dos1.gelar1', '=', 's11.id')
                ->leftJoin('s2 as s21', 'dos1.gelar2', '=', 's21.id')
                ->leftJoin('s3 as s31', 'dos1.gelar3', '=', 's31.id')

                ->join('s1 as s12', 'dos2.gelar1', '=', 's12.id')
                ->leftJoin('s2 as s22', 'dos2.gelar2', '=', 's22.id')
                ->leftJoin('s3 as s32', 'dos2.gelar3', '=', 's32.id')

                ->select(
                    'berkas_sempro.id as id',
                    'berkas_sempro.nim as nim',
                    'mahasiswa.name as nama',
                    'proposal.judul as judul',
                    'plot_dosbing.dosbing1 as dosbing1',
                    'plot_dosbing.dosbing2 as dosbing2',
                    'semester.semester as semester',
                    'semester.tahun as tahun',
                    'berkas_sempro.status as status',
                    'dos1.name as dosbing1',
                    'dos2.name as dosbing2',
                    's11.gelar as gelar11',
                    's21.gelar as gelar21',
                    's31.gelar as gelar31',
                    's12.gelar as gelar12',
                    's22.gelar as gelar22',
                    's32.gelar as gelar32',
                )
                ->where('status', 'Berkas OK')
                ->orderByRaw('berkas_sempro.id DESC')
                ->get();
        } else if ($id == 2) {
            $data = DB::table('berkas_sempro')
                ->join('mahasiswa', 'berkas_sempro.nim', '=', 'mahasiswa.nim')
                ->join('proposal', 'berkas_sempro.id_proposal', '=', 'proposal.id')
                ->join('plot_dosbing', 'berkas_sempro.id_plot_dosbing', '=', 'plot_dosbing.id')
                ->join('semester', 'berkas_sempro.id_semester', '=', 'semester.id')

                ->join('dosen as dos1', 'plot_dosbing.dosbing1', '=', 'dos1.nidn')
                ->join('dosen as dos2', 'plot_dosbing.dosbing2', '=', 'dos2.nidn')

                ->join('s1 as s11', 'dos1.gelar1', '=', 's11.id')
                ->leftJoin('s2 as s21', 'dos1.gelar2', '=', 's21.id')
                ->leftJoin('s3 as s31', 'dos1.gelar3', '=', 's31.id')

                ->join('s1 as s12', 'dos2.gelar1', '=', 's12.id')
                ->leftJoin('s2 as s22', 'dos2.gelar2', '=', 's22.id')
                ->leftJoin('s3 as s32', 'dos2.gelar3', '=', 's32.id')

                ->select(
                    'berkas_sempro.id as id',
                    'berkas_sempro.nim as nim',
                    'mahasiswa.name as nama',
                    'proposal.judul as judul',
                    'plot_dosbing.dosbing1 as dosbing1',
                    'plot_dosbing.dosbing2 as dosbing2',
                    'semester.semester as semester',
                    'semester.tahun as tahun',
                    'berkas_sempro.status as status',
                    'dos1.name as dosbing1',
                    'dos2.name as dosbing2',
                    's11.gelar as gelar11',
                    's21.gelar as gelar21',
                    's31.gelar as gelar31',
                    's12.gelar as gelar12',
                    's22.gelar as gelar22',
                    's32.gelar as gelar32',
                )
                ->orWhere('status', 'Terjadwal')
                ->orderByRaw('berkas_sempro.id DESC')
                ->get();
        } else if ($id == 3) {
            $data = DB::table('berkas_sempro')
                ->join('mahasiswa', 'berkas_sempro.nim', '=', 'mahasiswa.nim')
                ->join('proposal', 'berkas_sempro.id_proposal', '=', 'proposal.id')
                ->join('plot_dosbing', 'berkas_sempro.id_plot_dosbing', '=', 'plot_dosbing.id')
                ->join('semester', 'berkas_sempro.id_semester', '=', 'semester.id')

                ->join('dosen as dos1', 'plot_dosbing.dosbing1', '=', 'dos1.nidn')
                ->join('dosen as dos2', 'plot_dosbing.dosbing2', '=', 'dos2.nidn')

                ->join('s1 as s11', 'dos1.gelar1', '=', 's11.id')
                ->leftJoin('s2 as s21', 'dos1.gelar2', '=', 's21.id')
                ->leftJoin('s3 as s31', 'dos1.gelar3', '=', 's31.id')

                ->join('s1 as s12', 'dos2.gelar1', '=', 's12.id')
                ->leftJoin('s2 as s22', 'dos2.gelar2', '=', 's22.id')
                ->leftJoin('s3 as s32', 'dos2.gelar3', '=', 's32.id')

                ->select(
                    'berkas_sempro.id as id',
                    'berkas_sempro.nim as nim',
                    'mahasiswa.name as nama',
                    'proposal.judul as judul',
                    'plot_dosbing.dosbing1 as dosbing1',
                    'plot_dosbing.dosbing2 as dosbing2',
                    'semester.semester as semester',
                    'semester.tahun as tahun',
                    'berkas_sempro.status as status',
                    'dos1.name as dosbing1',
                    'dos2.name as dosbing2',
                    's11.gelar as gelar11',
                    's21.gelar as gelar21',
                    's31.gelar as gelar31',
                    's12.gelar as gelar12',
                    's22.gelar as gelar22',
                    's32.gelar as gelar32',
                )
                ->where('status', 'Berkas OK')
                ->orWhere('status', 'Terjadwal')
                ->orderByRaw('berkas_sempro.id DESC')
                ->get();
        }
        return $data;
    }

    public function viewDetailJadwalSempro($id)
    {
        $user = Auth::user();
        $data = DB::table('jadwal_sempro')
            ->join('mahasiswa', 'jadwal_sempro.nim', '=', 'mahasiswa.nim')
            ->join('berkas_sempro', 'jadwal_sempro.id_berkas_sempro', '=', 'berkas_sempro.id')
            ->join('proposal', 'berkas_sempro.id_proposal', '=', 'proposal.id')
            ->join('plot_dosbing', 'berkas_sempro.id_plot_dosbing', '=', 'plot_dosbing.id')

            ->join('dosen as dos1', 'plot_dosbing.dosbing1', '=', 'dos1.nidn')
            ->leftJoin('dosen as dos2', 'plot_dosbing.dosbing2', '=', 'dos2.nidn')

            ->join('s1 as s11', 'dos1.gelar1', '=', 's11.id')
            ->leftJoin('s2 as s21', 'dos1.gelar2', '=', 's21.id')
            ->leftJoin('s3 as s31', 'dos1.gelar3', '=', 's31.id')

            ->leftJoin('s1 as s12', 'dos2.gelar1', '=', 's12.id')
            ->leftJoin('s2 as s22', 'dos2.gelar2', '=', 's22.id')
            ->leftJoin('s3 as s32', 'dos2.gelar3', '=', 's32.id')

            ->select(
                'jadwal_sempro.id as id',
                'jadwal_sempro.nim as nim',
                'mahasiswa.name as nama',
                'mahasiswa.hp as hp',
                'berkas_sempro.id as id_berkas_sempro',
                'proposal.judul as judul',
                'plot_dosbing.dosbing1 as dosbing1',
                'plot_dosbing.dosbing2 as dosbing2',
                'jadwal_sempro.tanggal as tanggal',
                'jadwal_sempro.jam as jam',
                'jadwal_sempro.tempat as tempat',
                'jadwal_sempro.ket as ket',
                'jadwal_sempro.status1 as status1',
                'jadwal_sempro.status2 as status2',
                'dos1.name as dosbing1',
                'dos2.name as dosbing2',
                's11.gelar as gelar11',
                's21.gelar as gelar21',
                's31.gelar as gelar31',
                's12.gelar as gelar12',
                's22.gelar as gelar22',
                's32.gelar as gelar32',
                's31.depan as depan1',
                's32.depan as depan2'
            )
            ->where('jadwal_sempro.id_berkas_sempro', $id)
            ->get();
        // dd($data);

        $hasil_sempro = DB::table('hasil_sempro')
            ->select('hasil_sempro.id as id')
            ->where('hasil_sempro.nim', $data[0]->nim)
            ->first();
        return view('admin.proposal.penjadwalan.detail', compact('data', 'user', 'hasil_sempro'));
    }

    //View Hasil Sempro
    public function viewHasilSempro()
    {
        $user = Auth::user();
        $data = DB::table('hasil_sempro')
            ->join('mahasiswa', 'hasil_sempro.nim', '=', 'mahasiswa.nim')
            ->join('proposal', 'hasil_sempro.id_proposal', '=', 'proposal.id')
            ->join('jadwal_sempro', 'hasil_sempro.id_jadwal_sempro', '=', 'jadwal_sempro.id')
            ->join('plot_dosbing', 'proposal.id_plot_dosbing', '=', 'plot_dosbing.id')
            ->join('semester', 'hasil_sempro.id_semester', '=', 'semester.id')
            ->select(
                'hasil_sempro.id as id',
                'hasil_sempro.nim as nim',
                'mahasiswa.name as nama',
                'proposal.judul as judul',
                'jadwal_sempro.status1 as status1',
                'jadwal_sempro.status2 as status2',
                'hasil_sempro.berita_acara as berita_acara',
                'jadwal_sempro.tanggal as tanggal',
                'jadwal_sempro.jam as jam',
                'jadwal_sempro.tempat as tempat',
                'jadwal_sempro.ket as ket',
                'semester.semester as semester',
                'semester.tahun as tahun',
                'hasil_sempro.*'
            )
            ->orderByRaw('hasil_sempro.id DESC')
            ->get();
        return view('admin.proposal.hasil.read', compact('data', 'user'));
    }

    public function viewHasilSemproFilter($id)
    {
        if ($id == 0) {
            $data = DB::table('hasil_sempro')
                ->join('mahasiswa', 'hasil_sempro.nim', '=', 'mahasiswa.nim')
                ->join('proposal', 'hasil_sempro.id_proposal', '=', 'proposal.id')
                ->join('jadwal_sempro', 'hasil_sempro.id_jadwal_sempro', '=', 'jadwal_sempro.id')
                ->join('plot_dosbing', 'proposal.id_plot_dosbing', '=', 'plot_dosbing.id')
                ->join('semester', 'hasil_sempro.id_semester', '=', 'semester.id')
                ->select(
                    'hasil_sempro.id as id',
                    'hasil_sempro.nim as nim',
                    'mahasiswa.name as nama',
                    'proposal.judul as judul',
                    'jadwal_sempro.status1 as status1',
                    'jadwal_sempro.status2 as status2',
                    'hasil_sempro.berita_acara as berita_acara',
                    'jadwal_sempro.tanggal as tanggal',
                    'jadwal_sempro.jam as jam',
                    'jadwal_sempro.tempat as tempat',
                    'jadwal_sempro.ket as ket',
                    'semester.semester as semester',
                    'semester.tahun as tahun',
                    'hasil_sempro.*'
                )
                ->orderByRaw('hasil_sempro.id DESC')
                ->get();
        } else {
            $data = DB::table('hasil_sempro')
                ->join('mahasiswa', 'hasil_sempro.nim', '=', 'mahasiswa.nim')
                ->join('proposal', 'hasil_sempro.id_proposal', '=', 'proposal.id')
                ->join('jadwal_sempro', 'hasil_sempro.id_jadwal_sempro', '=', 'jadwal_sempro.id')
                ->join('plot_dosbing', 'proposal.id_plot_dosbing', '=', 'plot_dosbing.id')
                ->join('semester', 'hasil_sempro.id_semester', '=', 'semester.id')
                ->select(
                    'hasil_sempro.id as id',
                    'hasil_sempro.nim as nim',
                    'mahasiswa.name as nama',
                    'proposal.judul as judul',
                    'jadwal_sempro.status1 as status1',
                    'jadwal_sempro.status2 as status2',
                    'hasil_sempro.berita_acara as berita_acara',
                    'jadwal_sempro.tanggal as tanggal',
                    'jadwal_sempro.jam as jam',
                    'jadwal_sempro.tempat as tempat',
                    'jadwal_sempro.ket as ket',
                    'semester.semester as semester',
                    'semester.tahun as tahun',
                    'hasil_sempro.*'
                )
                ->where('semester.id', $id)
                ->orderByRaw('hasil_sempro.id DESC')
                ->get();
        }

        return $data;
    }



    //Skripsi Monitoring
    public function viewSkripsiMonitoring()
    {
        $user = Auth::user();

        $data = DB::table('status_skripsi')
            ->join('mahasiswa', 'status_skripsi.nim', '=', 'mahasiswa.nim')
            ->join('proposal', 'status_skripsi.id_proposal', '=', 'proposal.id')
            ->join('plot_dosbing', 'proposal.id_plot_dosbing', '=', 'plot_dosbing.id')
            ->join('semester', 'proposal.id_semester', '=', 'semester.id')
            ->select(
                'status_skripsi.id as id',
                'status_skripsi.nim as nim',
                'mahasiswa.name as nama',
                'proposal.judul as judul',
                'semester.semester as semester',
                'semester.tahun as tahun',
                'mahasiswa.status_skripsi as status_skripsi',
                'mahasiswa.status_ujian as status_ujian',
                'plot_dosbing.dosbing1 as dosbing1',
                'plot_dosbing.dosbing2 as dosbing2',
                'mahasiswa.status_bimbingan as status_bimbingan'
            )
            ->orderByRaw('status_skripsi.id DESC')
            ->get();
        // dd($dosbing);
        return view('admin.skripsi.monitoring.read', compact('data', 'user'));
    }


    //Penguji Plotting
    public function viewPengujiPlotting()
    {
        $user = Auth::user();
        $data = DB::table('jadwal_ujian')
            ->join('semester', 'jadwal_ujian.id_semester', '=', 'semester.id')
            ->join('mahasiswa', 'jadwal_ujian.nim', '=', 'mahasiswa.nim')
            ->join('dosen as dos1', 'jadwal_ujian.ketua_penguji', '=', 'dos1.nidn')
            ->join('dosen as dos2', 'jadwal_ujian.anggota_penguji_1', '=', 'dos2.nidn')
            ->join('dosen as dos3', 'jadwal_ujian.anggota_penguji_2', '=', 'dos3.nidn')

            ->join('s1 as s11', 'dos1.gelar1', '=', 's11.id')
            ->leftJoin('s2 as s21', 'dos1.gelar2', '=', 's21.id')
            ->leftJoin('s3 as s31', 'dos1.gelar3', '=', 's31.id')

            ->join('s1 as s12', 'dos2.gelar1', '=', 's12.id')
            ->leftJoin('s2 as s22', 'dos2.gelar2', '=', 's22.id')
            ->leftJoin('s3 as s32', 'dos2.gelar3', '=', 's32.id')

            ->join('s1 as s13', 'dos3.gelar1', '=', 's13.id')
            ->leftJoin('s2 as s23', 'dos3.gelar2', '=', 's23.id')
            ->leftJoin('s3 as s33', 'dos3.gelar3', '=', 's33.id')

            ->select(
                'jadwal_ujian.id as id',
                'semester.semester as semester',
                'semester.tahun as tahun',
                'jadwal_ujian.nim as nim',
                'mahasiswa.name as nama',
                'dos1.name as dosen1',
                'dos2.name as dosen2',
                'dos3.name as dosen3',
                's11.gelar as gelar11',
                's21.gelar as gelar21',
                's31.gelar as gelar31',
                's12.gelar as gelar12',
                's22.gelar as gelar22',
                's32.gelar as gelar32',
                's13.gelar as gelar13',
                's23.gelar as gelar23',
                's33.gelar as gelar33',
                's31.depan as depan1',
                's32.depan as depan2',
                's33.depan as depan3'
            )
            ->orderByRaw('jadwal_ujian.id DESC')
            ->get();

        return view('admin.skripsi.plotting.read', compact('data', 'user'));
    }

    public function plotPengujiImportExcel(Request $request)
    {
        // validasi
        // $this->validate($request, [
        // 	'file' => 'required|mimes:csv,xls,xlsx'
        // ]);

        // menangkap file excel
        $file = $request->file('file');

        // membuat nama file unik
        $nama_file = rand() . $file->getClientOriginalName();

        // upload ke folder file_siswa di dalam folder public
        $file->move('file_excel', $nama_file);

        // import data
        // Excel::import(new PlotPengujiImport, public_path('/file_excel/'.$nama_file));
        $import = new plotPengujiImport;
        $import->import(public_path('/file_excel/' . $nama_file));
        // dd($import->errors());

        if ($import->failures()->isNotEmpty()) {
            return back()->withFailures($import->failures());
        }

        return redirect('admin/skripsi/plotting')->with(['success' => 'Berhasil']);
    }

    public function formPengujiAddSatuMahasiswa()
    {
        $user = Auth::user();
        $smt = DB::table('semester')
            ->where('aktif', 'Y')->first();

        $dosen1 = DB::table('dosen')
            ->join('s1', 'dosen.gelar1', '=', 's1.id')
            ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
            ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
            ->select(
                'dosen.id as id',
                'dosen.nidn as nidn',
                'dosen.name as name',
                's1.gelar as gelar1',
                's2.gelar as gelar2',
                's3.gelar as gelar3',
                's3.depan as depan',
                'dosen.jabatan_fungsional as jabatan',
                'dosen.email as email'
            )
            ->get();
        $dosen2 = DB::table('dosen')
            ->join('s1', 'dosen.gelar1', '=', 's1.id')
            ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
            ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
            ->select(
                'dosen.id as id',
                'dosen.nidn as nidn',
                'dosen.name as name',
                's1.gelar as gelar1',
                's2.gelar as gelar2',
                's3.gelar as gelar3',
                's3.depan as depan',
                'dosen.jabatan_fungsional as jabatan',
                'dosen.email as email'
            )
            ->get();
        $dosen3 = DB::table('dosen')
            ->join('s1', 'dosen.gelar1', '=', 's1.id')
            ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
            ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
            ->select(
                'dosen.id as id',
                'dosen.nidn as nidn',
                'dosen.name as name',
                's1.gelar as gelar1',
                's2.gelar as gelar2',
                's3.gelar as gelar3',
                's3.depan as depan',
                'dosen.jabatan_fungsional as jabatan',
                'dosen.email as email'
            )
            ->get();

        return view('admin.skripsi.plotting.add', compact('smt', 'dosen1', 'dosen2', 'dosen3', 'user'));
    }
    public function insertPengujiSatuMahasiswa(Request $request)
    {
        $cek = PlotPengujiModel::where('nim', $request->nim)->first();

        if ($cek) {
            return back()->with('error', 'Data Mahasiswa ' . $cek->nim . ' sudah ada');
        } else {
            DB::insert('insert into plot_penguji (smt, nim, name, ketua_penguji, anggota_penguji_1, anggota_penguji_2) values (?, ?, ?, ?, ?, ?)', [$request->smt, $request->nim, $request->name, $request->ketua, $request->anggota1, $request->anggota2]);
            return redirect('admin/skripsi/plotting')->with(['success' => 'Berhasil']);
        }
    }

    public function formEditPlotPenguji($id)
    {
        $user = Auth::user();
        $data = DB::table('jadwal_ujian')
            ->where('id', $id)->first();

        $mhs = DB::table('mahasiswa')
            ->where('nim', $data->nim)->first();

        $smt = DB::table('semester')
            ->where('id', $data->id_semester)->first();
        // dd($data->ketua_penguji);

        $dosen1 = DB::table('dosen')
            ->join('s1', 'dosen.gelar1', '=', 's1.id')
            ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
            ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
            ->select(
                'dosen.id as id',
                'dosen.nidn as nidn',
                'dosen.name as name',
                's1.gelar as gelar1',
                's2.gelar as gelar2',
                's3.gelar as gelar3',
                's3.depan as depan',
                'dosen.jabatan_fungsional as jabatan',
                'dosen.email as email'
            )
            ->get();
        $dosen2 = DB::table('dosen')
            ->join('s1', 'dosen.gelar1', '=', 's1.id')
            ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
            ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
            ->select(
                'dosen.id as id',
                'dosen.nidn as nidn',
                'dosen.name as name',
                's1.gelar as gelar1',
                's2.gelar as gelar2',
                's3.gelar as gelar3',
                's3.depan as depan',
                'dosen.jabatan_fungsional as jabatan',
                'dosen.email as email'
            )
            ->get();
        $dosen3 = DB::table('dosen')
            ->join('s1', 'dosen.gelar1', '=', 's1.id')
            ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
            ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
            ->select(
                'dosen.id as id',
                'dosen.nidn as nidn',
                'dosen.name as name',
                's1.gelar as gelar1',
                's2.gelar as gelar2',
                's3.gelar as gelar3',
                's3.depan as depan',
                'dosen.jabatan_fungsional as jabatan',
                'dosen.email as email'
            )
            ->get();

        return view('admin.skripsi.plotting.edit', compact('data', 'dosen1', 'dosen2', 'dosen3', 'user', 'mhs', 'smt'));
    }

    public function updatePlotPenguji(Request $request, $id)
    {
        $ketua = $request->ketua;
        $anggota1 = $request->anggota1;
        $anggota2 = $request->anggota2;

        $data = DB::table('jadwal_ujian')
            ->where('id', $id)
            ->update(
                [
                    'ketua_penguji' => $ketua,
                    'anggota_penguji_1' => $anggota1,
                    'anggota_penguji_2' => $anggota2,
                ]
            );

        return redirect('admin/skripsi/plotting')->with(['success' => 'Berhasil']);
    }


    //Proposal Data Pendaftar
    public function viewSkripsiPendaftar()
    {
        $user = Auth::user();
        $data = DB::table('berkas_ujian')
            ->join('mahasiswa', 'berkas_ujian.nim', '=', 'mahasiswa.nim')
            ->join('proposal', 'berkas_ujian.id_proposal', '=', 'proposal.id')
            ->join('semester', 'berkas_ujian.id_semester', '=', 'semester.id')
            ->select(
                'berkas_ujian.id as id',
                'berkas_ujian.nim as nim',
                'mahasiswa.name as nama',
                'berkas_ujian.*',
                'berkas_ujian.status as status',
                'berkas_ujian.komentar_admin as komentar',
                'berkas_ujian.created_at as tgl_daftar',
                'semester.semester as semester',
                'semester.tahun as tahun'
            )
            ->where('berkas_ujian.status', 'Menunggu Verifikasi')
            ->orderByRaw('berkas_ujian.id DESC')
            ->get();
        return view('admin.skripsi.pendaftar.read', compact('data', 'user'));
    }

    //berkasok
    public function berkasUjianOk($id)
    {
        $user = Auth::user();

        $data = DB::table('berkas_ujian')
            ->where('id', $id)
            ->update(
                ['status' => 'Berkas OK']
            );

        return redirect('admin/skripsi/penjadwalan');
    }

    //berkaskurang
    public function berkasUjianKurang(Request $request, $id)
    {
        $user = Auth::user();

        $data = DB::table('berkas_ujian')
            ->where('id', $id)
            ->update(
                [
                    'status' => 'Berkas tidak lengkap',
                    'komentar_admin' => $request->komentar_admin
                ]
            );

        return redirect('admin/skripsi/pendaftar');
    }

    public function exportBerkasUjian()
    {
        return Excel::download(new PendaftarUjianExport, 'Pendaftar Ujian Berkas OK.xlsx');
    }

    // public function penjadwalanUjianImportExcel(Request $request)
    // {
    //     // validasi
    //     $request->validate([
    //         'nim' => 'required|exists:mahasiswa,nim',
    //         'id_berkas_ujian' => 'required|integer',
    //         'id_semester' => 'required|integer',
    //         'tanggal' => 'required|date',
    //         'jam' => 'required|date_format:H:i',
    //         'tempat' => 'required|string|max:255',
    //         'ket' => 'nullable|string|max:500',
    //         'ketua_penguji' => 'required|exists:dosen,id',
    //         'anggota_penguji_1' => 'required|exists:dosen,id|different:ketua_penguji',
    //         'anggota_penguji_2' => 'required|exists:dosen,id|different:ketua_penguji|different:anggota_penguji_1',
    //     ], [
    //         'nim.required' => 'NIM wajib diisi.',
    //         'nim.exists' => 'NIM tidak terdaftar dalam data mahasiswa.',

    //         'id_berkas_ujian.required' => 'Berkas ujian wajib diisi.',
    //         'id_berkas_ujian.integer' => 'ID berkas ujian harus berupa angka.',

    //         'id_semester.required' => 'Semester wajib diisi.',
    //         'id_semester.integer' => 'ID semester harus berupa angka.',

    //         'tanggal.required' => 'Tanggal wajib diisi.',
    //         'tanggal.date' => 'Format tanggal tidak valid.',

    //         'jam.required' => 'Jam wajib diisi.',
    //         'jam.date_format' => 'Format jam harus dalam format HH:MM (contoh: 13:00).',

    //         'tempat.required' => 'Tempat ujian wajib diisi.',
    //         'tempat.string' => 'Tempat harus berupa teks.',
    //         'tempat.max' => 'Tempat maksimal 255 karakter.',

    //         'ket.string' => 'Keterangan harus berupa teks.',
    //         'ket.max' => 'Keterangan maksimal 500 karakter.',

    //         'ketua_penguji.required' => 'Ketua penguji wajib dipilih.',
    //         'ketua_penguji.exists' => 'Ketua penguji tidak terdaftar.',

    //         'anggota_penguji_1.required' => 'Anggota penguji 1 wajib dipilih.',
    //         'anggota_penguji_1.exists' => 'Anggota penguji 1 tidak terdaftar.',
    //         'anggota_penguji_1.different' => 'Anggota penguji 1 tidak boleh sama dengan ketua penguji.',

    //         'anggota_penguji_2.required' => 'Anggota penguji 2 wajib dipilih.',
    //         'anggota_penguji_2.exists' => 'Anggota penguji 2 tidak terdaftar.',
    //         'anggota_penguji_2.different' => 'Anggota penguji 2 harus berbeda dari ketua dan anggota penguji 1.',
    //     ]);

    //     // menangkap file excel
    //     $file = $request->file('file');

    //     // membuat nama file unik
    //     $nama_file = rand() . $file->getClientOriginalName();

    //     // upload ke folder file_siswa di dalam folder public
    //     $file->move('file_excel', $nama_file);

    //     // import data
    //     Excel::import(new PendaftarUjianImport, public_path('/file_excel/' . $nama_file));
    //     Excel::import(new HasilUjianImport, public_path('/file_excel/' . $nama_file));

    //     $data = DB::table('berkas_ujian')
    //         ->where('status', 'Berkas OK')
    //         ->update(
    //             [
    //                 'status' => 'Terjadwal',
    //                 'komentar_admin' => 'Terjadwal'
    //             ]
    //         );

    //     return redirect('admin/skripsi/penjadwalan')->with(['success' => 'Berhasil']);
    // }

    public function penjadwalanUjianImportExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        $file = $request->file('file');
        $nama_file = rand() . $file->getClientOriginalName();
        $file->move('file_excel', $nama_file);

        try {
            Excel::import(new PendaftarUjianImport, public_path('/file_excel/' . $nama_file));
            Excel::import(new HasilUjianImport, public_path('/file_excel/' . $nama_file));

            DB::table('berkas_ujian')
                ->where('status', 'Berkas OK')
                ->update([
                    'status' => 'Terjadwal',
                    'komentar_admin' => 'Terjadwal'
                ]);

            return redirect('admin/skripsi/penjadwalan')->with(['success' => 'Import berhasil.']);
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();

            $errorMessages = [];
            foreach ($failures as $failure) {
                $errorMessages[] = 'Baris ' . $failure->row() . ': ' . implode(', ', $failure->errors());
            }

            return redirect()->back()->with('import_errors', $errorMessages);
        }
    }


    public function viewSkripsiPendaftarCekBerkas($id)
    {
        $user = Auth::user();
        $data = DB::table('berkas_ujian')
            ->join('mahasiswa', 'berkas_ujian.nim', '=', 'mahasiswa.nim')
            // ->join('plot_penguji', 'berkas_ujian.id_plot_penguji', '=', 'plot_penguji.id')
            ->join('proposal', 'berkas_ujian.id_proposal', '=', 'proposal.id')
            ->join('plot_dosbing', 'proposal.id_plot_dosbing', '=', 'plot_dosbing.id')
            ->select(
                'berkas_ujian.id as id',
                'berkas_ujian.nim as nim',
                'mahasiswa.name as nama',
                'mahasiswa.hp as hp',
                'mahasiswa.email as email',
                'proposal.judul as judul',
                'proposal.id as id_proposal',
                'berkas_ujian.*',
                'berkas_ujian.created_at as tgl_daftar',
                'plot_dosbing.dosbing1 as dosbing1',
                'plot_dosbing.dosbing2 as dosbing2'
            )
            ->where('berkas_ujian.id', $id)
            ->get();
        $dosen1 = DB::table('dosen')
            ->join('s1', 'dosen.gelar1', '=', 's1.id')
            ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
            ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
            ->select(
                'dosen.id as id',
                'dosen.nidn as nidn',
                'dosen.name as name',
                's1.gelar as gelar1',
                's2.gelar as gelar2',
                's3.gelar as gelar3',
                's3.depan as depan',
                'dosen.jabatan_fungsional as jabatan',
                'dosen.email as email'
            )
            ->where('nidn', $data[0]->dosbing1)->first();
        $dosen2 = DB::table('dosen')
            ->join('s1', 'dosen.gelar1', '=', 's1.id')
            ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
            ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
            ->select(
                'dosen.id as id',
                'dosen.nidn as nidn',
                'dosen.name as name',
                's1.gelar as gelar1',
                's2.gelar as gelar2',
                's3.gelar as gelar3',
                's3.depan as depan',
                'dosen.jabatan_fungsional as jabatan',
                'dosen.email as email'
            )
            ->where('nidn', $data[0]->dosbing2)->first();

        // $datapenguji = DB::table('plot_penguji')->where('nim', 201851060)->orderByRaw('id DESC')->first();

        $ketua = DB::table('dosen')
            ->join('s1', 'dosen.gelar1', '=', 's1.id')
            ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
            ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
            ->select(
                'dosen.id as id',
                'dosen.nidn as nidn',
                'dosen.name as name',
                's1.gelar as gelar1',
                's2.gelar as gelar2',
                's3.gelar as gelar3',
                's3.depan as depan',
                'dosen.jabatan_fungsional as jabatan',
                'dosen.email as email'
            )
            ->get();
        $anggota1 = DB::table('dosen')
            ->join('s1', 'dosen.gelar1', '=', 's1.id')
            ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
            ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
            ->select(
                'dosen.id as id',
                'dosen.nidn as nidn',
                'dosen.name as name',
                's1.gelar as gelar1',
                's2.gelar as gelar2',
                's3.gelar as gelar3',
                's3.depan as depan',
                'dosen.jabatan_fungsional as jabatan',
                'dosen.email as email'
            )
            ->get();
        $anggota2 = DB::table('dosen')
            ->join('s1', 'dosen.gelar1', '=', 's1.id')
            ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
            ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
            ->select(
                'dosen.id as id',
                'dosen.nidn as nidn',
                'dosen.name as name',
                's1.gelar as gelar1',
                's2.gelar as gelar2',
                's3.gelar as gelar3',
                's3.depan as depan',
                'dosen.jabatan_fungsional as jabatan',
                'dosen.email as email'
            )
            ->get();

        // $path = public_path('filemhs/' . $data[0]->nim . '/berkas_ujian/extract');
        // $allFiles = scandir($path);
        // $files = array_diff($allFiles, array('.', '..'));

        $file = null;

        $path = public_path('filemhs' . DIRECTORY_SEPARATOR . $data[0]->nim . DIRECTORY_SEPARATOR . 'berkas_ujian');
        $filePath = $path . DIRECTORY_SEPARATOR . $data[0]->berkas_ujian;

        if (File::exists($filePath)) {
            $file = $data[0]->berkas_ujian;
        }

        return view('admin.skripsi.pendaftar.detailberkas', compact('data', 'user', 'dosen1', 'dosen2', 'ketua', 'anggota1', 'anggota2', 'file'));
    }

    public function viewSkripsiPendaftarDetail($id)
    {
        $user = Auth::user();
        $data = DB::table('berkas_ujian')
            ->join('mahasiswa', 'berkas_ujian.nim', '=', 'mahasiswa.nim')
            // ->join('plot_penguji', 'berkas_ujian.id_plot_penguji', '=', 'plot_penguji.id')
            ->join('proposal', 'berkas_ujian.id_proposal', '=', 'proposal.id')
            ->join('plot_dosbing', 'proposal.id_plot_dosbing', '=', 'plot_dosbing.id')
            ->select(
                'berkas_ujian.id as id',
                'berkas_ujian.nim as nim',
                'mahasiswa.name as nama',
                'mahasiswa.hp as hp',
                'mahasiswa.email as email',
                'proposal.judul as judul',
                'proposal.id as id_proposal',
                'berkas_ujian.created_at as tgl_daftar',
                'plot_dosbing.dosbing1 as dosbing1',
                'plot_dosbing.dosbing2 as dosbing2'
            )
            ->where('berkas_ujian.id', $id)
            ->get();
        $dosen1 = DB::table('dosen')
            ->join('s1', 'dosen.gelar1', '=', 's1.id')
            ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
            ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
            ->select(
                'dosen.id as id',
                'dosen.nidn as nidn',
                'dosen.name as name',
                's1.gelar as gelar1',
                's2.gelar as gelar2',
                's3.gelar as gelar3',
                's3.depan as depan',
                'dosen.jabatan_fungsional as jabatan',
                'dosen.email as email'
            )
            ->where('nidn', $data[0]->dosbing1)->first();
        $dosen2 = DB::table('dosen')
            ->join('s1', 'dosen.gelar1', '=', 's1.id')
            ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
            ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
            ->select(
                'dosen.id as id',
                'dosen.nidn as nidn',
                'dosen.name as name',
                's1.gelar as gelar1',
                's2.gelar as gelar2',
                's3.gelar as gelar3',
                's3.depan as depan',
                'dosen.jabatan_fungsional as jabatan',
                'dosen.email as email'
            )
            ->where('nidn', $data[0]->dosbing2)->first();

        // $datapenguji = DB::table('plot_penguji')->where('nim', 201851060)->orderByRaw('id DESC')->first();

        $ketua = DB::table('dosen')
            ->join('s1', 'dosen.gelar1', '=', 's1.id')
            ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
            ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
            ->select(
                'dosen.id as id',
                'dosen.nidn as nidn',
                'dosen.name as name',
                's1.gelar as gelar1',
                's2.gelar as gelar2',
                's3.gelar as gelar3',
                's3.depan as depan',
                'dosen.jabatan_fungsional as jabatan',
                'dosen.email as email'
            )
            ->get();
        $anggota1 = DB::table('dosen')
            ->join('s1', 'dosen.gelar1', '=', 's1.id')
            ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
            ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
            ->select(
                'dosen.id as id',
                'dosen.nidn as nidn',
                'dosen.name as name',
                's1.gelar as gelar1',
                's2.gelar as gelar2',
                's3.gelar as gelar3',
                's3.depan as depan',
                'dosen.jabatan_fungsional as jabatan',
                'dosen.email as email'
            )
            ->get();
        $anggota2 = DB::table('dosen')
            ->join('s1', 'dosen.gelar1', '=', 's1.id')
            ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
            ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
            ->select(
                'dosen.id as id',
                'dosen.nidn as nidn',
                'dosen.name as name',
                's1.gelar as gelar1',
                's2.gelar as gelar2',
                's3.gelar as gelar3',
                's3.depan as depan',
                'dosen.jabatan_fungsional as jabatan',
                'dosen.email as email'
            )
            ->get();
        return view('admin.skripsi.pendaftar.detail', compact('data', 'user', 'dosen1', 'dosen2', 'ketua', 'anggota1', 'anggota2'));
    }

    public function insertJadwalUjian(Request $request)
    {
        // dd($request);
        $this->validate(
            $request,
            [
                'nim' => 'required|exists:mahasiswa,nim',
                'tempat' => 'required|string|max:255',
                'ket' => 'required|string|max:500',
                'tanggal' => 'required|date',
                'jam' => 'required|date_format:H:i',
                'ketua' => 'required|exists:dosen,nidn',
                'anggota1' => 'required|exists:dosen,nidn|different:7',
                'anggota2' => 'required|exists:dosen,nidn|different:7|different:8',
            ],
            [
                'nim.required' => 'NIM wajib diisi.',
                'nim.exists' => 'NIM tidak ditemukan di tabel mahasiswa.',

                'tanggal.required' => 'Tanggal wajib diisi.',
                'tanggal.date' => 'Format tanggal tidak valid.',

                'jam.required' => 'Jam wajib diisi.',
                'jam.date_format' => 'Format jam harus dalam format HH:MM (contoh: 13:00).',

                'tempat.required' => 'Tempat ujian wajib diisi.',
                'tempat.string' => 'Tempat harus berupa teks.',
                'tempat.max' => 'Tempat maksimal 255 karakter.',

                'ket.strrequireding' => 'Keterangan wajib diisi.',
                'ket.string' => 'Keterangan harus berupa teks.',
                'ket.max' => 'Keterangan maksimal 500 karakter.',

                'ketua.required' => 'Ketua penguji wajib dipilih.',
                'ketua.exists' => 'Ketua penguji tidak terdaftar.',

                'anggota1.required' => 'Anggota penguji 1 wajib dipilih.',
                'anggota1.exists' => 'Anggota penguji 1 tidak terdaftar.',
                'anggota1.different' => 'Anggota penguji 1 tidak boleh sama dengan ketua penguji.',

                'anggota2.required' => 'Anggota penguji 2 wajib dipilih.',
                'anggota2.exists' => 'Anggota penguji 2 tidak terdaftar.',
                'anggota2.different' => 'Anggota penguji 2 harus berbeda dari ketua dan anggota penguji 1.',


            ]
        );

        $smt = SemesterModel::all()->where('aktif', 'Y')->first();

        $jsModel = new JadwalUjianModel;

        $jsModel->nim = $request->nim;
        $jsModel->id_semester = $smt->id;
        $jsModel->id_berkas_ujian = $request->id_berkas_ujian;
        $jsModel->tanggal = $request->tanggal;
        $jsModel->jam = $request->jam;
        $jsModel->tempat = $request->tempat;
        $jsModel->ket = $request->ket;
        $jsModel->created_at = Carbon::now();
        $jsModel->updated_at = Carbon::now();

        $jsModel->ketua_penguji = $request->ketua;
        $jsModel->anggota_penguji_1 = $request->anggota1;
        $jsModel->anggota_penguji_2 = $request->anggota2;

        $jsModel->save();

        $data = DB::table('berkas_ujian')
            ->where('id', $request->id_berkas_ujian)
            ->update(
                [
                    'status' => 'Terjadwal',
                    'komentar_admin' => 'Terjadwal'
                ]
            );

        $huModel = new HasilUjianModel;
        $huModel->id_semester = $smt->id;
        $huModel->nim = $request->nim;
        $huModel->id_proposal = $request->id_proposal;
        $huModel->save();

        return redirect('admin/skripsi/penjadwalan')->with(['success' => 'Berhasil']);
    }


    //Ujian Skripsi Data Penjadwalan
    public function viewSkripsiPenjadwalan()
    {
        $user = Auth::user();
        // $data = DB::table('jadwal_ujian')
        // ->join('mahasiswa', 'jadwal_ujian.nim', '=', 'mahasiswa.nim')
        // ->join('berkas_ujian', 'jadwal_ujian.id_berkas_ujian', '=', 'berkas_ujian.id')
        // ->join('proposal', 'berkas_ujian.id_proposal', '=', 'proposal.id')
        // ->join('plot_penguji', 'berkas_ujian.id_plot_penguji', '=', 'plot_penguji.id')
        // ->join('plot_dosbing', 'proposal.id_plot_dosbing', '=', 'plot_dosbing.id')
        // ->join('semester', 'proposal.id_semester', '=', 'semester.id')

        // ->join('dosen as dos1', 'plot_dosbing.dosbing1', '=', 'dos1.nidn')
        // ->join('dosen as dos2', 'plot_dosbing.dosbing2', '=', 'dos2.nidn')

        // ->join('dosen as dos3', 'plot_penguji.ketua_penguji', '=', 'dos3.nidn')
        // ->join('dosen as dos4', 'jadwal_ujian.anggota_penguji_1', '=', 'dos4.nidn')
        // ->join('dosen as dos5', 'jadwal_ujian.anggota_penguji_2', '=', 'dos5.nidn')

        // ->join('s1 as s11', 'dos1.gelar1', '=', 's11.id')
        // ->leftJoin('s2 as s21', 'dos1.gelar2', '=', 's21.id')
        // ->leftJoin('s3 as s31', 'dos1.gelar3', '=', 's31.id')

        // ->join('s1 as s12', 'dos2.gelar1', '=', 's12.id')
        // ->leftJoin('s2 as s22', 'dos2.gelar2', '=', 's22.id')
        // ->leftJoin('s3 as s32', 'dos2.gelar3', '=', 's32.id')

        // ->join('s1 as s13', 'dos3.gelar1', '=', 's13.id')
        // ->leftJoin('s2 as s23', 'dos3.gelar2', '=', 's23.id')
        // ->leftJoin('s3 as s33', 'dos3.gelar3', '=', 's33.id')

        // ->join('s1 as s14', 'dos4.gelar1', '=', 's14.id')
        // ->leftJoin('s2 as s24', 'dos4.gelar2', '=', 's24.id')
        // ->leftJoin('s3 as s34', 'dos4.gelar3', '=', 's34.id')

        // ->join('s1 as s15', 'dos5.gelar1', '=', 's15.id')
        // ->leftJoin('s2 as s25', 'dos5.gelar2', '=', 's25.id')
        // ->leftJoin('s3 as s35', 'dos5.gelar3', '=', 's35.id')

        // ->select('jadwal_ujian.id as id', 'jadwal_ujian.nim as nim', 'mahasiswa.name as nama', 'berkas_ujian.id as id_berkas_ujian', 'proposal.judul as judul',
        // 'plot_dosbing.dosbing1 as dosbing1', 'plot_dosbing.dosbing2 as dosbing2' ,'jadwal_ujian.tanggal as tanggal', 'semester.semester as semester', 'semester.tahun as tahun',
        // 'jadwal_ujian.jam as jam', 'jadwal_ujian.tempat as tempat', 'jadwal_ujian.ket as ket', 'jadwal_ujian.status1 as status1', 'jadwal_ujian.status2 as status2',
        // 'dos1.name as dosbing1', 'dos2.name as dosbing2', 's11.gelar as gelar11', 's21.gelar as gelar21', 's31.gelar as gelar31',
        // 's12.gelar as gelar12', 's22.gelar as gelar22', 's32.gelar as gelar32',
        // 'dos3.name as ketua', 'dos4.name as anggota1', 'dos5.name as anggota2',
        // 's11.gelar as gelar13', 's21.gelar as gelar23', 's31.gelar as gelar33',
        // 's11.gelar as gelar14', 's21.gelar as gelar24', 's31.gelar as gelar34',
        // 's11.gelar as gelar15', 's21.gelar as gelar25', 's31.gelar as gelar35')
        // ->orderByRaw('jadwal_ujian.id DESC')
        // ->get();

        // $data = DB::table('hasil_ujian')
        // ->join('mahasiswa', 'hasil_ujian.nim', '=', 'mahasiswa.nim')
        // ->join('proposal', 'hasil_ujian.id_proposal', '=', 'proposal.id')
        // ->join('jadwal_ujian', 'hasil_ujian.id_jadwal_ujian', '=', 'jadwal_ujian.id')
        // ->join('berkas_ujian', 'jadwal_ujian.id_berkas_ujian', '=', 'berkas_ujian.id')
        // ->join('plot_penguji', 'berkas_ujian.id_plot_penguji', '=', 'plot_penguji.id')
        // ->join('plot_dosbing', 'proposal.id_plot_dosbing', '=', 'plot_dosbing.id')
        // ->join('semester', 'proposal.id_semester', '=', 'semester.id')
        // ->select('jadwal_ujian.id as id', 'hasil_ujian.nim as nim','semester.semester as semester', 'semester.tahun as tahun', 'mahasiswa.name as nama', 'proposal.judul as judul', 'jadwal_ujian.status1 as status1', 'jadwal_ujian.status2 as status2', 'hasil_ujian.berita_acara as berita_acara',
        // 'jadwal_ujian.tanggal as tanggal', 'jadwal_ujian.jam as jam', 'jadwal_ujian.tempat as tempat', 'jadwal_ujian.ket as ket',)
        // ->get();

        $data = DB::table('berkas_ujian')
            ->join('mahasiswa', 'berkas_ujian.nim', '=', 'mahasiswa.nim')
            ->join('proposal', 'berkas_ujian.id_proposal', '=', 'proposal.id')
            ->join('plot_dosbing', 'proposal.id_plot_dosbing', '=', 'plot_dosbing.id')
            ->join('semester', 'berkas_ujian.id_semester', '=', 'semester.id')

            ->join('dosen as dos1', 'plot_dosbing.dosbing1', '=', 'dos1.nidn')
            ->leftJoin('dosen as dos2', 'plot_dosbing.dosbing2', '=', 'dos2.nidn')

            ->join('s1 as s11', 'dos1.gelar1', '=', 's11.id')
            ->leftJoin('s2 as s21', 'dos1.gelar2', '=', 's21.id')
            ->leftJoin('s3 as s31', 'dos1.gelar3', '=', 's31.id')

            ->leftJoin('s1 as s12', 'dos2.gelar1', '=', 's12.id')
            ->leftJoin('s2 as s22', 'dos2.gelar2', '=', 's22.id')
            ->leftJoin('s3 as s32', 'dos2.gelar3', '=', 's32.id')

            ->select(
                'berkas_ujian.id as id',
                'berkas_ujian.nim as nim',
                'mahasiswa.name as nama',
                'proposal.judul as judul',
                'plot_dosbing.dosbing1 as dosbing1',
                'plot_dosbing.dosbing2 as dosbing2',
                'semester.semester as semester',
                'semester.tahun as tahun',
                'berkas_ujian.status as status',
                'dos1.name as dosbing1',
                'dos2.name as dosbing2',
                's11.gelar as gelar11',
                's21.gelar as gelar21',
                's31.gelar as gelar31',
                's12.gelar as gelar12',
                's22.gelar as gelar22',
                's32.gelar as gelar32',
            )
            ->where('status', 'Berkas OK')
            ->orWhere('status', 'Terjadwal')
            ->orderByRaw('berkas_ujian.id DESC')
            ->get();

        return view('admin.skripsi.penjadwalan.read', compact('data', 'user'));
    }

    //filtering
    public function viewSkripsiPenjadwalanFilter($id)
    {
        $user = Auth::user();

        if ($id == 1) {
            $data = DB::table('berkas_ujian')
                ->join('mahasiswa', 'berkas_ujian.nim', '=', 'mahasiswa.nim')
                ->join('proposal', 'berkas_ujian.id_proposal', '=', 'proposal.id')
                // ->join('plot_penguji', 'berkas_ujian.id_plot_penguji', '=', 'plot_penguji.id')
                ->join('plot_dosbing', 'proposal.id_plot_dosbing', '=', 'plot_dosbing.id')
                ->join('semester', 'berkas_ujian.id_semester', '=', 'semester.id')

                ->join('dosen as dos1', 'plot_dosbing.dosbing1', '=', 'dos1.nidn')
                ->join('dosen as dos2', 'plot_dosbing.dosbing2', '=', 'dos2.nidn')

                ->join('s1 as s11', 'dos1.gelar1', '=', 's11.id')
                ->leftJoin('s2 as s21', 'dos1.gelar2', '=', 's21.id')
                ->leftJoin('s3 as s31', 'dos1.gelar3', '=', 's31.id')

                ->join('s1 as s12', 'dos2.gelar1', '=', 's12.id')
                ->leftJoin('s2 as s22', 'dos2.gelar2', '=', 's22.id')
                ->leftJoin('s3 as s32', 'dos2.gelar3', '=', 's32.id')

                ->select(
                    'berkas_ujian.id as id',
                    'berkas_ujian.nim as nim',
                    'mahasiswa.name as nama',
                    'proposal.judul as judul',
                    'plot_dosbing.dosbing1 as dosbing1',
                    'plot_dosbing.dosbing2 as dosbing2',
                    'semester.semester as semester',
                    'semester.tahun as tahun',
                    'berkas_ujian.status as status',
                    'dos1.name as dosbing1',
                    'dos2.name as dosbing2',
                    's11.gelar as gelar11',
                    's21.gelar as gelar21',
                    's31.gelar as gelar31',
                    's12.gelar as gelar12',
                    's22.gelar as gelar22',
                    's32.gelar as gelar32',
                )
                ->where('status', 'Berkas OK')
                ->orderByRaw('berkas_ujian.id DESC')
                ->get();
        } else if ($id == 2) {
            $data = DB::table('berkas_ujian')
                ->join('mahasiswa', 'berkas_ujian.nim', '=', 'mahasiswa.nim')
                ->join('proposal', 'berkas_ujian.id_proposal', '=', 'proposal.id')
                // ->join('plot_penguji', 'berkas_ujian.id_plot_penguji', '=', 'plot_penguji.id')
                ->join('plot_dosbing', 'proposal.id_plot_dosbing', '=', 'plot_dosbing.id')
                ->join('semester', 'berkas_ujian.id_semester', '=', 'semester.id')

                ->join('dosen as dos1', 'plot_dosbing.dosbing1', '=', 'dos1.nidn')
                ->join('dosen as dos2', 'plot_dosbing.dosbing2', '=', 'dos2.nidn')

                ->join('s1 as s11', 'dos1.gelar1', '=', 's11.id')
                ->leftJoin('s2 as s21', 'dos1.gelar2', '=', 's21.id')
                ->leftJoin('s3 as s31', 'dos1.gelar3', '=', 's31.id')

                ->join('s1 as s12', 'dos2.gelar1', '=', 's12.id')
                ->leftJoin('s2 as s22', 'dos2.gelar2', '=', 's22.id')
                ->leftJoin('s3 as s32', 'dos2.gelar3', '=', 's32.id')

                ->select(
                    'berkas_ujian.id as id',
                    'berkas_ujian.nim as nim',
                    'mahasiswa.name as nama',
                    'proposal.judul as judul',
                    'plot_dosbing.dosbing1 as dosbing1',
                    'plot_dosbing.dosbing2 as dosbing2',
                    'semester.semester as semester',
                    'semester.tahun as tahun',
                    'berkas_ujian.status as status',
                    'dos1.name as dosbing1',
                    'dos2.name as dosbing2',
                    's11.gelar as gelar11',
                    's21.gelar as gelar21',
                    's31.gelar as gelar31',
                    's12.gelar as gelar12',
                    's22.gelar as gelar22',
                    's32.gelar as gelar32',
                )
                ->where('status', 'Terjadwal')
                ->orderByRaw('berkas_ujian.id DESC')
                ->get();
        } else if ($id == 3) {
            $data = DB::table('berkas_ujian')
                ->join('mahasiswa', 'berkas_ujian.nim', '=', 'mahasiswa.nim')
                ->join('proposal', 'berkas_ujian.id_proposal', '=', 'proposal.id')
                // ->join('plot_penguji', 'berkas_ujian.id_plot_penguji', '=', 'plot_penguji.id')
                ->join('plot_dosbing', 'proposal.id_plot_dosbing', '=', 'plot_dosbing.id')
                ->join('semester', 'berkas_ujian.id_semester', '=', 'semester.id')

                ->join('dosen as dos1', 'plot_dosbing.dosbing1', '=', 'dos1.nidn')
                ->join('dosen as dos2', 'plot_dosbing.dosbing2', '=', 'dos2.nidn')

                ->join('s1 as s11', 'dos1.gelar1', '=', 's11.id')
                ->leftJoin('s2 as s21', 'dos1.gelar2', '=', 's21.id')
                ->leftJoin('s3 as s31', 'dos1.gelar3', '=', 's31.id')

                ->join('s1 as s12', 'dos2.gelar1', '=', 's12.id')
                ->leftJoin('s2 as s22', 'dos2.gelar2', '=', 's22.id')
                ->leftJoin('s3 as s32', 'dos2.gelar3', '=', 's32.id')

                ->select(
                    'berkas_ujian.id as id',
                    'berkas_ujian.nim as nim',
                    'mahasiswa.name as nama',
                    'proposal.judul as judul',
                    'plot_dosbing.dosbing1 as dosbing1',
                    'plot_dosbing.dosbing2 as dosbing2',
                    'semester.semester as semester',
                    'semester.tahun as tahun',
                    'berkas_ujian.status as status',
                    'dos1.name as dosbing1',
                    'dos2.name as dosbing2',
                    's11.gelar as gelar11',
                    's21.gelar as gelar21',
                    's31.gelar as gelar31',
                    's12.gelar as gelar12',
                    's22.gelar as gelar22',
                    's32.gelar as gelar32',
                )
                ->where('status', 'Berkas OK')
                ->orWhere('status', 'Terjadwal')
                ->orderByRaw('berkas_ujian.id DESC')
                ->get();
        }
        return $data;
    }

    public function viewDetailJadwalUjian($id)
    {
        $user = Auth::user();
        $data = DB::table('jadwal_ujian')
            ->join('mahasiswa', 'jadwal_ujian.nim', '=', 'mahasiswa.nim')
            ->join('berkas_ujian', 'jadwal_ujian.id_berkas_ujian', '=', 'berkas_ujian.id')
            ->join('proposal', 'berkas_ujian.id_proposal', '=', 'proposal.id')
            // ->join('plot_penguji', 'jadwal_ujian.id_plot_penguji', '=', 'plot_penguji.id')
            ->join('plot_dosbing', 'proposal.id_plot_dosbing', '=', 'plot_dosbing.id')

            ->select(
                'jadwal_ujian.id as id',
                'jadwal_ujian.nim as nim',
                'mahasiswa.name as nama',
                'mahasiswa.hp as hp',
                'mahasiswa.email as email',
                'berkas_ujian.id as id_berkas_ujian',
                'proposal.judul as judul',
                'plot_dosbing.dosbing1 as dosbing1',
                'plot_dosbing.dosbing2 as dosbing2',
                'jadwal_ujian.tanggal as tanggal',
                'berkas_ujian.created_at as tgl_daftar',
                'jadwal_ujian.jam as jam',
                'jadwal_ujian.tempat as tempat',
                'jadwal_ujian.ket as ket',
                'jadwal_ujian.status1 as status1',
                'jadwal_ujian.status2 as status2',
                'jadwal_ujian.status3 as status3',
                'jadwal_ujian.ketua_penguji as ketua_penguji',
                'jadwal_ujian.anggota_penguji_1 as anggota_penguji_1',
                'jadwal_ujian.anggota_penguji_2 as anggota_penguji_2',
            )
            ->where('jadwal_ujian.id_berkas_ujian', $id)
            ->get();

        // dd($data);

        $dosen1 = DB::table('dosen')
            ->join('s1', 'dosen.gelar1', '=', 's1.id')
            ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
            ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
            ->select(
                'dosen.id as id',
                'dosen.nidn as nidn',
                'dosen.name as name',
                's1.gelar as gelar1',
                's2.gelar as gelar2',
                's3.gelar as gelar3',
                's3.depan as depan',
                'dosen.jabatan_fungsional as jabatan',
                'dosen.email as email'
            )
            ->where('nidn', $data[0]->dosbing1)->first();
        $dosen2 = DB::table('dosen')
            ->join('s1', 'dosen.gelar1', '=', 's1.id')
            ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
            ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
            ->select(
                'dosen.id as id',
                'dosen.nidn as nidn',
                'dosen.name as name',
                's1.gelar as gelar1',
                's2.gelar as gelar2',
                's3.gelar as gelar3',
                's3.depan as depan',
                'dosen.jabatan_fungsional as jabatan',
                'dosen.email as email'
            )
            ->where('nidn', $data[0]->dosbing2)->first();

        $ketua = DB::table('dosen')
            ->join('s1', 'dosen.gelar1', '=', 's1.id')
            ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
            ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
            ->select(
                'dosen.id as id',
                'dosen.nidn as nidn',
                'dosen.name as name',
                's1.gelar as gelar1',
                's2.gelar as gelar2',
                's3.gelar as gelar3',
                's3.depan as depan',
                'dosen.jabatan_fungsional as jabatan',
                'dosen.email as email'
            )
            ->where('nidn', $data[0]->ketua_penguji)->first();
        $anggota1 = DB::table('dosen')
            ->join('s1', 'dosen.gelar1', '=', 's1.id')
            ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
            ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
            ->select(
                'dosen.id as id',
                'dosen.nidn as nidn',
                'dosen.name as name',
                's1.gelar as gelar1',
                's2.gelar as gelar2',
                's3.gelar as gelar3',
                's3.depan as depan',
                'dosen.jabatan_fungsional as jabatan',
                'dosen.email as email'
            )
            ->where('nidn', $data[0]->anggota_penguji_1)->first();
        $anggota2 = DB::table('dosen')
            ->join('s1', 'dosen.gelar1', '=', 's1.id')
            ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
            ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
            ->select(
                'dosen.id as id',
                'dosen.nidn as nidn',
                'dosen.name as name',
                's1.gelar as gelar1',
                's2.gelar as gelar2',
                's3.gelar as gelar3',
                's3.depan as depan',
                'dosen.jabatan_fungsional as jabatan',
                'dosen.email as email'
            )
            ->where('nidn', $data[0]->anggota_penguji_2)->first();

        $hasil_ujian = DB::table('hasil_ujian')
            ->select('hasil_ujian.id as id')
            ->where('hasil_ujian.nim', $data[0]->nim)
            ->first();
        return view('admin.skripsi.penjadwalan.detail', compact('data', 'user', 'dosen1', 'dosen2', 'ketua', 'anggota1', 'anggota2', 'hasil_ujian'));
    }

    //View Hasil Ujian
    public function viewHasilujian()
    {
        $user = Auth::user();
        $data = DB::table('hasil_ujian')
            ->join('mahasiswa', 'hasil_ujian.nim', '=', 'mahasiswa.nim')
            ->join('proposal', 'hasil_ujian.id_proposal', '=', 'proposal.id')
            ->join('jadwal_ujian', 'hasil_ujian.id_jadwal_ujian', '=', 'jadwal_ujian.id')
            ->join('plot_dosbing', 'proposal.id_plot_dosbing', '=', 'plot_dosbing.id')
            ->join('berkas_ujian', 'jadwal_ujian.id_berkas_ujian', '=', 'berkas_ujian.id')
            ->join('semester', 'hasil_ujian.id_semester', '=', 'semester.id')
            // ->join('plot_penguji', 'berkas_ujian.id_plot_penguji', '=', 'plot_penguji.id')
            ->select(
                'hasil_ujian.id as id',
                'hasil_ujian.nim as nim',
                'mahasiswa.name as nama',
                'proposal.judul as judul',
                'jadwal_ujian.ketua_penguji as ketua_penguji',
                'jadwal_ujian.anggota_penguji_1 as anggota_penguji_1',
                'jadwal_ujian.anggota_penguji_2 as anggota_penguji_2',
                'semester.tahun as tahun',
                'semester.semester as semester',
                'jadwal_ujian.tanggal as tanggal',
                'jadwal_ujian.jam as jam',
                'jadwal_ujian.tempat as tempat',
                'jadwal_ujian.ket as ket',
                'jadwal_ujian.status1 as status1',
                'jadwal_ujian.status2 as status2',
                'jadwal_ujian.status3 as status3',
                'hasil_ujian.berita_acara as berita_acara',
                'hasil_ujian.*'
            )
            ->orderByRaw('hasil_ujian.id DESC')
            ->get();
        return view('admin.skripsi.hasil.read', compact('data', 'user'));
    }

    public function viewHasilujianFilter($id)
    {
        if ($id == 0) {
            $data = DB::table('hasil_ujian')
                ->join('mahasiswa', 'hasil_ujian.nim', '=', 'mahasiswa.nim')
                ->join('proposal', 'hasil_ujian.id_proposal', '=', 'proposal.id')
                ->join('jadwal_ujian', 'hasil_ujian.id_jadwal_ujian', '=', 'jadwal_ujian.id')
                ->join('plot_dosbing', 'proposal.id_plot_dosbing', '=', 'plot_dosbing.id')
                ->join('berkas_ujian', 'jadwal_ujian.id_berkas_ujian', '=', 'berkas_ujian.id')
                ->join('semester', 'hasil_ujian.id_semester', '=', 'semester.id')
                // ->join('plot_penguji', 'berkas_ujian.id_plot_penguji', '=', 'plot_penguji.id')
                ->select(
                    'hasil_ujian.id as id',
                    'semester.semester as semester',
                    'semester.tahun as tahun',
                    'hasil_ujian.nim as nim',
                    'mahasiswa.name as nama',
                    'proposal.judul as judul',
                    'jadwal_ujian.ketua_penguji as ketua_penguji',
                    'jadwal_ujian.anggota_penguji_1 as anggota_penguji_1',
                    'jadwal_ujian.anggota_penguji_2 as anggota_penguji_2',
                    'jadwal_ujian.tanggal as tanggal',
                    'jadwal_ujian.jam as jam',
                    'jadwal_ujian.tempat as tempat',
                    'jadwal_ujian.ket as ket',
                    'jadwal_ujian.status1 as status1',
                    'jadwal_ujian.status2 as status2',
                    'jadwal_ujian.status3 as status3',
                    'hasil_ujian.berita_acara as berita_acara',
                    'hasil_ujian.*'
                )
                ->orderByRaw('hasil_ujian.id DESC')
                ->get();
        } else {
            $data = DB::table('hasil_ujian')
                ->join('mahasiswa', 'hasil_ujian.nim', '=', 'mahasiswa.nim')
                ->join('proposal', 'hasil_ujian.id_proposal', '=', 'proposal.id')
                ->join('jadwal_ujian', 'hasil_ujian.id_jadwal_ujian', '=', 'jadwal_ujian.id')
                ->join('plot_dosbing', 'proposal.id_plot_dosbing', '=', 'plot_dosbing.id')
                ->join('berkas_ujian', 'jadwal_ujian.id_berkas_ujian', '=', 'berkas_ujian.id')
                ->join('semester', 'hasil_ujian.id_semester', '=', 'semester.id')
                // ->join('plot_penguji', 'berkas_ujian.id_plot_penguji', '=', 'plot_penguji.id')
                ->select(
                    'hasil_ujian.id as id',
                    'semester.semester as semester',
                    'semester.tahun as tahun',
                    'hasil_ujian.nim as nim',
                    'mahasiswa.name as nama',
                    'proposal.judul as judul',
                    'jadwal_ujian.ketua_penguji as ketua_penguji',
                    'jadwal_ujian.anggota_penguji_1 as anggota_penguji_1',
                    'jadwal_ujian.anggota_penguji_2 as anggota_penguji_2',
                    'jadwal_ujian.tanggal as tanggal',
                    'jadwal_ujian.jam as jam',
                    'jadwal_ujian.tempat as tempat',
                    'jadwal_ujian.ket as ket',
                    'jadwal_ujian.status1 as status1',
                    'jadwal_ujian.status2 as status2',
                    'jadwal_ujian.status3 as status3',
                    'hasil_ujian.berita_acara as berita_acara',
                    'hasil_ujian.*'
                )
                ->where('semester.id', $id)
                ->orderByRaw('hasil_ujian.id DESC')
                ->get();
        }

        return $data;
    }


    //S1
    public function viewS1()
    {
        $user = Auth::user();
        $data = S1Model::all()->sortByDesc("id");
        return view('admin.dosen.s1.read', compact('data', 'user'));
    }
    public function formAddS1()
    {
        $user = Auth::user();

        return view('admin.dosen.s1.add', compact('user'));
    }
    public function insertS1(Request $request)
    {
        $s1Model = new S1Model;

        $s1Model->gelar = $request->gelar;

        $s1Model->save();

        return redirect('admin/dosen/s1')->with(['success' => 'Berhasil']);
    }
    public function formEditS1($id)
    {
        $user = Auth::user();
        $data = DB::table('s1')
            ->where('s1.id', $id)->first();
        return view('admin.dosen.s1.edit',  compact('data', 'user'));
    }
    public function updateS1(Request $request, $id)
    {
        $gelar = $request->gelar;


        $data = DB::table('s1')
            ->where('id', $id)
            ->update(
                ['gelar' => $gelar]
            );

        return redirect('admin/dosen/s1')->with(['success' => 'Berhasil']);
    }


    //S2
    public function viewS2()
    {
        $user = Auth::user();
        $data = S2Model::all()->sortByDesc("id");
        return view('admin.dosen.s2.read', compact('data', 'user'));
    }
    public function formAddS2()
    {
        $user = Auth::user();

        return view('admin.dosen.s2.add', compact('user'));
    }
    public function insertS2(Request $request)
    {
        $s2Model = new S2Model;

        $s2Model->gelar = $request->gelar;

        $s2Model->save();

        return redirect('admin/dosen/s2')->with(['success' => 'Berhasil']);
    }
    public function formEditS2($id)
    {
        $user = Auth::user();
        $data = DB::table('s2')
            ->where('s2.id', $id)->first();
        return view('admin.dosen.s2.edit',  compact('data', 'user'));
    }
    public function updateS2(Request $request, $id)
    {
        $gelar = $request->gelar;


        $data = DB::table('s2')
            ->where('id', $id)
            ->update(
                ['gelar' => $gelar]
            );

        return redirect('admin/dosen/s2')->with(['success' => 'Berhasil']);
    }


    //S3
    public function viewS3()
    {
        $user = Auth::user();
        $data = S3Model::all()->sortByDesc("id");
        return view('admin.dosen.s3.read', compact('data', 'user'));
    }
    public function formAddS3()
    {
        $user = Auth::user();

        return view('admin.dosen.s3.add', compact('user'));
    }
    public function insertS3(Request $request)
    {
        $s3Model = new S3Model;

        $s3Model->gelar = $request->gelar;
        $s3Model->depan = $request->depan;

        $s3Model->save();

        return redirect('admin/dosen/s3')->with(['success' => 'Berhasil']);
    }
    public function formEditS3($id)
    {
        $user = Auth::user();
        $data = DB::table('s3')
            ->where('s3.id', $id)->first();
        return view('admin.dosen.s3.edit',  compact('data', 'user'));
    }
    public function updateS3(Request $request, $id)
    {
        $gelar = $request->gelar;


        $data = DB::table('s3')
            ->where('id', $id)
            ->update(
                [
                    'gelar' => $gelar,
                    'depan' => $request->depan
                ]
            );

        return redirect('admin/dosen/s3')->with(['success' => 'Berhasil']);
    }


    //Bidang
    public function viewBidang()
    {
        $user = Auth::user();
        $data = BidangModel::all()->sortByDesc("id");
        return view('admin.dosen.bidang.read', compact('data', 'user'));
    }
    public function formAddBidang()
    {
        $user = Auth::user();

        return view('admin.dosen.bidang.add', compact('user'));
    }
    public function insertBidang(Request $request)
    {
        $bidangModel = new BidangModel;

        $bidangModel->nama_bidang = $request->nama_bidang;

        $bidangModel->save();

        return redirect('admin/dosen/bidang')->with(['success' => 'Berhasil']);
    }
    public function formEditBidang($id)
    {
        $user = Auth::user();
        $data = DB::table('bidang')
            ->where('bidang.id', $id)->first();
        return view('admin.dosen.bidang.edit',  compact('data', 'user'));
    }
    public function updateBidang(Request $request, $id)
    {
        $nama_bidang = $request->nama_bidang;


        $data = DB::table('bidang')
            ->where('id', $id)
            ->update(
                ['nama_bidang' => $nama_bidang]
            );

        return redirect('admin/dosen/bidang')->with(['success' => 'Berhasil']);
    }


    //form rekap
    public function viewPembimbingSeminar()
    {
        $user = Auth::user();

        $data = DB::table('semester')->get();
        // $data = DB::table('hasil_sempro')
        // ->join('mahasiswa', 'hasil_sempro.nim', '=', 'mahasiswa.nim')
        // ->leftJoin('proposal', 'hasil_sempro.id_proposal', '=', 'proposal.id')
        // ->join('jadwal_sempro', 'hasil_sempro.id_jadwal_sempro', '=', 'jadwal_sempro.id')
        // ->leftJoin('plot_dosbing', 'proposal.id_plot_dosbing', '=', 'plot_dosbing.id')
        // ->join('semester', 'hasil_sempro.id_semester', '=', 'semester.id')
        // ->select('hasil_sempro.id as id', 'hasil_sempro.nim as nim', 'mahasiswa.name as nama', 'proposal.judul as judul', 'jadwal_sempro.status1 as status1', 'jadwal_sempro.status2 as status2', 'hasil_sempro.berita_acara as berita_acara',
        // 'jadwal_sempro.tanggal as tanggal', 'jadwal_sempro.jam as jam', 'jadwal_sempro.tempat as tempat', 'jadwal_sempro.ket as ket', 'semester.semester as semester', 'semester.tahun as tahun', 'hasil_sempro.*')
        // ->orderByRaw('hasil_sempro.id DESC')
        // ->get();

        // $data = DB::table('dosen')
        // ->join('s1', 'dosen.gelar1', '=', 's1.id')
        // ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
        // ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
        // ->join('bidang', 'dosen.id_bidang', '=', 'bidang.id')
        // ->select('dosen.id as id', 'dosen.nidn as nidn', 'dosen.name as name', 's1.gelar as gelar1', 's2.gelar as gelar2', 's3.gelar as gelar3', 's3.depan as depan',
        // 'dosen.jabatan_fungsional as jabatan', 'bidang.nama_bidang as bidang', 'dosen.email as email')
        // ->orderByRaw('dosen.id DESC')
        // ->get();

        // $data = DB::table('plot_dosbing')
        // ->join('dosen as dos1', 'plot_dosbing.dosbing1', '=', 'dos1.nidn')
        // ->join('dosen as dos2', 'plot_dosbing.dosbing2', '=', 'dos2.nidn')

        // ->join('s1 as s11', 'dos1.gelar1', '=', 's11.id')
        // ->leftJoin('s2 as s21', 'dos1.gelar2', '=', 's21.id')
        // ->leftJoin('s3 as s31', 'dos1.gelar3', '=', 's31.id')

        // ->join('s1 as s12', 'dos2.gelar1', '=', 's12.id')
        // ->leftJoin('s2 as s22', 'dos2.gelar2', '=', 's22.id')
        // ->leftJoin('s3 as s32', 'dos2.gelar3', '=', 's32.id')

        // ->select('plot_dosbing.id as id', 'plot_dosbing.smt as smt', 'plot_dosbing.nim as nim', 'plot_dosbing.name as name',
        // 'dos1.name as dosbing1', 'dos2.name as dosbing2', 's11.gelar as gelar11', 's21.gelar as gelar21', 's31.gelar as gelar31',
        // 's12.gelar as gelar12', 's22.gelar as gelar22', 's32.gelar as gelar32', 's31.depan as depan1', 's32.depan as depan2')
        // ->orderByRaw('plot_dosbing.id DESC')
        // ->get();

        // dd($data);

        return view('admin.rekap.pembimbingseminar.form', compact('data', 'user'));
    }

    public function viewPembimbingSkripsi()
    {
        $user = Auth::user();
        $data = DB::table('semester')->get();

        return view('admin.rekap.pembimbingskripsi.form', compact('data', 'user'));
    }

    public function viewPengujiSkripsi()
    {
        $user = Auth::user();
        $data = DB::table('semester')->get();

        // $data = DB::table('jadwal_ujian')
        //                                     ->join('hasil_ujian', 'hasil_ujian.nim', '=', 'jadwal_ujian.nim')
        //                                     ->select('hasil_ujian.*')
        //                                     ->where('jadwal_ujian.ketua_penguji', '0625028501')
        //                                     ->where('hasil_ujian.id_semester', '2')
        //                                     ->where('hasil_ujian.berita_acara', '!=', 'Menunggu hasil')
        //                                     ->get();
        //                                     dd($data);

        return view('admin.rekap.pengujiskripsi.form', compact('data', 'user'));
    }

    //tampil rekap
    public function tampilPembimbingSeminar(Request $request)
    {
        $user = Auth::user();

        $idsmt = $request->input('idsmt');

        if (empty($idsmt)) {
            return redirect()->back()->with('error', 'Pilih Semester Dahulu');
        }

        $data = DB::table('dosen')
            ->join('s1', 'dosen.gelar1', '=', 's1.id')
            ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
            ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
            ->join('bidang', 'dosen.id_bidang', '=', 'bidang.id')
            ->select(
                'dosen.id as id',
                'dosen.nidn as nidn',
                'dosen.name as name',
                's1.gelar as gelar1',
                's2.gelar as gelar2',
                's3.gelar as gelar3',
                's3.depan as depan',
                'dosen.jabatan_fungsional as jabatan',
                'bidang.nama_bidang as bidang',
                'dosen.email as email'
            )
            ->orderByRaw('dosen.id DESC')
            ->get();

        return view('admin.rekap.pembimbingseminar.read', compact('data', 'user', 'idsmt'));
    }

    public function tampilPembimbingSkripsi(Request $request)
    {
        $user = Auth::user();

        $idsmt = $request->input('idsmt');

        if (empty($idsmt)) {
            return redirect()->back()->with('error', 'Pilih Semester Dahulu');
        }

        $data = DB::table('dosen')
            ->join('s1', 'dosen.gelar1', '=', 's1.id')
            ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
            ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
            ->join('bidang', 'dosen.id_bidang', '=', 'bidang.id')
            ->select(
                'dosen.id as id',
                'dosen.nidn as nidn',
                'dosen.name as name',
                's1.gelar as gelar1',
                's2.gelar as gelar2',
                's3.gelar as gelar3',
                's3.depan as depan',
                'dosen.jabatan_fungsional as jabatan',
                'bidang.nama_bidang as bidang',
                'dosen.email as email'
            )
            ->orderByRaw('dosen.id DESC')
            ->get();

        return view('admin.rekap.pembimbingskripsi.read', compact('data', 'user', 'idsmt'));
    }

    public function tampilPengujiSkripsi(Request $request)
    {
        $user = Auth::user();

        $idsmt = $request->input('idsmt');

        if (empty($idsmt)) {
            return redirect()->back()->with('error', 'Pilih Semester Dahulu');
        }

        $data = DB::table('dosen')
            ->join('s1', 'dosen.gelar1', '=', 's1.id')
            ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
            ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
            ->join('bidang', 'dosen.id_bidang', '=', 'bidang.id')
            ->select(
                'dosen.id as id',
                'dosen.nidn as nidn',
                'dosen.name as name',
                's1.gelar as gelar1',
                's2.gelar as gelar2',
                's3.gelar as gelar3',
                's3.depan as depan',
                'dosen.jabatan_fungsional as jabatan',
                'bidang.nama_bidang as bidang',
                'dosen.email as email'
            )
            ->orderByRaw('dosen.id DESC')
            ->get();

        return view('admin.rekap.pengujiskripsi.read', compact('data', 'user', 'idsmt'));
    }

    //cetak rekap
    public function cetakPembimbingSeminar(Request $request)
    {
        $idsmt = $request->idsmt;
        // $nomor = $request->nomor;
        // $kaprodi = $request->kaprodi;

        $data = DB::table('dosen')
            ->join('s1', 'dosen.gelar1', '=', 's1.id')
            ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
            ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
            ->join('bidang', 'dosen.id_bidang', '=', 'bidang.id')
            ->select(
                'dosen.id as id',
                'dosen.nidn as nidn',
                'dosen.name as name',
                's1.gelar as gelar1',
                's2.gelar as gelar2',
                's3.gelar as gelar3',
                's3.depan as depan',
                'dosen.jabatan_fungsional as jabatan',
                'bidang.nama_bidang as bidang',
                'dosen.email as email'
            )
            ->orderByRaw('dosen.id DESC')
            ->get();

        return view('admin.rekap.pembimbingseminar.pembimbing_seminar_pdf', compact('data', 'idsmt',));
    }

    public function cetakPembimbingSkripsi(Request $request)
    {
        $idsmt = $request->idsmt;
        $nomor = $request->nomor;
        $kaprodi = $request->kaprodi;

        $data = DB::table('dosen')
            ->join('s1', 'dosen.gelar1', '=', 's1.id')
            ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
            ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
            ->join('bidang', 'dosen.id_bidang', '=', 'bidang.id')
            ->select(
                'dosen.id as id',
                'dosen.nidn as nidn',
                'dosen.name as name',
                's1.gelar as gelar1',
                's2.gelar as gelar2',
                's3.gelar as gelar3',
                's3.depan as depan',
                'dosen.jabatan_fungsional as jabatan',
                'bidang.nama_bidang as bidang',
                'dosen.email as email'
            )
            ->orderByRaw('dosen.id DESC')
            ->get();

        return view('admin.rekap.pembimbingskripsi.pembimbing_skripsi_pdf', compact('data', 'idsmt',));
    }

    public function cetakPengujiSkripsi(Request $request)
    {
        $idsmt = $request->idsmt;
        $nomor = $request->nomor;
        $kaprodi = $request->kaprodi;

        $data = DB::table('dosen')
            ->join('s1', 'dosen.gelar1', '=', 's1.id')
            ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
            ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
            ->join('bidang', 'dosen.id_bidang', '=', 'bidang.id')
            ->select(
                'dosen.id as id',
                'dosen.nidn as nidn',
                'dosen.name as name',
                's1.gelar as gelar1',
                's2.gelar as gelar2',
                's3.gelar as gelar3',
                's3.depan as depan',
                'dosen.jabatan_fungsional as jabatan',
                'bidang.nama_bidang as bidang',
                'dosen.email as email'
            )
            ->orderByRaw('dosen.id DESC')
            ->get();

        return view('admin.rekap.pengujiskripsi.penguji_skripsi_pdf', compact('data', 'idsmt',));
    }

    //pengumuman
    public function viewPengumuman()
    {
        $user = Auth::user();
        $data = DB::table('pengumuman')
            ->select('pengumuman.*')
            ->orderByRaw('pengumuman.id DESC')
            ->get();
        // dd($data);
        return view('admin.pengumuman.read', compact('data', 'user'));
    }
    public function formAddPengumuman()
    {
        $user = Auth::user();
        return view('admin.pengumuman.add', compact('user'));
    }
    public function insertPengumuman(Request $request)
    {
        $this->validate(
            $request,
            [
                'judul' => 'required',
                'deskripsi' => 'required',
                'gambar' => 'max:2048',
            ],
            [
                'gambar.max' => 'File terlalu besar, maksimal 2 mb',
            ]
        );

        $gambar = $request->file('gambar');

        $tujuan_upload = 'pengumuman/';

        $namagambar = $gambar->getClientOriginalName();

        $gambar->move($tujuan_upload, $namagambar);

        $pModel = new PengumumanModel;

        $pModel->judul = $request->judul;
        $pModel->deskripsi = $request->deskripsi;
        $pModel->gambar = $namagambar;
        $pModel->created_at = Carbon::now('GMT+7');

        $pModel->save();

        return redirect('admin/pengumuman')->with(['success' => 'Berhasil']);
    }

    public function formEditPengumuman($id)
    {
        $user = Auth::user();
        $data = DB::table('pengumuman')
            ->select('pengumuman.*')
            ->orderByRaw('pengumuman.id DESC')
            ->where('id', $id)
            ->first();
        return view('admin.pengumuman.edit',  compact('data', 'user'));
    }
    public function updatePengumuman(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'judul' => 'required',
                'deskripsi' => 'required',
                'gambar' => 'max:2048',
            ],
            [
                'gambar.max' => 'File terlalu besar, maksimal 2 mb',
            ]
        );

        $gambar = $request->file('gambar');

        $judul = $request->judul;
        $deskripsi = $request->deskripsi;
        $updated_at = Carbon::now('GMT+7');

        if ($gambar != null) {
            $tujuan_upload = 'pengumuman/';

            $namagambar = $gambar->getClientOriginalName();

            $gambar->move($tujuan_upload, $namagambar);

            $data = DB::table('pengumuman')
                ->where('id', $id)
                ->update(
                    [
                        'judul' => $judul,
                        'deskripsi' => $deskripsi,
                        'gambar' => $namagambar,
                        'updated_at' => $updated_at
                    ]
                );
        } else {
            $data = DB::table('pengumuman')
                ->where('id', $id)
                ->update(
                    [
                        'judul' => $judul,
                        'deskripsi' => $deskripsi,
                        'updated_at' => $updated_at
                    ]
                );
        }


        return redirect('admin/pengumuman')->with(['success' => 'Berhasil']);
    }

    public function deletePengumuman($id)
    {
        $user = DB::table('pengumuman')
            ->where('id', $id)->delete();

        return back()->with(['success' => 'Berhasil']);
    }
}
