@extends('mahasiswa.main')

@section('content')
    <div class="container-fluid mt-4">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Bimbingan Skripsi</h1>
            <div class="pull-right">
                <a href="/mahasiswa/skripsi/bimbingan/tambah" class="btn btn-success btn-flat <?=$cekbimbinganselesai != null ? 'disabled' : '' ?>">
                    <i class="fa fa-plus"></i> Tambah
                </a>
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
                                <th>Bimbingan Ke</th>
                                <th>Status</th>
                                <th>Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1?>
                              @foreach($data as $item)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $item -> nim }}</td>
                                    <td>{{ $item -> nama }}</td>
                                    <td>{{ $item -> bimbingan_ke }}</td>
                                    <td>
                                        <p style="pointer-events: none;" class="btn btn-sm <?=($item -> ket1 == 'Ok' || $item -> ket1 == 'Selesai Bimbingan' ? 'btn-success' : 'btn-warning')?>">{{ $item -> ket1 }}</p>
                                         - 
                                        <p style="pointer-events: none;" class="btn btn-sm <?=($item -> ket2 == 'Ok' || $item -> ket2 == 'Selesai Bimbingan' ? 'btn-success' : 'btn-warning')?>">{{ $item -> ket2 }}</p>
                                    </td>
                                    <td><a href="/mahasiswa/skripsi/bimbingan/detail/{{ $item->bimbingan_ke  }}" class="btn btn-sm btn-primary">Lihat Detail</a></td>
                                </tr>
                                @endforeach
                        </tbody>
                    </table>
                </div>
    
            </div>
        </div>

        
    </div>
@endsection