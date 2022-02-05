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
                                <th>Opsi</th>
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
                                    <td><a href="/download/{{ $item->nim }}/berkas_ujian/{{$item->berkas_ujian}}"><?=$item->berkas_ujian == null ? '' : 'Download berkas ujian'?></td>
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
                                            <p style="pointer-events: none;" class="btn btn-sm btn-success">Sudah ujian</p> - <p style="pointer-events: none;" class="btn btn-sm <?=($ba->berita_acara == "Lulus" ? 'btn-success' : ($ba->berita_acara == "Tidak Lulus" ? 'btn-danger' : 'btn-warning' ))?>">{{ $ba->berita_acara }}</p>
                                            @else
                                            <p style="pointer-events: none;" class="btn btn-sm btn-warning">Belum ujian</p> 
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
                                            Upload perbaikan berkas
                                          </button>
                                        <div class="modal fade" id="modalberkas{{$item->id}}" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Upload Perbaikan Berkas Ujian</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                </div>
                                                <form action="/mahasiswa/editujian/{{$item->id}}" method="post" enctype="multipart/form-data">
                                                    {{csrf_field()}}
                                                    {{method_field('PUT')}}
                                                    <div class="modal-body">
                                                      <div class="form-group">
                                                        <label for="" class="small">Berkas* (ZIP) (Max 30MB)</label><br>
                                                        <input type="file" name="berkas_ujian" placeholder="Masukkan File" accept=".zip,.rar,.7zip">
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
                                        @elseif($item->status == "Menunggu Dijadwalkan" || $item->status == "Berkas OK")
                                        -
                                        @else
                                        <a href="/mahasiswa/proposal/jadwalujian/{{ $jadwal->id }}" class="btn btn-sm btn-primary">Lihat Jadwal</a>
                                        <a href="/ujian/jadwal/cetak/{{ $jadwal->id }}" target="_blank" class="btn btn-primary btn-sm mt-1">Lihat Undangan</a>
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