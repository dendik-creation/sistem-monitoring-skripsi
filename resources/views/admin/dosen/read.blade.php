@extends('admin.main')

@section('content')
    <div class="container-fluid mt-4">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Data Dosen</h1>
            <div class="pull-right">
                <a href="/admin/dosen/tambah" class="btn btn-success btn-flat">
                    <i class="fa fa-plus"></i> Tambah Dosen
                </a>
            </div>
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
                                <th>NIDN</th>
                                <th>Nama Dosen</th>
                                <th>Jabatan Fungsional</th>
                                <th>Bidang</th>
                                <th>Email</th>
                                <th>Opsi</th>
                                {{-- <th>Edit</th> --}}
                                {{-- <th>Hapus</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1?>
                              @foreach($data as $item)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $item -> nidn }}</td>
                                    <td>
                                        @if ($item -> depan == "Y")
                                            {{ $item -> gelar3 }} {{ $item -> name }}, {{ $item -> gelar1 }}, {{ $item -> gelar2 }}
                                        @else
                                            {{ $item -> name }}, {{ $item -> gelar1 }}, {{ $item -> gelar2 }}, {{ $item -> gelar3 }}
                                        @endif
                                    </td>
                                    <td>{{ $item -> jabatan }}</td>
                                    <td>{{ $item -> bidang }}</td>
                                    <td>{{ $item -> email }}</td>
                                    <td>
                                        <a href="/admin/dosen/edit/{{$item->nidn}}" class="btn btn-primary btn-sm">Edit</a>
                                    </td>
                                    {{-- <td>
                                        <form action="/admin/dosen/{{$item->nidn}}" method="post">
                                        {{csrf_field()}}
                                        {{method_field('DELETE')}}
                                        <button type="submit" value="delete" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                        </form>
                                    </td> --}}
                                    
                                </tr>
                           @endforeach
                        </tbody>
                    </table>
                </div>
    
            </div>
        </div>

        
    </div>
@endsection