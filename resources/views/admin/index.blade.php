@extends('admin.main')

@section('content')
    <div class="container-fluid mt-4">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard Admin</h1>

        </div>

        <!-- Content Row -->
        <div class="row">
            <div class="col-md-6">
                <a href="{{ route('datadosen') }}" style="text-decoration:none;">
                <div class="mb-4">
                    <div class="card border-left-primary h-200 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center justify-content-center">
                                <div class="col-auto">
                                    <i class="fas fa-user fa-5x text-gray-300"></i>
                                </div>
                                <div class="col mr-2 ml-4">
                                    <div class="text-xs font-weight-bold text-secondary text-uppercase mb-2">
                                        Jumlah Dosen</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $dosen }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </a>
            </div>

            <div class="col-md-6">
                <a href="{{ route('datamahasiswa') }}" style="text-decoration:none;">
                <div class="mb-4">
                    <div class="card border-left-primary h-200 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center justify-content-center">
                                <div class="col-auto">
                                    <i class="fas fa-user-circle fa-5x text-gray-300"></i>
                                </div>
                                <div class="col mr-2 ml-4">
                                    <div class="text-xs font-weight-bold text-secondary text-uppercase mb-2">
                                        Jumlah Mahasiswa</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $mhs }}</div>
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
                <a href="{{ route('dataproposalpendaftar') }}" style="text-decoration:none;">
                <div class="mb-4">
                    <div class="card border-left-warning h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center justify-content-center">
                                <div class="col-auto">
                                    <i class="fas fa-fw fa-file fa-5x text-gray-300"></i>
                                </div>
                                <div class="col mr-2 ml-4">
                                    <div class="text-xs font-weight-bold text-secondary text-uppercase mb-2">
                                        Pendaftar Seminar Proposal</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jadwalsempro }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </a>
            </div>

            <div class="col-md-6">
                <a href="{{ route('dataskripsipendaftar') }}" style="text-decoration:none;">
                <div class="mb-4">
                    <div class="card border-left-warning h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center justify-content-center">
                                <div class="col-auto">
                                    <i class="fas fa-fw fa-book fa-5x text-gray-300"></i>
                                </div>
                                <div class="col mr-2 ml-4">
                                    <div class="text-xs font-weight-bold text-secondary text-uppercase mb-2">
                                        Pendaftar Ujian Skripsi</div>
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