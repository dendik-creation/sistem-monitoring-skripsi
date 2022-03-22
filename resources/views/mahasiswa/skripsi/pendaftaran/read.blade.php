@extends('mahasiswa.main')

@section('content')
    <div class="container-fluid mt-4">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Pendaftaran Ujian Skripsi</h1>
            <div class="pull-right">
                @php
                    $cek = DB::table('berkas_ujian')
                    ->join('mahasiswa', 'berkas_ujian.nim', '=', 'mahasiswa.nim')
                    ->select('berkas_ujian.*', 'mahasiswa.*')
                    ->where('berkas_ujian.nim', $user->no_induk)
                    ->orderByRaw('berkas_ujian.id DESC')
                    ->first();
                    // dd($cek);

                    $databim = DB::table('bimbingan')
                    ->join('mahasiswa', 'bimbingan.nim', '=', 'mahasiswa.nim')
                    ->select('bimbingan.*', 'mahasiswa.*')
                    ->where('bimbingan.nim', $user->no_induk)
                    ->orderByRaw('bimbingan.id DESC')
                    ->first();
                    // dd($databim);

                    $mhs = DB::table('mahasiswa')
                    ->select('mahasiswa.*')
                    ->where('mahasiswa.nim', $user->no_induk)
                    ->first();
                    // dd($mhs);
                @endphp
                {{-- @if ($databim->ket1 == "Siap ujian" && $databim->ket2 == "Siap ujian")
                    {{-- @if ($datapenguji === null) --}}
                    {{-- <a href="/mahasiswa/skripsi/tambahujian" class="btn btn-success btn-flat"> 
                        <i class="fa fa-plus"></i> Daftar
                    </a>
                    @elseif ($cek == null)
                    <a href="/mahasiswa/skripsi/tambahujian" class="btn btn-success btn-flat disabled"> 
                        <i class="fa fa-plus"></i> Daftar
                    </a>  
                    @elseif($cek->status == "Menunggu Dijadwalkan" || $cek->status == "Berkas OK" ||  $cek->status == "Berkas tidak lengkap")
                    <a href="/mahasiswa/skripsi/tambahujian" class="btn btn-success btn-flat disabled">
                        <i class="fa fa-plus"></i> Daftar
                    </a> 
                    @else
                    <a href="/mahasiswa/skripsi/tambahujian" class="btn btn-success btn-flat">
                        <i class="fa fa-plus"></i> Daftar
                    </a>
                    @endif --}}
                {{-- @else
                <a href="/mahasiswa/skripsi/tambahujian" class="btn btn-success btn-flat disabled">
                    <i class="fa fa-plus"></i> Daftar
                </a> 
                @endif --}}

                @if($databim==null)
                <a href="/mahasiswa/skripsi/tambahujian" class="btn btn-success btn-flat disabled">
                    <i class="fa fa-plus"></i> Daftar
                </a>
                @elseif($mhs->status_bimbingan != "Siap ujian")
                <a href="/mahasiswa/skripsi/tambahujian" class="btn btn-success btn-flat disabled">
                    <i class="fa fa-plus"></i> Daftar
                </a>
                @elseif($cek==null)
                <a href="/mahasiswa/skripsi/tambahujian" class="btn btn-success btn-flat">
                    <i class="fa fa-plus"></i> Daftar
                </a>  
                @elseif ($cek->status == "Menunggu Dijadwalkan" || $cek->status == "Berkas OK" ||  $cek->status == "Berkas tidak lengkap")
                <a href="/mahasiswa/skripsi/tambahujian" class="btn btn-success btn-flat disabled">
                    <i class="fa fa-plus"></i> Daftar
                </a> 
                
                
                @endif
            </div>
        </div>

        @if ($message = Session::get('success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button> 
            <strong>{{ $message }}</strong>
        </div>
        @endif

        @if ($message = Session::get('error'))
        <div class="alert alert-danger alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button> 
            <strong>{{ $message }}</strong>
        </div>
        @endif

        <!-- Content Row -->
        <div class="card shadow">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="dataTable" style="width:100%" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Semester</th>
                                <th>NIM</th>
                                <th>Nama</th>
                                <th>Judul</th>
                                <th>Berkas</th>
                                <th>Status</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1?>
                              @foreach($data as $item)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $item -> smt }} {{ $item -> thn }}</td>
                                    <td>{{ $item -> nim }}</td>
                                    <td>{{ $item -> nama }}</td>
                                    <td>{{ $item -> judul }}</td>
                                    <td>
                                        <a href="/download/{{ $item->nim }}/berkas_ujian/{{$item->scan_bukti_bayar}}"><?=$item->scan_bukti_bayar == null ? '' : 'Download bukti pembayaran'?><br>
                                        <a href="/download/{{ $item->nim }}/berkas_ujian/{{$item->laporan}}"><?=$item->laporan == null ? '' : 'Download laporan'?><br>
                                        <a href="/download/{{ $item->nim }}/berkas_ujian/{{$item->transkrip}}"><?=$item->transkrip == null ? '' : 'Download transkrip nilai'?><br>
                                        <a href="/download/{{ $item->nim }}/berkas_ujian/{{$item->ketpengumpulan}}"><?=$item->ketpengumpulan == null ? '' : 'Download surat keterangan'?><br>
                                        <a href="/download/{{ $item->nim }}/berkas_ujian/{{$item->turnitin}}"><?=$item->turnitin == null ? '' : 'Download hasil turnitin'?><br>
                                    </td>
                                    <td>
                                        @php
                                            $jadwal = DB::table('jadwal_ujian')
                                            ->join('berkas_ujian', 'jadwal_ujian.id_berkas_ujian', '=', 'berkas_ujian.id')
                                            ->select('jadwal_ujian.id as id', 'jadwal_ujian.status1 as status1', 'jadwal_ujian.status2 as status2', 'jadwal_ujian.status3 as status3')
                                            ->where('berkas_ujian.id', $item->id)
                                            ->first();
                                        @endphp
                                        @if($jadwal === null && $item->status == "Menunggu Verifikasi")
                                        <p style="pointer-events: none;" class="btn btn-sm btn-warning">Menunggu Verifikasi Berkas
                                        @elseif (($jadwal === null && $item->status == "Menunggu Dijadwalkan") || ($jadwal === null && $item->status == "Berkas OK"))
                                            <p style="pointer-events: none;" class="btn btn-sm btn-primary">Menunggu Dijadwalkan
                                        @else

                                            @if ($jadwal === null || $item->status == "Berkas tidak lengkap")
                                            <p style="pointer-events: none;" class="btn btn-sm btn-danger">Berkas tidak lengkap - {{ $item->komentar }}</p>
                                            
                                            @else
                                            @if ($jadwal->status1 == "Sudah" && $jadwal->status2 == "Sudah" && $jadwal->status3 == "Sudah")
                                            @php
                                            $ba = DB::table('hasil_ujian')
                                            ->join('jadwal_ujian', 'hasil_ujian.id_jadwal_ujian', '=', 'jadwal_ujian.id')
                                            ->join('berkas_ujian', 'jadwal_ujian.id_berkas_ujian', '=', 'berkas_ujian.id')
                                            ->where('id_berkas_ujian', $item->id)->first();
                                            @endphp
                                            <p style="pointer-events: none;" class="btn btn-sm btn-success">Sudah ujian</p> 
                                            {{-- - <p style="pointer-events: none;" class="btn btn-sm <?=//($ba->berita_acara == "Lulus" ? 'btn-success' : ($ba->berita_acara == "Tidak Lulus" ? 'btn-danger' : 'btn-warning' ))?>">{{ $ba->berita_acara }}</p> --}}
                                            @else
                                            <p style="pointer-events: none;" class="btn btn-sm btn-success">Terjadwal</p> 
                                            @endif
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $jadwal = DB::table('jadwal_ujian')
                                            ->join('berkas_ujian', 'jadwal_ujian.id_berkas_ujian', '=', 'berkas_ujian.id')
                                            ->select('jadwal_ujian.id as id', 'jadwal_ujian.status1 as status1', 'jadwal_ujian.status2 as status2', 'jadwal_ujian.status3 as status3')
                                            ->where('berkas_ujian.id', $item->id)
                                            ->first();
                                            // dd($jadwal);
                                        @endphp

                                        @if ($jadwal === null && $item->status == "Berkas tidak lengkap")
                                        <button type="button" class="btn btn-primary btn-sm mr-2" data-toggle="modal" data-target="#modalberkas{{$item->id}}">
                                            Upload ulang berkas
                                          </button>
                                        <div class="modal fade" id="modalberkas{{$item->id}}" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Upload Ulang Berkas Ujian</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                </div>
                                                <form action="/mahasiswa/editujian/{{$item->id}}" method="post" enctype="multipart/form-data">
                                                    {{csrf_field()}}
                                                    {{method_field('PUT')}}
                                                    <div class="modal-body">
                                                      <div class="form-group">
                                                        <label for="" class="small">Scan Bukti Pembayaran (JPG/PNG/PDF) (Max 2MB)</label><br>
                                                        <input type="file" name="byr" required  accept=".jpg,.jpeg,.png,.pdf">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="" class="small">Laporan Skripsi (PDF) (Max 20MB)</label><br>
                                                        <input type="file" name="laporan" required  accept=".jpg,.jpeg,.png,.pdf">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="" class="small">Scan Transkrip Nilai (JPG/PNG/PDF) (Max 2MB)</label><br>
                                                        <input type="file" name="transkrip" required  accept=".jpg,.jpeg,.png,.pdf">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="" class="small">Scan Surat Keterangan Telah Mengumpulkan Proposal (JPG/PNG/PDF) (Max 2MB)</label><br>
                                                        <input type="file" name="ketpengumpulan" required  accept=".jpg,.jpeg,.png,.pdf">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="" class="small">Scan Hasil Turnitin (JPG/PNG/PDF) (Max 2MB)</label><br>
                                                        <input type="file" name="turnitin" required  accept=".jpg,.jpeg,.png,.pdf">
                                                    </div>
                                                      <input type="hidden" name="nim" value="{{$item->nim}}" id="">
                                                    </div>
                                                    <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" name="submit" class="btn btn-primary">Upload</button>
                                                    </div>
                                                </form>
                                            </div>
                                            </div>
                                        </div>
                                        @elseif($item->status == "Menunggu Dijadwalkan" || $item->status == "Berkas OK" || $item->status == "Menunggu Verifikasi")
                                        -
                                        @else
                                        <a href="/ujian/jadwal/cetak/{{ $jadwal->id }}" target="_blank" class="btn btn-primary btn-sm">Lihat Undangan</a>
                                        <a href="/mahasiswa/skripsi/jadwalujian/{{ $jadwal->id }}" class="btn btn-sm btn-primary mt-1">Lihat Jadwal</a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                        </tbody>
                    </table>
                </div>
    
            </div>
        </div>

        
    </div>
@endsection