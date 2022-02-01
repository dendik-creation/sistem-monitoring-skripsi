@extends('dosen.main')

@section('content')
    <div class="container-fluid mt-4">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Monitoring Skripsi Mahasiswa</h1>
            <div class="pull-right">
                <select class="custom-select" id="filterdosen2">
                    <option value="3" id="3">All</option>
                    <option value="1" id="1">Pembimbing Utama</option>
                    <option value="2" id="2">Pembimbing Pembantu</option>
                </select>
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
                                <th>Status Skripsi</th>
                                <th>Status Ujian</th>
                            </tr>
                        </thead>
                        <tbody id="datatabel">
                            <?php $no=1?>
                              @foreach($data as $item)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $item -> semester}} {{ $item -> tahun}}</td>
                                    <td>{{ $item -> nim }}</td>
                                    <td>{{ $item -> nama }}</td>
                                    <td>{{ $item-> judul }}</td>
                                    <td><p style="pointer-events: none;" class="btn btn-sm <?=$item -> status_skripsi == 'Sedang dikerjakan' ? 'btn-warning' : 'btn-success'?>">{{ $item -> status_skripsi }}</td>
                                    <td><p style="pointer-events: none;" class="btn btn-sm <?=($item -> status_ujian == 'Belum ujian' ? 'btn-danger' : ($item -> status_ujian == 'Lulus' ? 'btn-success' : 'btn-danger'))?>">{{ $item -> status_ujian }}</td>
                                </tr>
                           @endforeach
                        </tbody>
                    </table>
                </div>
    
            </div>
        </div>

        
    </div>

@endsection