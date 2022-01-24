@extends('admin.main')

@section('content')
    <div class="container-fluid mt-4">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-2 text-gray-800">Edit Gelar</h1>
        </div>

        {{-- Form --}}
        <form class="user" action="/admin/dosen/s1/{{$data->id}}" method="POST">
            {{csrf_field()}}
            {{method_field('PUT')}}
            <div class="row mt-2">
                <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="small">Gelar*</label>
                            <input type="text" class="form-control" name="gelar" placeholder="Masukkan Gelar" value="{{ $data->gelar }}" required>
                        </div>
                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary mr-2">
                                Simpan
                            </button>
                            <a href="{{url()->previous()}}" class="btn btn-secondary">Batal</a>
                        </div>
                    </div>
                </div>
            </form>

    </div>
@endsection