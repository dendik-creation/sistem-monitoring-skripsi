@extends('mahasiswa.main')

@section('content')
    <div class="container-fluid mt-4">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Pendaftaran Seminar Proposal</h1>
            <div class="pull-right">
                @php
                    $tgl = date('Y-m-d');
                    // echo $tgl;

                    $cek = DB::table('berkas_sempro')
                    ->join('mahasiswa', 'berkas_sempro.nim', '=', 'mahasiswa.nim')
                    ->select('berkas_sempro.*', 'mahasiswa.*')
                    ->where('berkas_sempro.nim', $user->no_induk)
                    ->orderByRaw('berkas_sempro.id DESC')
                    ->first();
                    // dd($data);
                @endphp
                {{-- @if ($dataprop === null || $tgl != "2022-01-31") --}}
                @if ($dataprop === null)
                    <a href="/mahasiswa/proposal/tambahsempro" class="btn btn-success btn-flat disabled">
                        <i class="fa fa-plus"></i> Daftar
                    </a>
                @elseif($cek == null)
                    <a href="/mahasiswa/proposal/tambahsempro" class="btn btn-success btn-flat">
                        <i class="fa fa-plus"></i> Daftar
                    </a>
                @elseif($cek->status == "Menunggu Dijadwalkan" || $cek->status == "Berkas OK" ||  $cek->status == "Berkas tidak lengkap")
                    <a href="/mahasiswa/proposal/tambahsempro" class="btn btn-success btn-flat disabled">
                        <i class="fa fa-plus"></i> Daftar
                    </a>
                @else
                <a href="/mahasiswa/proposal/tambahsempro" class="btn btn-success btn-flat">
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
                                    <td><a href="/download/{{ $item->nim }}/berkas_sempro/{{$item->berkas_sempro}}"><?=$item->berkas_sempro == null ? '' : 'Download berkas sempro'?></td>
                                    <td>
                                        @php
                                            $jadwal = DB::table('jadwal_sempro')
                                            ->join('berkas_sempro', 'jadwal_sempro.id_berkas_sempro', '=', 'berkas_sempro.id')
                                            ->select('jadwal_sempro.id as id', 'jadwal_sempro.status1 as status1', 'jadwal_sempro.status2 as status2')
                                            ->where('berkas_sempro.id', $item->id)
                                            ->first();
                                            // dd($jadwal);
                                        @endphp
                                        @if (($jadwal === null && $item->status == "Menunggu Dijadwalkan") || ($jadwal === null && $item->status == "Berkas OK"))
                                            <p style="pointer-events: none;" class="btn btn-sm btn-warning">Menunggu Dijadwalkan
                                        @else

                                            @if ($jadwal === null && $item->status == "Berkas tidak lengkap")
                                            <p style="pointer-events: none;" class="btn btn-sm btn-danger">Berkas tidak lengkap - {{ $item->komentar }}</p>
                                            {{-- @elseif($item->status == "Terjadwal")
                                            <p style="pointer-events: none;" class="btn btn-sm btn-success">Berkas tidak lengkap - {{ $item->komentar }}</p> --}}
                                            @else
                                                @if ($jadwal->status1 == "Sudah" && $jadwal->status2 == "Sudah")
                                                @php
                                                $ba = DB::table('hasil_sempro')
                                                ->join('jadwal_sempro', 'hasil_sempro.id_jadwal_sempro', '=', 'jadwal_sempro.id')
                                                ->join('berkas_sempro', 'jadwal_sempro.id_berkas_sempro', '=', 'berkas_sempro.id')
                                                ->where('id_berkas_sempro', $item->id)->first();
                                                // dd($ba);
                                                @endphp
                                                <p style="pointer-events: none;" class="btn btn-sm btn-success">Sudah seminar proposal</p> - <p style="pointer-events: none;" class="btn btn-sm <?=($ba->berita_acara == "Diterima" ? 'btn-success' : ($ba->berita_acara == "Ditolak" ? 'btn-danger' : 'btn-warning' ))?>">{{ $ba->berita_acara }}</p>
                                                {{-- <a href="/mahasiswa/proposal/jadwalsempro/{{ $jadwal->id }}" class="btn btn-sm btn-primary">Lihat Jadwal</a>
                                                <a href="/sempro/jadwal/cetak/{{ $jadwal->id }}" target="_blank" class="btn btn-primary btn-sm mt-1">Lihat Undangan</a> --}}
                                                @else
                                                <p style="pointer-events: none;" class="btn btn-sm btn-warning">Belum seminar proposal</p> 
                                                @endif
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $jadwal = DB::table('jadwal_sempro')
                                            ->join('berkas_sempro', 'jadwal_sempro.id_berkas_sempro', '=', 'berkas_sempro.id')
                                            ->select('jadwal_sempro.id as id', 'jadwal_sempro.status1 as status1', 'jadwal_sempro.status2 as status2')
                                            ->where('berkas_sempro.id', $item->id)
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
                                                <h5 class="modal-title" id="exampleModalLabel">Upload Perbaikan Berkas Sempro</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                </div>
                                                <form action="/mahasiswa/editsempro/{{$item->id}}" method="post" enctype="multipart/form-data">
                                                    {{csrf_field()}}
                                                    {{method_field('PUT')}}
                                                    <div class="modal-body">
                                                      <div class="form-group">
                                                        <label for="" class="small">Berkas* (ZIP) (Max 20MB)</label><br>
                                                        <input type="file" name="berkas_sempro" placeholder="Masukkan File" accept=".zip,.rar,.7zip">
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
                                        <a href="/mahasiswa/proposal/jadwalsempro/{{ $jadwal->id }}" class="btn btn-sm btn-primary">Lihat Jadwal</a>
                                        <a href="/sempro/jadwal/cetak/{{ $jadwal->id }}" target="_blank" class="btn btn-primary btn-sm mt-1">Lihat Undangan</a>
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
