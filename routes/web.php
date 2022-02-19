<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth/login');
});

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
Route::get('/download/{nim}/proposal/{id}', 'MahasiswaController@downloadProposal')->name('downloadproposal');
Route::get('/download/{nim}/berkas_sempro/{id}', 'MahasiswaController@downloadBerkasSempro')->name('downloadberkassempro');
Route::get('/download/{nim}/berkas_ujian/{id}', 'MahasiswaController@downloadBerkasUjian')->name('downloadberkasujian');
Route::get('/download/{nim}/bimbingan/{id}', 'MahasiswaController@downloadSkripsi')->name('downloadbimbingan');

Route::get('/download/{nim}/revisiproposal/{id}', 'MahasiswaController@downloadRevisiProposal')->name('downloadrevisiproposal');
Route::get('/download/{nim}/revisibimbingan/{id}', 'MahasiswaController@downloadRevisiBimbingan')->name('downloadrevisibimbingan');
Route::get('/download/{nim}/revisiujian/{id}', 'MahasiswaController@downloadRevisiUjian')->name('downloadrevisiujian');

Route::get('/download/format/plotting/dosbing', 'MahasiswaController@downloadFormatPlottingDosbing')->name('downloadformatplottingdosbing');
Route::get('/download/format/plotting/penguji', 'MahasiswaController@downloadFormatPlottingPenguji')->name('downloadformatplottingpenguji');

Route::get('/sempro/hasil/cetak/{id}', 'DosenController@cetakDokumenSempro')->name('cetakdokumensempro');
Route::get('/sempro/jadwal/cetak/{id}', 'DosenController@cetakUndanganSempro')->name('cetakundangansempro');

Route::get('/ujian/hasil/cetak/{id}', 'DosenController@cetakDokumenUjian')->name('cetakdokumenujian');
Route::get('/ujian/jadwal/cetak/{id}', 'DosenController@cetakUndanganUjian')->name('cetakundanganujian');

Route::middleware(['auth'])->group(function () {
 
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    //ADMIN
    Route::group(['middleware' => 'admin'], function () {
        //Dashboard
        Route::get('/admin', 'AdminController@index')->name('admin');

        //Semester
        Route::get('/admin/semester', 'AdminController@viewSemester')->name('datasemester');
        Route::get('/admin/semester/edit/{id}', 'AdminController@formEditSemester')->name('formeditsemester');
        Route::put('/admin/semester/{id}', 'AdminController@updateSemester')->name('updatesemester');

        //Dosen
        Route::get('/admin/dosen', 'AdminController@viewDosen')->name('datadosen');
        Route::get('/admin/dosen/tambah', 'AdminController@formAddDosen')->name('formadddosen');
        Route::post('/admin/insertdosen', 'AdminController@insertDosen')->name('insertdosen');
        Route::get('/admin/dosen/edit/{id}', 'AdminController@formEditDosen')->name('formeditdosen');
        Route::put('/admin/dosen/{id}', 'AdminController@updateDosen')->name('updatedosen');
        Route::delete('/admin/dosen/{id}', 'AdminController@deleteDosen')->name('deletedosen');
        //End Dosen

        //Mahasiswa
        Route::get('/admin/mahasiswa', 'AdminController@viewMahasiswa')->name('datamahasiswa');
        Route::get('/admin/mahasiswa/tambah', 'AdminController@formAddMahasiswa')->name('formaddmahasiswa');
        Route::post('/admin/insertmahasiswa', 'AdminController@insertMahasiswa')->name('insertmahasiswa');
        Route::get('/admin/mahasiswa/edit/{id}', 'AdminController@formEditMahasiswa')->name('formeditmahasiswa');
        Route::put('/admin/mahasiswa/{id}', 'AdminController@updateMahasiswa')->name('updatemahasiswa');
        Route::delete('/admin/mahasiswa/{id}', 'AdminController@deleteMahasiswa')->name('deletemahasiswa');
        //End Mahasiswa

        //Proposal Plotting
        Route::get('/admin/proposal/plotting', 'AdminController@viewProposalPlotting')->name('dataproposalplotting');
        Route::get('/admin/proposal/plotting/tambah', 'AdminController@formAddSatuMahasiswa')->name('formaddsatumahasiswa');
        Route::post('/admin/proposal/plotting/insert', 'AdminController@insertSatuMahasiswa')->name('insertsatumahasiswa');
        Route::post('/admin/plotdosbing/importexcel', 'AdminController@plotDosbingImportExcel')->name('plotdosbingimportexcel');

        //Proposal Monitoring
        Route::get('/admin/proposal/monitoring', 'AdminController@viewProposalMonitoring')->name('dataproposalmonitoring');

        //Proposal Pendaftar
        Route::get('/admin/proposal/pendaftar', 'AdminController@viewProposalPendaftar')->name('dataproposalpendaftar');
        Route::get('/admin/proposal/pendaftar/detail/{id}', 'AdminController@viewProposalPendaftarDetail')->name('dataproposalpendaftardetail');
        Route::post('/admin/proposal/insertjadwalsempro', 'AdminController@insertJadwalSempro')->name('insertjadwalsempro');
        //berkas ok
        Route::put('/admin/berkas/sempro/ok/{id}', 'AdminController@berkasSemproOk')->name('berkassemprook');
        //berkas kurang lengkap
        Route::put('/admin/berkas/sempro/kurang/{id}', 'AdminController@berkasSemproKurang')->name('berkassemprokurang');

        //Proposal Penjadwalan
        Route::get('/admin/proposal/penjadwalan', 'AdminController@viewProposalPenjadwalan')->name('dataproposalpenjadwalan');
        Route::get('/admin/proposal/penjadwalan/{id}', 'AdminController@viewProposalPenjadwalanFilter')->name('dataproposalpenjadwalanfilter');
        Route::get('/admin/proposal/penjadwalan/detail/{id}', 'AdminController@viewDetailJadwalSempro')->name('datadetailjadwalsempro');
        //download excel ok
        Route::get('/admin/berkas/sempro/exportexcel', 'AdminController@exportBerkasSempro');
        Route::post('/admin/proposal/penjadwalan/importexcel', 'AdminController@penjadwalanSemproImportExcel')->name('penjadwalansemproimportexcel');

        //Hasil Sempro
        Route::get('/admin/proposal/hasil', 'AdminController@viewHasilSempro')->name('datahasilsemproadmin');
        Route::get('/admin/proposal/hasil/filter/{id}', 'AdminController@viewHasilSemproFilter')->name('datahasilsemproadminfilter');

        //Skripsi Monitoring
        Route::get('/admin/skripsi/monitoring', 'AdminController@viewSkripsiMonitoring')->name('dataskripsimonitoring');

        //Penguji Plotting
        Route::get('/admin/skripsi/plotting', 'AdminController@viewPengujiPlotting')->name('datapengujiplotting');
        Route::get('/admin/skripsi/plotting/tambah', 'AdminController@formPengujiAddSatuMahasiswa')->name('formpengujiaddsatumahasiswa');
        Route::post('/admin/skripsi/plotting/insert', 'AdminController@insertPengujiSatuMahasiswa')->name('insertpengujisatumahasiswa');
        Route::post('/admin/plotpenguji/importexcel', 'AdminController@plotPengujiImportExcel')->name('plotpengujiimportexcel');

        //Ujian Skripsi Pendaftar
        Route::get('/admin/skripsi/pendaftar', 'AdminController@viewSkripsiPendaftar')->name('dataskripsipendaftar');
        Route::get('/admin/skripsi/pendaftar/detail/{id}', 'AdminController@viewSkripsiPendaftarDetail')->name('dataskripsipendaftardetail');
        Route::post('/admin/skripsi/insertjadwalujian', 'AdminController@insertJadwalUjian')->name('insertjadwalujian');
        //berkas ok
        Route::put('/admin/berkas/ujian/ok/{id}', 'AdminController@berkasUjianOk')->name('berkasujianok');
        //berkas kurang lengkap
        Route::put('/admin/berkas/ujian/kurang/{id}', 'AdminController@berkasUjianKurang')->name('berkasujiankurang');

        //Ujian Skripsi Penjadwalan
        Route::get('/admin/skripsi/penjadwalan', 'AdminController@viewSkripsiPenjadwalan')->name('dataskripsipenjadwalan');
        Route::get('/admin/skripsi/penjadwalan/{id}', 'AdminController@viewSkripsiPenjadwalanFilter')->name('dataskripsipenjadwalanfilter');
        Route::get('/admin/skripsi/penjadwalan/detail/{id}', 'AdminController@viewDetailJadwalUjian')->name('datadetailjadwalujian');
        //download excel ok
        Route::get('/admin/berkas/ujian/exportexcel', 'AdminController@exportBerkasUjian');
        Route::post('/admin/ujian/penjadwalan/importexcel', 'AdminController@penjadwalanUjianImportExcel')->name('penjadwalanujianimportexcel');

        //Hasil Ujian
        Route::get('/admin/skripsi/hasil', 'AdminController@viewHasilUjian')->name('datahasilujianadmin');
        Route::get('/admin/skripsi/hasil/filter/{id}', 'AdminController@viewHasilUjianFilter')->name('datahasilujianadminfilter');

        //s1
        Route::get('/admin/dosen/s1', 'AdminController@viewS1')->name('datas1');
        Route::get('/admin/dosen/s1/tambah', 'AdminController@formAddS1')->name('formadds1');
        Route::post('/admin/inserts1dosen', 'AdminController@insertS1')->name('inserts1');
        Route::get('/admin/dosen/s1/edit/{id}', 'AdminController@formEditS1')->name('formedits1');
        Route::put('/admin/dosen/s1/{id}', 'AdminController@updateS1')->name('updates1');

        //s2
        Route::get('/admin/dosen/s2', 'AdminController@viewS2')->name('datas2');
        Route::get('/admin/dosen/s2/tambah', 'AdminController@formAddS2')->name('formadds2');
        Route::post('/admin/inserts2dosen', 'AdminController@insertS2')->name('inserts2');
        Route::get('/admin/dosen/s2/edit/{id}', 'AdminController@formEditS2')->name('formedits2');
        Route::put('/admin/dosen/s2/{id}', 'AdminController@updateS2')->name('updates2');

        //s3
        Route::get('/admin/dosen/s3', 'AdminController@viewS3')->name('datas3');
        Route::get('/admin/dosen/s3/tambah', 'AdminController@formAddS3')->name('formadds3');
        Route::post('/admin/inserts3dosen', 'AdminController@insertS3')->name('inserts3');
        Route::get('/admin/dosen/s3/edit/{id}', 'AdminController@formEditS3')->name('formedits3');
        Route::put('/admin/dosen/s3/{id}', 'AdminController@updateS3')->name('updates3');

        //bidang
        Route::get('/admin/dosen/bidang', 'AdminController@viewBidang')->name('databidang');
        Route::get('/admin/dosen/bidang/tambah', 'AdminController@formAddBidang')->name('formaddbidang');
        Route::post('/admin/insertbidangdosen', 'AdminController@insertBidang')->name('insertbidang');
        Route::get('/admin/dosen/bidang/edit/{id}', 'AdminController@formEditBidang')->name('formeditbidang');
        Route::put('/admin/dosen/bidang/{id}', 'AdminController@updateBidang')->name('updatebidang');

        //rekap
        Route::get('/admin/rekap/pembimbing/seminar', 'AdminController@viewPembimbingSeminar')->name('datapembimbingseminar');
        Route::get('/admin/rekap/pembimbing/skripsi', 'AdminController@viewPembimbingSkripsi')->name('datapembimbingskripsi');
        Route::get('/admin/rekap/penguji/skripsi', 'AdminController@viewPengujiSkripsi')->name('datapengujiskripsi');
        //tampil rekap
        Route::post('/admin/rekap/pembimbing/seminar/tampil', 'AdminController@tampilPembimbingSeminar')->name('tampilpembimbingseminar');
        Route::post('/admin/rekap/pembimbing/skripsi/tampil', 'AdminController@tampilPembimbingSkripsi')->name('tampilpembimbingskripsi');
        Route::post('/admin/rekap/penguji/skripsi/tampil', 'AdminController@tampilPengujiSkripsi')->name('tampilpengujiskripsi');
        //cetak rekap
        Route::post('/admin/rekap/pembimbing/seminar/cetak', 'AdminController@cetakPembimbingSeminar')->name('cetakpembimbingseminar');
        Route::post('/admin/rekap/pembimbing/skripsi/cetak', 'AdminController@cetakPembimbingSkripsi')->name('cetakpembimbingskripsi');
        Route::post('/admin/rekap/penguji/skripsi/cetak', 'AdminController@cetakPengujiSkripsi')->name('cetakpengujiskripsi');
    });
 
    //DOSEN
    Route::group(['middleware' => 'dosen'], function () {
        Route::get('/dosen', 'DosenController@index')->name('dosen');

        //Mahasiswa Bimbingan
        Route::get('/dosen/mahasiswa', 'DosenController@viewMahasiswaBimbingan')->name('datamhsbimbingan');
        Route::get('/dosen/mahasiswa/{id}', 'DosenController@viewMahasiswaBimbinganFilter')->name('datamhsbimbinganfilter');
        Route::get('/dosen/mahasiswa/detail/{nim}', 'DosenController@viewMahasiswaBimbinganDetail')->name('datamhsbimbingandetail');

        //Profil
        Route::get('/dosen/edit', 'DosenController@formEditProfil')->name('formeditprofildosen');
        Route::put('/dosen/{id}', 'DosenController@updateProfil')->name('updateprofildosen');

        //Monitoring Proposal Mahasiswa
        Route::get('/dosen/monitoring/proposal', 'DosenController@viewProposalMahasiswa')->name('dataproposalmahasiswa');
        Route::get('/dosen/monitoring/proposal/{id}', 'DosenController@viewProposalMahasiswaFilter')->name('dataproposalmahasiswafilter');
        Route::get('/dosen/monitoring/proposal/detail/{id}', 'DosenController@viewDetailProposal')->name('dataproposalmahasiswadetail');
        //Aksi
        Route::put('/dosen/monitoring/proposal/acc/{id}', 'DosenController@accProposalMhs')->name('dosenaccproposal');
        Route::put('/dosen/monitoring/proposal/tolak/{id}', 'DosenController@tolakProposalMhs')->name('dosentolakproposal');
        Route::put('/dosen/monitoring/proposal/revisi/{id}', 'DosenController@revisiProposalMhs')->name('dosenrevisiproposal');

        //Monitoring Bimbingan Mahasiswa
        Route::get('/dosen/monitoring/bimbingan', 'DosenController@viewBimbinganMahasiswa')->name('databimbinganmahasiswa');
        Route::get('/dosen/monitoring/bimbingan/detail/{nim}/{id}', 'DosenController@viewBimbinganDetail')->name('databimbingandetaildosen');
        Route::post('/dosen/balas/pesan', 'DosenController@insertPesan')->name('insertpesandosen');

        Route::put('/dosen/monitoring/bimbingan/selesai/{id}', 'DosenController@selesaiBimbinganMhs')->name('dosenselesaibimbinganmhs');
        Route::put('/dosen/monitoring/bimbingan/revisi/{id}', 'DosenController@revisiBimbinganMhs')->name('dosenrevisibimbinganmhs');
        Route::put('/dosen/monitoring/bimbingan/siapujian/{id}', 'DosenController@siapUjianMhs')->name('dosensiapujianmhs');
        Route::get('/dosen/monitoring/bimbingan/{id}', 'DosenController@viewBimbinganMahasiswaFilter')->name('databimbinganmahasiswafilter');

        //Monitoring Skripsi
        Route::get('/dosen/monitoring/skripsi', 'DosenController@viewSkripsiMahasiswa')->name('dataskripsimahasiswa');
        Route::get('/dosen/monitoring/skripsi/{id}', 'DosenController@viewSkripsiMahasiswaFilter')->name('dataskripsimahasiswafilter');

        //Seminar Proposal
        //Jadwal Seminar
        Route::get('/dosen/sempro/jadwal', 'DosenController@viewJadwalSempro')->name('datajadwalsemprodosen');
        Route::get('/dosen/sempro/jadwal/detail/{id}', 'DosenController@viewDetailJadwalSempro')->name('detailjadwalsemprodosen');
        
        //Hasil Seminar
        Route::post('/dosen/sempro/inserthasil', 'DosenController@insertHasilSempro')->name('inserthasilsempro');
        Route::get('/dosen/sempro/hasil', 'DosenController@viewHasilSempro')->name('datahasilsemprodosen');
        Route::get('/dosen/sempro/hasil/detail/{id}', 'DosenController@viewDetailHasilSempro')->name('detailhasilsemprodosen');
        Route::get('/dosen/sempro/hasil/filter/{id}', 'DosenController@viewHasilSemproFilter')->name('datahasilsemprodosenfilter');

        //Print pdf
        Route::get('/dosen/ujian/berita', 'DosenController@viewBeritaAcara')->name('viewberitaacara');
        Route::get('/dosen/ujian/berita/cetak', 'DosenController@cetakBeritaAcara')->name('cetakberitaacara');

        //Jadwal Ujian Skripsi
        Route::get('/dosen/skripsi/jadwal', 'DosenController@viewJadwalUjian')->name('datajadwalujiandosen');
        Route::get('/dosen/skripsi/jadwal/detail/{id}', 'DosenController@viewDetailJadwalUjian')->name('detailjadwalujiandosen');
        
        //Hasil Ujian Skripsi
        Route::post('/dosen/skripsi/inserthasil', 'DosenController@insertHasilUjian')->name('inserthasilujian');
        Route::get('/dosen/skripsi/hasil', 'DosenController@viewHasilUjian')->name('datahasilujiandosen');
        Route::get('/dosen/skripsi/hasil/detail/{id}', 'DosenController@viewDetailHasilUjian')->name('detailhasilujiandosen');
        Route::get('/dosen/skripsi/hasil/filter/{id}', 'DosenController@viewHasilUjianFilter')->name('datahasilujiandosenfilter');

    });

    //MAHASISWA
    Route::group(['middleware' => 'mahasiswa'], function () {
        Route::get('/mahasiswa', 'MahasiswaController@index')->name('mahasiswa');

        //Profil
        Route::get('/mahasiswa/edit', 'MahasiswaController@formEditProfil')->name('formeditprofil');
        Route::put('/mahasiswa/{id}', 'MahasiswaController@updateProfil')->name('updateprofilmhs');

        //Pengajuan Proposal
        Route::get('/mahasiswa/proposal/pengajuan', 'MahasiswaController@viewPengajuanProposal')->name('datapengajuanproposal');
        Route::get('/mahasiswa/proposal/pengajuan/detail/{id}', 'MahasiswaController@viewDetailProposal')->name('datadetailproposal');
        Route::get('/mahasiswa/proposal/tambah', 'MahasiswaController@formAddProposal')->name('formaddproposal');
        Route::post('/mahasiswa/insertproposal', 'MahasiswaController@insertProposal')->name('insertproposal');
        Route::put('/mahasiswa/proposal/revisi/{id}', 'MahasiswaController@editProposal')->name('updatepropmhs');
        

        //Pendaftaran Seminar
        Route::get('/mahasiswa/proposal/daftarsempro', 'MahasiswaController@viewDaftarSempro')->name('datadaftarsempro');
        Route::get('/mahasiswa/proposal/tambahsempro', 'MahasiswaController@formAddSempro')->name('formaddsempro');
        Route::post('/mahasiswa/insertsempro', 'MahasiswaController@insertBerkas')->name('insertsempro');
        Route::put('/mahasiswa/editsempro/{id}', 'MahasiswaController@editBerkas')->name('editsempro');
        

        //Penjadwalan Seminar
        Route::get('/mahasiswa/proposal/jadwalsempro/{id}', 'MahasiswaController@viewJadwalSempro')->name('datajadwalsempro');

        //Hasil Seminar
        Route::get('/mahasiswa/proposal/hasil', 'MahasiswaController@viewHasilSempro')->name('datahasilsempromhs');
        Route::get('/mahasiswa/proposal/hasil/detail/{id}', 'MahasiswaController@viewDetailHasilSempro')->name('detailhasilsempromhs');


        //Skripsi
        Route::get('/mahasiswa/skripsi/monitoring', 'MahasiswaController@viewSkripsi')->name('dataskripsi');

        //Bimbingan
        Route::get('/mahasiswa/skripsi/bimbingan', 'MahasiswaController@viewBimbingan')->name('databimbingan');
        Route::get('/mahasiswa/skripsi/bimbingan/detail/{id}', 'MahasiswaController@viewBimbinganDetail')->name('databimbingandetail');
        Route::get('/mahasiswa/skripsi/bimbingan/tambah', 'MahasiswaController@formAddBimbingan')->name('formaddbimbingan');
        Route::get('/mahasiswa/skripsi/bimbingan/tambah/2', 'MahasiswaController@formAddBimbingan2')->name('formaddbimbingan2');
        Route::post('/mahasiswa/insertbimbingan', 'MahasiswaController@insertBimbingan')->name('insertbimbingan');
        Route::post('/mahasiswa/insertbimbingan/2', 'MahasiswaController@insertBimbingan2')->name('insertbimbingan2');
        
        Route::post('/mahasiswa/balas/pesan', 'MahasiswaController@insertPesan')->name('insertpesan');

        //Pendaftaran Ujian
        Route::get('/mahasiswa/skripsi/daftarujian', 'MahasiswaController@viewDaftarUjian')->name('datadaftarujian');
        Route::get('/mahasiswa/skripsi/tambahujian', 'MahasiswaController@formAddUjian')->name('formaddujian');
        Route::post('/mahasiswa/insertujian', 'MahasiswaController@insertBerkasUjian')->name('insertujian');
        Route::put('/mahasiswa/editujian/{id}', 'MahasiswaController@editBerkasUjian')->name('editujian');

        //Penjadwalan Ujian
        Route::get('/mahasiswa/skripsi/jadwalujian/{id}', 'MahasiswaController@viewJadwalUjian')->name('datajadwalujian');

        //Hasil Ujian
        Route::get('/mahasiswa/skripsi/hasil', 'MahasiswaController@viewHasilUjian')->name('datahasilujianmhs');
        Route::get('/mahasiswa/skripsi/hasil/detail/{id}', 'MahasiswaController@viewDetailHasilUjian')->name('detailhasilujianmhs');

        Route::get('/sempro/hasil/cetakmhs/{id}', 'MahasiswaController@cetakDokumenSemproMhs')->name('cetakdokumensempromhs');
        Route::get('/ujian/hasil/cetakmhs/{id}', 'MahasiswaController@cetakDokumenUjianMhs')->name('cetakdokumenujianmhs');

        //tampil & cetak bimbingan
        Route::get('/mahasiswa/skripsi/bimbingan/tampil', 'MahasiswaController@tampilBimbinganMhs')->name('tampilbimbinganmhs');
        Route::get('/mahasiswa/skripsi/bimbingan/cetak', 'MahasiswaController@cetakBimbinganMhs')->name('cetakbimbinganmhs');

    });
 
    Route::get('/logout', function() {
        Auth::logout();
        redirect('/');
    })->name('logout');
 
});
