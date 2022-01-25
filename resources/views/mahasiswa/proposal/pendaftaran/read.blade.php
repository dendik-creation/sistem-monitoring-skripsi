@extends('mahasiswa.main')

@section('content')
    <div class="container-fluid mt-4">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Pendaftaran Seminar Proposal</h1>
            <div class="pull-right">
                <a href="/mahasiswa/proposal/tambahsempro" class="btn btn-success btn-flat <?=$dataprop === null ? 'disabled' : '' ?>">
                    <i class="fa fa-plus"></i> Daftar
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
                                    <td><a href="/download/{{ $item->nim }}/berkas_sempro/{{$item->berkas_sempro}}">{{$item->berkas_sempro}}</td>
                                    <td>
                                        @if ($jadwal === null)
                                            <p style="pointer-events: none;" class="btn btn-sm <?=($item -> status == 'Menunggu Dijadwalkan' ? 'btn-warning' : 'btn-success')?>">{{ $item -> status }}
                                        @else
                                            <a href="{{ route('datajadwalsempro') }}" class="btn btn-sm btn-primary">Lihat Jadwal</a>
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
