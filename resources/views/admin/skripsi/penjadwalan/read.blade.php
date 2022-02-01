@extends('admin.main')

@section('content')
    <div class="container-fluid mt-4">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Jadwal Ujian Skripsi</h1>
            {{-- <div class="pull-right">
                <a href="/mahasiswa/proposal/tambah" class="btn btn-success btn-flat">
                    <i class="fa fa-plus"></i> Ajukan
                </a>
            </div> --}}
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
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1?>
                              @foreach($data as $item)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $item -> semester}} {{ $item -> tahun}}</td>
                                    <td>{{ $item -> nim }}</td>
                                    <td>{{ $item -> nama }}</td>
                                    <td>{{ $item -> judul }}</td>
                                    <td>
                                        {{ tgl_indo($item->tanggal, true)}}
                                    </td>
                                    <td>
                                        @if ($item -> status1 == 'Belum' && $item -> status2 == 'Belum')
                                        <p style="pointer-events: none;" class="btn btn-sm btn-warning">Belum ujian skripsi</p>
                                        @else
                                        @php
                                            $ba = DB::table('hasil_ujian')->where('id_jadwal_ujian', $item->id)->first();
                                            // dd($ba);
                                        @endphp
                                        <p style="pointer-events: none;" class="btn btn-sm btn-success">Sudah ujian skripsi</p>  - <p style="pointer-events: none;" class="btn btn-sm <?=$ba->berita_acara == "Lulus" ? 'btn-success' : 'btn-danger'?>">{{ $ba->berita_acara }}</p>
                                        @endif
                                    </td>
                                    <td><a href="/admin/skripsi/penjadwalan/detail/{{$item->id}}" class="btn btn-sm btn-primary">Lihat Detail</td>
                                </tr>
                           @endforeach
                        </tbody>
                    </table>
                </div>
    
            </div>
        </div>

        
    </div>
@endsection