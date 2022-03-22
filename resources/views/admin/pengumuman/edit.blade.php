@extends('admin.main')

@section('content')
    <div class="container-fluid mt-4">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-2 text-gray-800">Edit Pengumuman</h1>
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
        <form class="user" action="/admin/pengumuman/{{ $data->id }}" method="POST" enctype="multipart/form-data">
            {{csrf_field()}}
            {{method_field('PUT')}}
        <div class="row mt-2">
            <div class="col-md-8">
                    <div class="form-group">
                        <label for="" class="small">Judul*</label>
                        <input type="text" class="form-control" name="judul" placeholder="Masukkan Judul" value="{{ $data->judul }}" required>
                    </div>
                    <div class="form-group">
                        <label for="" class="small">Deskripsi*</label>
                        <textarea class="form-control deskripsi" id="deskripsi" name="deskripsi" id="" cols="30" rows="10" placeholder="Masukkan Deskripsi">{{ $data->deskripsi }}</textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="" class="small">Gambar* (JPG/PNG/PDF) (Max 2MB)</label><br>
                        <img src="{{ url('pengumuman/'.$data->gambar) }}" alt="" srcset="" height="100" width="auto">
                        <input type="file" name="gambar" placeholder="Masukkan Gambar" accept=".png, .jpg, .jpeg">
                    </div>
                    {{-- <div class="form-group">
                        <label for="" class="small">Tanggal*</label>
                        <input type="text" class="form-control" name="tanggal" placeholder="Masukkan Tanggal" value="<?=$tgl = date('Y-m-d')?>" required>
                    </div> --}}
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