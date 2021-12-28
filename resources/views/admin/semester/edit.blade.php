@extends('admin.main')

@section('content')
    <div class="container-fluid mt-4">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-2 text-gray-800">Edit Semester Aktif</h1>
        </div>

        {{-- Form --}}
        <div class="row mt-2">
            <div class="col-md-6">
                <form class="user" action="/admin/semester/{{$data->id}}" method="POST">
                    {{csrf_field()}}
                    {{method_field('PUT')}}
                    <div class="form-group">
                        <label for="" class="small">Semester*</label>
                        <select class="form-control" name="semester">
                            <option>Pilih Topik --</option>
                            <option <?=$data->semester == "GASAL" ? 'selected' : ''?>>GASAL</option>
                            <option <?=$data->semester == "GENAP" ? 'selected' : ''?>>GENAP</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="" class="small">Tahun*</label>
                        <input type="text" class="form-control" name="tahun" placeholder="Masukkan Nama Lengkap" value="{{ $data->tahun }}" required>
                    </div>
                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-primary  mr-2">
                            Set Aktif
                        </button>
                        <a href="{{url()->previous()}}" class="btn btn-secondary ">Batal</a>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection