@extends('admin.main')

@section('content')
    <div class="container-fluid mt-4">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Pendaftar Ujian Skripsi</h1>
            
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
                                <th>Tanggal Daftar</th>
                                {{-- <th>Berkas</th> --}}
                                <th>Aksi</th>
                                {{-- <th>Opsi</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1?>
                              @foreach($data as $item)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $item -> semester }} {{ $item -> tahun }}</td>
                                    <td>{{ $item -> nim }}</td>
                                    <td>{{ $item -> nama }}</td>
                                    <td><?=tgl_indo(substr($item->tgl_daftar, 0, 10), true);?></td>
                                    {{-- <td><a href="/download/{{ $item->nim }}/berkas_ujian/{{$item->berkas_ujian}}"><?=$item->berkas_ujian == null ? '' : 'Download berkas ujian'?></a></td> --}}
                                    <td> <a href="/admin/skripsi/pendaftar/cek/{{$item->id}}" class="btn btn-primary btn-sm">Cek berkas</a></td>
                                    {{-- <td><a href="/admin/skripsi/pendaftar/detail/{{$item->id}}" class="btn btn-primary btn-sm">Lihat detail</td> --}}
                                </tr>
                           @endforeach
                        </tbody>
                    </table>
                </div>
    
            </div>
        </div>

        
    </div>
@endsection