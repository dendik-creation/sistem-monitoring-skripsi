@extends('admin.main')

@section('content')
    <div class="container-fluid mt-4">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Rekap Penguji Skripsi</h1>
        </div>

        @if ($message = Session::get('success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
        </div>
        @endif

        @if ($message = Session::get('error'))
        <div class="alert alert-danger alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
        </div>
        @endif

        {{-- Form --}}
        <form class="user" action="/admin/rekap/penguji/skripsi/tampil" method="POST">
            {{csrf_field()}}
        <div class="row mt-2">
            <div class="col-md-6">
                    <div class="form-group">
                        <label for="" class="small">Pilih Semester*</label>
                        <select class="custom-select" id="filtersemesterrekappemsem" required name="idsmt">
                            <option value="" id="">Pilih Semester --</option>
                            @foreach ($data as $item)
                            <option value="{{ $item->id }}" id="{{ $item->id }}">{{ $item->semester }} {{ $item->tahun }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-primary mr-2">
                            Tampilkan
                        </button>
                        <a href="{{url()->previous()}}" class="btn btn-secondary">Batal</a>
                    </div>
                </div>
            </div>
        </form>


    </div>
@endsection
