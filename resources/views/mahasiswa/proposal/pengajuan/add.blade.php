@extends('mahasiswa.main')

@section('content')
    <div class="container-fluid mt-4">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-2 text-gray-800">Ajukan Proposal</h1>
        </div>

        @if (count($errors) > 0)
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button> 
                    <strong>{{ $error }}</strong>
                </div>
            @endforeach
        @endif

        {{-- Form --}}
        <form class="user" action="/mahasiswa/insertproposal" method="POST" enctype="multipart/form-data">
            <div class="row mt-2">
                {{csrf_field()}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="" class="small">Semester*</label>
                        <input type="text" class="form-control" name="semester" placeholder="Masukkan Semester" value="{{ $smt->semester }} {{ $smt->tahun }}" required readonly>
                        <input type="hidden" value="{{ $smt->id }}" name="smt">
                    </div>
                    <div class="form-group">
                        <label for="" class="small">Topik*</label>
                        <select class="form-control" name="topik" required>
                            <option>Pilih Topik --</option>
                            <option>Website</option>
                            <option>Android</option>
                            <option>Jaringan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="" class="small">Judul*</label>
                        <input type="text" class="form-control" name="judul" placeholder="Masukkan Judul Skripsi" required>
                    </div>
                    <div class="form-group">
                        <label for="" class="small">Proposal*</label><br>
                        <input type="file" name="proposal" placeholder="Masukkan Berkas Proposal" required accept=".doc, .docx, .pdf">
                    </div>
                    <div class="form-group">
                        <label for="" class="small">Keterangan(Optional)</label><br>
                        <textarea class="form-control" name="komentar" placeholder="Masukkan Keterangan"></textarea>
                    </div>
                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-primary mr-2">
                            Ajukan
                        </button>
                        <a href="{{url()->previous()}}" class="btn btn-secondary">Batal</a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="" class="small">NIM*</label>
                        <input type="text" class="form-control" name="nim" placeholder="Masukkan NIM" value="{{ $user->no_induk }}" required readonly>
                    </div>
                    <div class="form-group">
                        <label for="" class="small">Nama Lengkap*</label>
                        <input type="text" class="form-control" name="name" placeholder="Masukkan Nama Lengkap" value="{{ $user->name }}" required readonly>
                    </div>
                    <div class="form-group">
                        <label for="" class="small">Dosen Pembimbing Utama*</label>
                        <input type="hidden" value="{{ $data->id }}" name="id_plot_dosbing">
                        <input type="email" class="form-control" name="dosbing1" placeholder="Masukkan Dosen Pembimbing Utama" value="{{ $dosen1->gelar3 }} {{ $dosen1->name }}, {{ $dosen1->gelar1 }}, {{ $dosen1->gelar2 }}" required readonly>
                    </div>
                    <div class="form-group">
                        <label for="" class="small">Dosen Pembimbing Pembantu*</label>
                        <input type="text" class="form-control" name="dosbing2" placeholder="Masukkan Dosen Pembimbing Pembantu" value="{{ $dosen2->gelar3 }} {{ $dosen2->name }}, {{ $dosen2->gelar1 }}, {{ $dosen2->gelar2 }}" required readonly>
                    </div>
                </div>
            </div>
        </form>

    </div>
@endsection