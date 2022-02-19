@extends('mahasiswa.main')

@section('content')
    <div class="container-fluid mt-4">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Hasil Ujian Skripsi</h1>
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
                                <th>NIM</th>
                                <th>Nama</th>
                                <th>Judul</th>
                                <th>Status</th>
                                <th>Total Nilai</th>
                                <th>Grade</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1?>
                              @foreach($data as $item)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $item -> nim}}</td>
                                    <td>{{ $item -> nama}}</td>
                                    <td>{{ $item -> judul}}</td>
                                    {{-- <td>{{ tgl_indo($item->tanggal, true)}}</td> --}}
                                    <td><a style="pointer-events: none;" class="btn btn-sm <?=($item->berita_acara == "Lulus" ? 'btn-success' : ($ba->berita_acara == "Tidak Lulus" ? 'btn-danger' : 'btn-warning' ))?>">{{ $item -> berita_acara }}</a></td>
                                    {{-- <td><a href="/ujian/hasil/cetakmhs/{{ $item->id }}" target="_blank" class="btn btn-primary btn-sm <?=//$item->status1 == "Sudah" && $item->status2 == "Sudah" && $item->status3 == "Sudah" ? '' : 'disabled'?>">Lihat Nilai</a></td> --}}
                                    <td>{{ $item -> nilai_akhir}}</td>
                                    <td>{{ $item -> grade_akhir}}</td>
                                    <td><a href="/mahasiswa/skripsi/hasil/detail/{{ $item->id }}" class="btn btn-sm btn-primary">Detail</a></td>
                                </tr>
                           @endforeach
                        </tbody>
                    </table>
                </div>
    
            </div>
        </div>

        
    </div>
@endsection