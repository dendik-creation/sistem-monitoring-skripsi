@extends('admin.main')

@section('content')
    <div class="container-fluid mt-4">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-2 text-gray-800">Edit Mahasiswa</h1>
        </div>

        {{-- Form --}}
        <div class="row mt-2">
            <div class="col-md-6">
                <form class="user" action="/admin/mahasiswa/{{$data->nim}}" method="POST">
                    {{csrf_field()}}
                    {{method_field('PUT')}}
                    <div class="form-group">
                        <label for="" class="small">NIM*</label>
                        <input type="text" class="form-control " name="nim" placeholder="Masukkan NIM" value="{{ $data->nim }}" required>
                    </div>
                    <div class="form-group">
                        <label for="" class="small">Nama Lengkap*</label>
                        <input type="text" class="form-control " name="name" placeholder="Masukkan Nama Lengkap" value="{{ $data->name }}" required>
                    </div>
                    <div class="form-group">
                        <label for="" class="small">Email*</label>
                        <input type="email" class="form-control " name="email" placeholder="Masukkan Email" value="{{ $data->email }}" required>
                    </div>
                    <div class="form-group">
                        <label for="" class="small">No. Hp/WA*</label>
                        <input type="number" class="form-control " name="hp" placeholder="Masukkan No. Hp/WA" value="{{ $data->hp }}" required>
                    </div>
                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-primary  mr-2">
                            Simpan
                        </button>
                        <a href="{{url()->previous()}}" class="btn btn-secondary ">Batal</a>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection