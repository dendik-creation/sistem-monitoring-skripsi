@extends('mahasiswa.main')

@section('content')
    <div class="container-fluid mt-4">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-2 text-gray-800">Pendaftaran Ujian Skripsi</h1>
        </div>

        {{-- Form --}}
        <form class="user" action="/mahasiswa/insertujian" method="POST" enctype="multipart/form-data">
            <div class="row mt-2">
                {{csrf_field()}}
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
                        <label for="" class="small">Email*</label>
                        <input type="text" class="form-control" name="email" placeholder="Masukkan Email Aktif" value="{{ $datamhs->email }}" required readonly>
                    </div>
                    <div class="form-group">
                        <label for="" class="small">No. HP/WA*</label>
                        <input type="text" class="form-control" name="hp" placeholder="Masukkan No. HP/WA" value="{{ $datamhs->hp }}" required readonly>
                    </div>
                    <div class="form-group">
                        <label for="" class="small">Judul*</label>
                        <input type="hidden" value="{{ $dataprop->id }}" name="id_proposal">
                        <input type="text" class="form-control" name="judul" placeholder="Masukkan Judul Skripsi" value="<?=$dataprop === null ? 'Belum di ACC' : $dataprop->judul ?>" required readonly>
                    </div>
                    
                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-primary mr-2" <?=$dataprop === null ? 'disabled' : '' ?>>
                            Daftar
                        </button>
                        <a href="{{url()->previous()}}" class="btn btn-secondary">Batal</a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="" class="small">Dosen Pembimbing Utama*</label>
                        <input type="hidden" value="{{ $datapenguji->id }}" name="id_plot_penguji">
                        <input type="email" class="form-control" name="dosbing1" placeholder="Masukkan Dosen Pembimbing 1" value="{{ $dosen1->gelar3 }} {{ $dosen1->name }}, {{ $dosen1->gelar1 }}, {{ $dosen1->gelar2 }}" required readonly>
                    </div>
                    <div class="form-group">
                        <label for="" class="small">Dosen Pembimbing Pembantu*</label>
                        <input type="text" class="form-control" name="dosbing2" placeholder="Masukkan Dosen Pembimbing 2" value="{{ $dosen2->gelar3 }} {{ $dosen2->name }}, {{ $dosen2->gelar1 }}, {{ $dosen2->gelar2 }}" required readonly>
                    </div>
                    <div class="form-group">
                        <label for="" class="small">Berkas (ZIP)*</label><br>
                        <input type="file" name="berkas_ujian" placeholder="Masukkan Berkas Ujian Skripsi" required  accept=".zip,.rar,.7zip">
                    </div>
                </div>
            </div>
        </form>

    </div>
@endsection