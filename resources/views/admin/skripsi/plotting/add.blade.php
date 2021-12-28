@extends('admin.main')

@section('content')
    <div class="container-fluid mt-4">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-2 text-gray-800">Tambah Satu Mahasiswa</h1>
        </div>

        {{-- Form --}}
        <form class="user" action="/admin/skripsi/plotting/insert" method="POST">
        {{csrf_field()}}
        <div class="row mt-2">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="" class="small">Semester*</label>
                    <input type="text" class="form-control" name="smt" placeholder="Masukkan Semester" value="{{ $smt->semester }} {{ $smt->tahun }}" required readonly>
                </div>
                <div class="form-group">
                    <label for="" class="small">NIM*</label>
                    <input type="text" class="form-control" name="nim" placeholder="Masukkan NIM" required>
                </div>
                <div class="form-group">
                    <label for="" class="small">Nama Lengkap*</label>
                    <input type="text" class="form-control" name="name" placeholder="Masukkan Nama Lengkap" required>
                </div>
                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-primary mr-2">
                        Simpan
                    </button>
                    <a href="{{url()->previous()}}" class="btn btn-secondary">Batal</a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="" class="small">Ketua Penguji*</label>
                    <select class="form-control" name="ketua">
                        <option>Ketua Penguji --</option>
                        @foreach($dosen1 as $item)
                            <option value="{{ $item->nidn }}">{{ $item->gelar3 }} {{ $item->name }}, {{ $item->gelar1 }}, {{ $item->gelar2 }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="" class="small">Anggota Penguji 1*</label>
                    <select class="form-control" name="anggota1">
                        <option>Anggota Penguji 1 --</option>
                        @foreach($dosen1 as $item)
                            <option value="{{ $item->nidn }}">{{ $item->gelar3 }} {{ $item->name }}, {{ $item->gelar1 }}, {{ $item->gelar2 }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="" class="small">Anggota Penguji 2*</label>
                    <select class="form-control" name="anggota2">
                        <option>Anggota Penguji 2 --</option>
                        @foreach($dosen3 as $item)
                            <option value="{{ $item->nidn }}">{{ $item->gelar3 }} {{ $item->name }}, {{ $item->gelar1 }}, {{ $item->gelar2 }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </form>

    </div>
@endsection