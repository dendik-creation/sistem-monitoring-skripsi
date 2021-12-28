@extends('dosen.main')

@section('content')
    <div class="container-fluid mt-4">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-2 text-gray-800">Edit Profil</h1>
        </div>

        @if (session('status'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button> 
                <strong>{{ session('status') }}</strong>
            </div>
        @endif

        {{-- Form --}}
        <form class="user" action="/dosen/{{$data->nidn}}" method="POST" enctype="multipart/form-data">
            <div class="row mt-2">
                {{csrf_field()}}
                {{method_field('PUT')}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="" class="small">NIDN*</label>
                        <input type="text" class="form-control form-control-user" name="nidn" placeholder="Masukkan NIDN" value="{{ $data->nidn }}" required readonly>
                    </div>
                    <div class="form-group">
                        <label for="" class="small">Nama Lengkap*</label>
                        <input type="text" class="form-control form-control-user" name="name" placeholder="Masukkan Nama Lengkap" value="{{ $data->gelar3 }} {{ $data->name }}, {{ $data->gelar1 }}, {{ $data->gelar2 }}" required readonly>
                    </div>
                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-primary btn-user mr-2">
                            Simpan
                        </button>
                        <a href="{{url()->previous()}}" class="btn btn-secondary btn-user">Batal</a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="" class="small">Email*</label>
                        <input type="email" class="form-control form-control-user" name="email" placeholder="Masukkan Email" value="{{ $data->email }}" required>
                    </div>
                    <div class="form-group">
                        <label for="" class="small">Foto</label><br>
                        <input type="file" name="photo" accept="image/*">
                    </div>
                </div>
            </div>
        </form>

        <div class="d-sm-flex align-items-center justify-content-between mb-2 mt-4">
            <h1 class="h3 mb-2 text-gray-800">Ganti Password</h1>
        </div>

        <form class="user" method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="row mt-2 mb-4">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="" class="small">Email*</label>
                        <input id="email" type="email" class="form-control form-control-user @error('email') is-invalid @enderror" name="email" value="{{ $data->email }}" required autocomplete="email" placeholder="Masukkan Email" readonly>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                    </div>
                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-danger btn-user mr-2">
                            Ganti Password
                        </button>
                    </div>
                    {{-- <a class="small" href="{{ route('password.request') }}">
                        {{ __('Lupa Password?') }}
                    </a> --}}
                </div>
            </div>
        </form>

    </div>
@endsection