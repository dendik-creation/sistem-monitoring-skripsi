@extends('mahasiswa.main')

@section('content')
    <div class="container-fluid mt-4">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-2 text-gray-800">Tambah Bimbingan</h1>
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
        <form class="user" action="/mahasiswa/insertbimbingan" method="POST" enctype="multipart/form-data">
            <div class="row mt-2">
                {{csrf_field()}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="" class="small">Semester*</label>
                        <input type="hidden" value="{{ $smt->id }}" name="smt">
                        <input type="text" class="form-control" name="semester" placeholder="Masukkan Semester" value="{{ $smt->semester }} {{ $smt->tahun }}" required readonly>
                    </div>
                    <div class="form-group">
                        <label for="" class="small">Judul*</label>
                        <input type="hidden" value="{{ $dataprop->id }}" name="id_proposal">
                        <input type="text" class="form-control" name="judul" placeholder="Masukkan Judul Skripsi" value="<?=$dataprop === null ? 'Belum di ACC' : $dataprop->judul ?>" required readonly>
                    </div>
                    <div class="form-group">
                        <label for="" class="small">Bimbingan Ke*</label>
                        <input type="number" class="form-control" name="bimbingan_ke">
                    </div>
                    {{-- <div class="form-group">
                        <label for="" class="small">BAB*</label>
                        <select class="form-control" name="bab">
                            <option>Pilih --</option>
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                        </select>
                    </div> --}}
                    <div class="form-group">
                        <label for="" class="small">File*</label><br>
                        <input type="file" name="file_bimbingan" placeholder="Masukkan File" required accept=".doc, .docx, .pdf">
                    </div>
                    <div class="form-group">
                        <label for="" class="small">Keterangan(Optional)</label><br>
                        <textarea class="form-control" name="komentar" placeholder="Masukkan Keterangan"></textarea>
                    </div>
                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-primary mr-2">
                            Tambah
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
                        <label for="" class="small">Dosen Pembimbing 1*</label>
                        <input type="hidden" value="{{ $data->id }}" name="id_plot_dosbing">
                        <input type="email" class="form-control" name="dosbing1" placeholder="Masukkan Dosen Pembimbing 1" value="@if ($data -> depan1 == "Y")
                              {{ $data -> gelar31 }} {{ $data -> dosbing1 }}, {{ $data -> gelar11 }}, {{ $data -> gelar21 }}
                          @else
                              {{ $data -> dosbing1 }}, {{ $data -> gelar11 }}, {{ $data -> gelar21 }}, {{ $data -> gelar31 }}
                          @endif" required readonly>
                    </div>
                    <div class="form-group">
                        <label for="" class="small">Dosen Pembimbing 2*</label>
                        <input type="email" class="form-control" name="dosbing1" placeholder="Masukkan Dosen Pembimbing 1" value="@if ($data -> depan2 == "Y")
                              {{ $data -> gelar32 }} {{ $data -> dosbing2 }}, {{ $data -> gelar12 }}, {{ $data -> gelar22 }}
                          @else
                              {{ $data -> dosbing2 }}, {{ $data -> gelar12 }}, {{ $data -> gelar22 }}, {{ $data -> gelar32 }}
                          @endif" required readonly>
                    </div>
                </div>
            </div>
        </form>

    </div>
@endsection