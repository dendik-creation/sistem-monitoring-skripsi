@extends('admin.main')

@section('content')
    <div class="container-fluid mt-4">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-2 text-gray-800">Edit Plot Dosen Pembimbing</h1>
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
        <form class="user" action="/admin/proposal/plotting/{{ $data->id }}" method="POST">
        {{csrf_field()}}
        {{method_field('PUT')}}
        <div class="row mt-2">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="" class="small">Semester*</label>
                    <input type="text" class="form-control" name="smt" placeholder="Masukkan Semester" value="{{ $data->smt }}" required readonly>
                </div>
                <div class="form-group">
                    <label for="" class="small">NIM*</label>
                    <input type="text" class="form-control" name="nim" placeholder="Masukkan NIM" value="{{ $data->nim }}" required readonly>
                </div>
                <div class="form-group">
                    <label for="" class="small">Nama Lengkap*</label>
                    <input type="text" class="form-control" name="name" placeholder="Masukkan Nama Lengkap" value="{{ $data->name }}" required readonly>
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
                    <label for="" class="small">Dosen Pembimbing Utama*</label>
                    <select class="form-control" name="dosbing1">
                        {{-- <option>Dosen Pembimbing 1 --</option> --}}
                        @foreach($dosen1 as $item)
                            @if ($item->depan == "Y")
                                <option value="{{ $item->nidn }}" <?=$data->dosbing1 == $item->nidn ? 'selected' : '' ?>>{{ $item->gelar3 }} {{ $item->name }}, {{ $item->gelar1 }}, {{ $item->gelar2 }}</option>
                            @else
                            @if ($item->depan == null)
                            <option value="{{ $item->nidn }}" <?=$data->dosbing1 == $item->nidn ? 'selected' : '' ?>>{{ $item->name }}, {{ $item->gelar1 }}, {{ $item->gelar2 }}</option>
                            @else
                                
                            <option value="{{ $item->nidn }}" <?=$data->dosbing1 == $item->nidn ? 'selected' : '' ?>>{{ $item->name }}, {{ $item->gelar1 }}, {{ $item->gelar2 }}, {{ $item->gelar3 }} </option>
                            @endif
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="" class="small">Dosen Pembimbing Pembantu*</label>
                    <select class="form-control" name="dosbing2">
                        {{-- <option>Dosen Pembimbing 2 --</option> --}}
                        @foreach($dosen2 as $item)
                            @if ($item->depan == "Y")
                                <option value="{{ $item->nidn }}" <?=$data->dosbing2 == $item->nidn ? 'selected' : '' ?>>{{ $item->gelar3 }} {{ $item->name }}, {{ $item->gelar1 }}, {{ $item->gelar2 }}</option>
                            @else
                            @if ($item->depan == null)
                            <option value="{{ $item->nidn }}" <?=$data->dosbing2 == $item->nidn ? 'selected' : '' ?>>{{ $item->name }}, {{ $item->gelar1 }}, {{ $item->gelar2 }} </option>
                            @else
                                
                            <option value="{{ $item->nidn }}" <?=$data->dosbing2 == $item->nidn ? 'selected' : '' ?>>{{ $item->name }}, {{ $item->gelar1 }}, {{ $item->gelar2 }}, {{ $item->gelar3 }} </option>
                            @endif
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </form>

    </div>
@endsection