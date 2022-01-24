@extends('admin.main')

@section('content')
    <div class="container-fluid mt-4">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-2 text-gray-800">Tambah Bidang</h1>
        </div>

        {{-- Form --}}
        <form class="user" action="/admin/insertbidangdosen" method="POST">
            {{csrf_field()}}
        <div class="row mt-2">
            <div class="col-md-6">
                    <div class="form-group">
                        <label for="" class="small">Bidang*</label>
                        <input type="text" class="form-control" name="nama_bidang" placeholder="Masukkan Bidang" required>
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