@extends('admin.main')

@section('content')
    <div class="container-fluid mt-4">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Data Semester</h1>
            {{-- <div class="pull-right">
                <a href="/admin/mahasiswa/tambah" class="btn btn-success btn-flat">
                    <i class="fa fa-plus"></i> Tambah Mahasiswa
                </a>
            </div> --}}
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

        <!-- Content Row -->
        <div class="card shadow">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="dataTable" style="width:100%" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Semester</th>
                                <th>Tahun</th>
                                <th>Status</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1?>
                              @foreach($data as $item)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $item -> semester }}</td>
                                    <td>{{ $item -> tahun }}</td>
                                    <td>
                                        @if ($item -> aktif == 'Y')
                                        <p style="pointer-events: none;" class="btn btn-sm btn-success">Aktif</p>
                                        @else
                                            Tidak
                                        @endif
                                    </td>
                                    <td>
                                        <a href="/admin/semester/edit/{{$item->id}}" class="btn btn-primary btn-sm">Ganti Status</a>
                                    </td>
                                </tr>
                           @endforeach
                        </tbody>
                    </table>
                </div>
    
            </div>
        </div>

        
    </div>
@endsection