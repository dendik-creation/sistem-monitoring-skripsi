@extends('mahasiswa.main')

@section('content')
    <div class="container-fluid mt-4">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Pendaftaran Ujian Skripsi</h1>
            <div class="pull-right">
                @if ($databim == null || $databim->ket1 == "Selesai Bimbingan" && $databim->ket2 == "Selesai Bimbingan")
                    @if ($datapenguji === null)
                    <a href="/mahasiswa/skripsi/tambahujian" class="btn btn-success btn-flat disabled">
                        <i class="fa fa-plus"></i> Daftar
                    </a>  
                    @else
                    <a href="/mahasiswa/skripsi/tambahujian" class="btn btn-success btn-flat">
                        <i class="fa fa-plus"></i> Daftar
                    </a>
                    @endif
                @else
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
                                <th>NIM</th>
                                <th>Nama</th>
                                <th>Judul</th>
                                <th>Berkas</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1?>
                              @foreach($data as $item)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $item -> nim }}</td>
                                    <td>{{ $item -> nama }}</td>
                                    <td>{{ $item -> judul }}</td>
                                    <td><a href="/download/{{ $item->nim }}/berkas_ujian/{{$item->berkas_ujian}}"><?=$item->berkas_ujian == null ? '' : 'Download file'?></td>
                                    <td>
                                        @php
                                            $jadwal = DB::table('jadwal_ujian')
                                            ->join('berkas_ujian', 'jadwal_ujian.id_berkas_ujian', '=', 'berkas_ujian.id')
                                            ->select('jadwal_ujian.id as id', 'jadwal_ujian.status1 as status1', 'jadwal_ujian.status2 as status2', 'jadwal_ujian.status3 as status3')
                                            ->where('berkas_ujian.id', $item->id)
                                            ->first();
                                        @endphp

                                        @if (($jadwal === null && $item->status == "Menunggu Dijadwalkan") || ($jadwal === null && $item->status == "Berkas OK"))
                                            <p style="pointer-events: none;" class="btn btn-sm btn-warning">Menunggu Dijadwalkan
                                        @else

                                            @if ($jadwal === null || $item->status == "Gagal Dijadwalkan")
                                            <p style="pointer-events: none;" class="btn btn-sm btn-danger">Gagal dijadwalkan - {{ $item->komentar }}</p>
                                            
                                            @else
                                            @if ($jadwal->status1 == "Sudah" && $jadwal->status2 == "Sudah" && $jadwal->status3 == "Sudah")
                                            @php
                                            $ba = DB::table('hasil_ujian')
                                            ->join('jadwal_ujian', 'hasil_ujian.id_jadwal_ujian', '=', 'jadwal_ujian.id')
                                            ->join('berkas_ujian', 'jadwal_ujian.id_berkas_ujian', '=', 'berkas_ujian.id')
                                            ->where('id_berkas_ujian', $item->id)->first();
                                            @endphp
                                            <p style="pointer-events: none;" class="btn btn-sm btn-success">Sudah ujian</p> - <p style="pointer-events: none;" class="btn btn-sm <?=($ba->berita_acara == "Lulus" ? 'btn-success' : ($ba->berita_acara == "Tidak Lulus" ? 'btn-danger' : 'btn-warning' ))?>">{{ $ba->berita_acara }}</p>
                                            @else
                                            <a href="/mahasiswa/skripsi/jadwalujian/{{ $jadwal->id }}" class="btn btn-sm btn-primary">Lihat Jadwal</a> 
                                            @endif
                                            @endif
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