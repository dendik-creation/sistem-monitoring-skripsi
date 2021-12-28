@extends('admin.main')

@section('content')
    <div class="container-fluid mt-4">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-2 text-gray-800">Edit Dosen</h1>
        </div>

        {{-- Form --}}
        <form class="user" action="/admin/dosen/{{$data->nidn}}" method="POST">
            {{csrf_field()}}
            {{method_field('PUT')}}
            <div class="row mt-2">
                <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="small">NIDN*</label>
                            <input type="text" class="form-control" name="nidn" placeholder="Masukkan NIDN" value="{{ $data->nidn }}" required readonly>
                        </div>
                        <div class="form-group">
                            <label for="" class="small">Nama Lengkap*</label>
                            <input type="text" class="form-control" name="name" placeholder="Masukkan Nama Lengkap" value="{{ $data->name }}" required>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="" class="small">Gelar 1*</label>
                                <select class="form-control" name="gelar1">
                                    <option value="{{ $data->id_gelar1 }}">{{ $data->gelar1 }}</option>
                                    @foreach ($gelar1 as $item)
                                        <option value="{{ $item->id }}">{{ $item->gelar }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="" class="small">Gelar 2*</label>
                                <select class="form-control" name="gelar2">
                                    <option value="{{ $data->id_gelar2 }}">{{ $data->gelar2 }}</option>
                                    @foreach ($gelar2 as $item)
                                        <option value="{{ $item->id }}">{{ $item->gelar }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="" class="small">Gelar 3*</label>
                                <select class="form-control" name="gelar3">
                                    <option value="{{ $data->id_gelar3 }}">{{ $data->gelar3 }}</option>
                                    @foreach ($gelar3 as $item)
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
                            <input type="text" class="form-control" name="jabatan" placeholder="Masukkan Jabatan Fungsional" value="{{ $data->jabatan }}" required>
                        </div>
                        <div class="form-group">
                            <label for="" class="small">Bidang*</label>
                            <select class="form-control" name="id_bidang">
                                <option value="{{ $data->id_bidang }}">{{ $data->bidang }}</option>
                                @foreach ($bidang as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_bidang }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="" class="small">Email*</label>
                            <input type="email" class="form-control" name="email" placeholder="Masukkan Email" value="{{ $data->email }}" required>
                        </div>
                    </div>
                </div>
            </form>

    </div>
@endsection