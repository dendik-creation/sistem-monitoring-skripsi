@extends('dosen.main')

@section('content')
    <div class="container-fluid mt-4">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Mahasiswa Bimbingan</h1>
            <div class="pull-right">
                <select class="custom-select" id="filtermahasiswa">
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
                                <th>Proposal</th>
                                <th>Sempro</th>
                                <th>Bimbingan</th>
                                <th>Skripsi</th>
                                <th>Ujian</th>
                                <th>Detail</th>
                            </tr>
                        </thead>
                        <tbody id="datatabel">
                            <?php $no=1?>
                              @foreach($data as $item)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $item -> smt }}</td>
                                    <td>{{ $item -> nim }}</td>
                                    <td>{{ $item -> name }}</td>
                                    <td class="<?=$item -> status_proposal == "Belum mengajukan proposal" ? 'text-danger' : 'text-success'?>"><strong>{{ $item -> status_proposal }}</td>
                                    <td class="<?=$item -> status_sempro == "Sudah seminar proposal - Diterima" ? 'text-success' : 'text-danger'?>"><strong>{{ $item -> status_sempro }}</td>
                                    <td class="<?=$item -> status_bimbingan == "Belum melakukan bimbingan" ? 'text-danger' : 'text-success'?>"><strong>{{ $item -> status_bimbingan }}</td>
                                    <td class="<?=($item -> status_skripsi == "Belum mengerjakan" ? 'text-danger' : ($item -> status_skripsi == "Sedang dikerjakan" ? 'text-warning' : 'text-success'))?>"><strong>{{ $item -> status_skripsi }}</td>
                                    <td class="<?=$item -> status_ujian == "Sudah ujian - Lulus" ? 'text-success' : 'text-danger'?>"><strong>{{ $item -> status_ujian }}</td>
                                    {{-- <td>Sudah Seminar</td>
                                    <td>Bimbingan Ke-2</td> --}}
                                    <td><a href="/dosen/mahasiswa/detail/{{ $item->nim }}" class="btn btn-sm btn-primary">Lihat Detail</a></td>
                                </tr>
                           @endforeach
                        </tbody>
                    </table>
                </div>
    
            </div>
        </div>

        
    </div>
@endsection