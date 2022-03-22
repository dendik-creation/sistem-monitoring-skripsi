@extends('mahasiswa.main')

@section('content')
    <div class="container-fluid mt-4">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard Mahasiswa</h1>

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
        <div class="row">
            <div class="col-md-12">
                <div class="mb-4">
                    <div class="card border-left-primary h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2 align-items-center">
                                    <div class="text-xs font-weight-bold text-secondary text-uppercase mb-2">NIM</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800 mb-4">{{ $user -> no_induk }}</div>
                                    <div class="text-xs font-weight-bold text-secondary text-uppercase mb-2">Nama</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800 mb-4">{{ $user -> name }}</div>
                                    <div class="text-xs font-weight-bold text-secondary text-uppercase mb-2">Email</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800 mb-4">
                                        @if ($mhs->email == '-')
                                            <a href="/mahasiswa/edit" class="btn btn-primary">Edit Email</a>
                                        @else
                                            {{ $mhs -> email  }}
                                        @endif
                                    </div>
                                    <div class="text-xs font-weight-bold text-secondary text-uppercase mb-2">No. Hp/WA</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800 mb-4">
                                        @if ($mhs->hp == '-')
                                            <a href="/mahasiswa/edit" class="btn btn-primary">Edit No. HP/WA</a>
                                        @else
                                            {{ $mhs -> hp  }}
                                        @endif
                                    </div>
                                </div>
                                <div class="col mr-2 align-items-center">
                                    <div class="text-xs font-weight-bold text-secondary text-uppercase mb-2">Pengajuan Proposal</div>
                                    {{-- hhhh --}}
                                    <div class="h5 mb-0 font-weight-bold text-gray-800 mb-4"> 
                                        @if ($mhs -> status_proposal == "Belum mengajukan proposal")
                                            <h5 style="pointer-events: none;" class="text-danger font-weight-bold">Belum mengajukan proposal</h5>
                                        @else
                                            <h5 style="pointer-events: none;" class="text-success font-weight-bold">Sudah mengajukan proposal</h5>
                                        @endif
                                    </div>
                                    <div class="text-xs font-weight-bold text-secondary text-uppercase mb-2">Seminar Proposal</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800 mb-4">
                                        @if ($mhs -> status_sempro == "Belum seminar proposal")
                                            <h5 style="pointer-events: none;" class="text-danger font-weight-bold">Belum seminar proposal</h5>
                                        @elseif($mhs -> status_sempro == "Sudah seminar proposal - Ditolak")
                                            <h5 style="pointer-events: none;" class="text-danger font-weight-bold">Sudah seminar proposal - Ditolak</h5>
                                        @elseif($mhs -> status_sempro == "Sudah seminar proposal - Diterima")
                                        <h5 style="pointer-events: none;" class="text-success font-weight-bold">Sudah seminar proposal - Diterima</h5>
                                        @endif
                                    </div>
                                    <div class="text-xs font-weight-bold text-secondary text-uppercase mb-2">Bimbingan Skripsi</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800 mb-4">
                                        @if ($mhs -> status_bimbingan == "Belum melakukan bimbingan")
                                            <h5 style="pointer-events: none;" class="text-danger font-weight-bold">Belum melakukan bimbingan</h5>
                                        @else
                                            <h5 class="h5 mb-0 font-weight-bold text-success">{{ $mhs->status_bimbingan }}</h5>
                                        @endif
                                    </div>
                                    <div class="text-xs font-weight-bold text-secondary text-uppercase mb-2">Ujian Skripsi</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800 mb-4">
                                        
                                        @if($mhs -> status_ujian == 'Belum ujian')
                                            <h5 style="pointer-events: none;" class="text-danger font-weight-bold">Belum ujian</h5>
                                        @elseif($mhs -> status_ujian == "Sudah ujian - Tidak Lulus")
                                        <h5 style="pointer-events: none;" class="text-danger font-weight-bold">Sudah ujian - Tidak Lulus</h5>
                                        @elseif($mhs -> status_ujian == "Sudah ujian - Lulus")
                                        <h5 style="pointer-events: none;" class="text-success font-weight-bold">Sudah ujian - Lulus</h5>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    

            </div>

        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="mb-4">
                    <div class="card border-left-primary h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center justify-content-center">
                                <div class="col-auto">
                                    <i class="fas fa-user-circle fa-5x text-gray-300"></i>
                                </div>
                                <div class="col mr-2 ml-4">
                                    <div class="text-xs font-weight-bold text-secondary text-uppercase mb-2">
                                        Dosen Pembimbing Utama</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">@if ($dosen1 -> depan == "Y")
                              {{ $dosen1 -> gelar3 }} {{ $dosen1 -> name }}, {{ $dosen1 -> gelar1 }}, {{ $dosen1 -> gelar2 }}
                          @else
                          @if ($dosen1->depan==null)
                          {{ $dosen1 -> name }}, {{ $dosen1 -> gelar1 }}, {{ $dosen1 -> gelar2 }}    
                          @else
                              
                          {{ $dosen1 -> name }}, {{ $dosen1 -> gelar1 }}, {{ $dosen1 -> gelar2 }}, {{ $dosen1 -> gelar3 }}
                          @endif
                          @endif</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    

            </div>

            <div class="col-md-6">
                <div class="mb-4">
                    <div class="card border-left-primary h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <i class="fas fa-user-circle fa-5x text-gray-300"></i>
                                </div>
                                <div class="col mr-2 ml-4">
                                    <div class="text-xs font-weight-bold text-secondary text-uppercase mb-2">
                                        Dosen Pembimbing Pembantu</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        @if ($dosen2==null)
                                            -
                                        @else
                        @if ($dosen2 -> depan == "Y")
                              {{ $dosen2 -> gelar3 }} {{ $dosen2 -> name }}, {{ $dosen2 -> gelar1 }}, {{ $dosen2 -> gelar2 }}
                          @else
                          @if ($dosen2->depan==null)
                          {{ $dosen2 -> name }}, {{ $dosen2 -> gelar1 }}, {{ $dosen2 -> gelar2 }}    
                          @else
                              
                          {{ $dosen2 -> name }}, {{ $dosen2 -> gelar1 }}, {{ $dosen2 -> gelar2 }}, {{ $dosen2 -> gelar3 }}
                          @endif
                          @endif
                        @endif
                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    

            </div>

        </div>

    </div>
@endsection