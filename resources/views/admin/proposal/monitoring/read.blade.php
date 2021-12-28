@extends('admin.main')

@section('content')
    <div class="container-fluid mt-4">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Monitoring Proposal</h1>
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
                                <th>Proposal</th>
                                <th>Dosen Pembimbing Utama</th>
                                <th>Dosen Pembimbing Pembantu</th>
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
                                    <td><a href="/download/{{ $item->nim }}/proposal/{{$item->proposal}}">{{$item->proposal}}</a></td>
                                    <td>{{ $item -> gelar31 }} {{ $item -> dosbing1 }}, {{ $item -> gelar11 }}, {{ $item -> gelar21 }} - 
                                        <p style="pointer-events: none" class="btn btn-sm mt-2 <?=($item -> ket1 == 'Disetujui' ? 'btn-success' : ($item -> ket1 == 'Revisi' ? 'btn-warning' : ($item -> ket1 == 'Ditolak' ? 'btn-danger' : 'btn-secondary')))?>">{{ $item -> ket1 }}</p>
                                    </td>
                                    <td>{{ $item -> gelar32 }} {{ $item -> dosbing2 }}, {{ $item -> gelar12 }}, {{ $item -> gelar22 }} -
                                        <p style="pointer-events: none" class="btn btn-sm mt-2 <?=($item -> ket2 == 'Disetujui' ? 'btn-success' : ($item -> ket2 == 'Revisi' ? 'btn-warning' : ($item -> ket2 == 'Ditolak' ? 'btn-danger' : 'btn-secondary')))?>">{{ $item -> ket2 }}</p>
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