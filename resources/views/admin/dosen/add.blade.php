@extends('admin.main')

@section('content')
    <div class="container-fluid mt-4">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-2 text-gray-800">Tambah Dosen</h1>
        </div>

        @if (count($errors) > 0)
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ $error }}</strong>
                </div>
            @endforeach
        @endif

        @if ($message = Session::get('error'))
        <div class="alert alert-danger alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
        </div>
        @endif

        {{-- Form --}}
        <form class="user" action="/admin/insertdosen" method="POST" enctype="multipart/form-data">
            {{csrf_field()}}
        <div class="row mt-2">
            <div class="col-md-6">
                    <div class="form-group">
                        <label for="" class="small">NIDN*</label>
                        <input type="text" class="form-control" name="nidn" value="{{ old('nidn') }}" placeholder="Masukkan NIDN" required>
                    </div>
                    <div class="form-group">
                        <label for="" class="small">Nama Lengkap*</label>
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Masukkan Nama Lengkap" required>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="" class="small">Gelar S1*</label>
                            <select class="form-control" name="gelar1" value="{{ old('gelar1') }}">
                                <option value="">Pilih Gelar --</option>
                                @foreach ($gelar1 as $item)
                                    <option value="{{ $item->id }}" {{ old('gelar1') == $item->id ? 'selected' : '' }}>
                                        {{ $item->gelar }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="" class="small">Gelar S2</label>
                            <select class="form-control" name="gelar2" value="{{ old('gelar2') }}">
                                <option value="">Pilih Gelar --</option>
                                @foreach ($gelar2 as $item)
                                    <option value="{{ $item->id }}" {{ old('gelar2') == $item->id ? 'selected' : '' }}>
                                        {{ $item->gelar }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="" class="small">Gelar S3 Depan</label>
                            <select class="form-control" name="gelar3d" value="{{ old('gelar3d') }}">
                                <option value="">Pilih Gelar --</option>
                                @foreach ($gelar3depan as $item)
                                    <option value="{{ $item->id }}" {{ old('gelar3d') == $item->id ? 'selected' : '' }}>
                                        {{ $item->gelar }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="" class="small">Gelar S3 Belakang</label>
                            <select class="form-control" name="gelar3b" value="{{ old('gelar3b') }}">
                                <option value="">Pilih Gelar --</option>
                                @foreach ($gelar3belakang as $item)
                                    <option value="{{ $item->id }}">{{ $item->gelar }}</option>
                                @endforeach
                            </select>
                        </div>
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
                        <label for="" class="small">Jabatan Fungsional*</label>
                        <select class="form-control" name="jabatan" value="{{ old('jabatan') }}">
                            <option value="">Pilih Jabatan Fungsional --</option>
                            <option value="Asisten Ahli" {{ old('jabatan') == 'Asisten Ahli' ? 'selected' : '' }}>Asisten Ahli</option>
                            <option value="Lektor" {{ old('jabatan') == 'Lektor' ? 'selected' : '' }}>Lektor</option>
                            <option value="Lektor Kepala" {{ old('jabatan') == 'Lektor Kepala' ? 'selected' : '' }}>Lektor Kepala</option>
                            <option value="Guru Besar" {{ old('jabatan') == 'Guru Besar' ? 'selected' : '' }}>Guru Besar</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="" class="small">Bidang*</label>
                        <select class="form-control" name="id_bidang" required>
                            <option value="">Pilih Bidang --</option>
                            @foreach ($bidang as $item)
                                <option value="{{ $item->id }}" {{ old('id_bidang') == $item->id ? 'selected' : '' }}>
                                    {{ $item->nama_bidang }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="" class="small">Email*</label>
                        <input type="email" class="form-control" name="email" placeholder="Masukkan Email"  value="{{ old('email') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="" class="small">Scan Tanda Tangan*</label><br>
                        <input type="file" name="ttd" placeholder="Masukkan Scan Tanda Tangan" required accept=".png, .jpg, .jpeg">
                    </div>
                </div>
            </div>
        </form>

    </div>
@endsection
