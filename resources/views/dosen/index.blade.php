@extends('dosen.main')

@section('content')
    <div class="container-fluid mt-4">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard Dosen</h1>

        </div>

            @if ($propwaitacc>10)
            <div class="alert alert-warning alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button> 
                <strong>Anda memiliki 10 lebih proposal mahasiswa yang menunggu review. Silakan review <a href="/mahasiswa/skripsi/bimbingan/tambah">di sini.</a></strong>
            </div>  
            @endif          
            @if($bimbwaitacc>10)
            <div class="alert alert-warning alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button> 
            <strong>Anda memiliki 10 lebih bimbingan mahasiswa yang menunggu review. Silakan review <a href="/mahasiswa/skripsi/bimbingan/tambah/2">di sini.</a></strong>
            </div>
            @endif

        <!-- Content Row -->
        <div class="row">
            <div class="col-md-6">
                <a href="{{ route('datamhsbimbingan') }}" style="text-decoration:none;">
                <div class="mb-4">
                    <div class="card border-left-primary h-200 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center justify-content-center">
                                <div class="col-auto">
                                    <i class="fas fa-user-circle fa-5x text-gray-300"></i>
                                </div>
                                <div class="col mr-2 ml-4">
                                    <div class="text-xs font-weight-bold text-secondary text-uppercase mb-2">
                                        Total Mahasiswa Bimbingan</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalmhs }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </a>
            </div>

            <div class="col-md-6">
                <a href="{{ route('dataskripsimahasiswa') }}" style="text-decoration:none;">
                <div class="mb-4">
                    <div class="card border-left-primary h-200 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center justify-content-center">
                                <div class="col-auto">
                                    <i class="fas fa-user-circle fa-5x text-gray-300"></i>
                                </div>
                                <div class="col mr-2 ml-4">
                                    <div class="text-xs font-weight-bold text-secondary text-uppercase mb-2">
                                        Mahasiswa Mengerjakan Skripsi</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalmhsskripsi }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </a>
            </div>

        </div>



        <div class="row">
            <div class="col-md-6">
                <a href="/dosen/monitoring/proposal" style="text-decoration:none;">
                <div class="mb-4">
                    <div class="card border-left-warning h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center justify-content-center">
                                <div class="col-auto">
                                    <i class="fas fa-fw fa-file fa-5x text-gray-300"></i>
                                </div>
                                <div class="col mr-2 ml-4">
                                    <div class="text-xs font-weight-bold text-secondary text-uppercase mb-2">
                                        Proposal Menunggu ACC</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $propwaitacc }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </a>
            </div>

            <div class="col-md-6">
                <a href="{{ route('datajadwalsemprodosen') }}" style="text-decoration:none;">
                <div class="mb-4">
                    <div class="card border-left-warning h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center justify-content-center">
                                <div class="col-auto">
                                    <i class="fas fa-fw fa-file fa-5x text-gray-300"></i>
                                </div>
                                <div class="col mr-2 ml-4">
                                    <div class="text-xs font-weight-bold text-secondary text-uppercase mb-2">
                                        Undangan Seminar Proposal</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jadwalsempro }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <a href="/dosen/monitoring/bimbingan" style="text-decoration:none;">
                <div class="mb-4">
                    <div class="card border-left-warning h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center justify-content-center">
                                <div class="col-auto">
                                    <i class="fas fa-fw fa-file fa-5x text-gray-300"></i>
                                </div>
                                <div class="col mr-2 ml-4">
                                    <div class="text-xs font-weight-bold text-secondary text-uppercase mb-2">
                                        Bimbingan Review</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $bimbwaitacc }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </a>
            </div>
            
            <div class="col-md-6">
                <a href="{{ route('datajadwalujiandosen') }}" style="text-decoration:none;">
                <div class="mb-4">
                    <div class="card border-left-warning h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center justify-content-center">
                                <div class="col-auto">
                                    <i class="fas fa-fw fa-book fa-5x text-gray-300"></i>
                                </div>
                                <div class="col mr-2 ml-4">
                                    <div class="text-xs font-weight-bold text-secondary text-uppercase mb-2">
                                        Undangan Ujian Skripsi</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jadwalujian }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </a>
            </div>

        </div>

    </div>
@endsection