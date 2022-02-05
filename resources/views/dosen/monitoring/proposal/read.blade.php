@extends('dosen.main')

@section('content')
    <div class="container-fluid mt-4">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Monitoring Proposal Mahasiswa</h1>
            <div class="pull-right">
                <select class="custom-select" id="filterdosen">
                    <option value="3" id="3">All</option>
                    <option value="4" id="4">Menunggu ACC</option>
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
                                {{-- <th>Proposal</th>
                                <th>Ket Mhs</th> --}}
                                <th>Status</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody id="datatabel">
                            <?php $no=1?>
                              @foreach($dosbing as $item)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $item -> semester}} {{ $item -> tahun}}</td>
                                    <td>{{ $item -> nim }}</td>
                                    <td>{{ $item -> nama }}</td>
                                    <td>{{ $item -> judul }}</td>
                                    {{-- <td><a href="/download/proposal/{{$item->proposal}}">{{$item->proposal}}</a></td>
                                    <td>
                                        {{ $item -> komentar }}
                                    </td> --}}
                                    <td>
                                        @if ($item -> dosbing1 == $user -> no_induk)
                                        <p style="pointer-events: none;" class="btn btn-sm <?=($item -> ket1 == 'Disetujui' ? 'btn-success' : ($item -> ket1 == 'Revisi' ? 'btn-warning' : ($item -> ket1 == 'Ditolak' ? 'btn-danger' : 'btn-secondary')))?>">{{ $item -> ket1 }}
                                        @else
                                        <p style="pointer-events: none;" class="btn btn-sm <?=($item -> ket2 == 'Disetujui' ? 'btn-success' : ($item -> ket2 == 'Revisi' ? 'btn-warning' : ($item -> ket2 == 'Ditolak' ? 'btn-danger' : 'btn-secondary')))?>">{{ $item -> ket2 }}
                                        @endif
                                    </td>
                                    <td><a href="/dosen/monitoring/proposal/detail/{{ $item->id }}" class="btn btn-sm btn-primary">Lihat detail</a></td>
                                </tr>
                           @endforeach
                        </tbody>
                    </table>
                </div>
    
            </div>
        </div>

        
    </div>

@endsection