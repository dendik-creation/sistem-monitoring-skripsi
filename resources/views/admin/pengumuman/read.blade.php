@extends('admin.main')

@section('content')
    <div class="container-fluid mt-4">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Data Pengumuman</h1>
            <div class="pull-right">
                <a href="/admin/pengumuman/tambah" class="btn btn-success btn-flat">
                    <i class="fa fa-plus"></i> Tambah Pengumuman
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
                                <th>Judul</th>
                                <th>Deskripsi</th>
                                <th>Gambar</th>
                                <th>Tanggal Upload</th>
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
                                    <td>{{ $item -> judul }}</td>
                                    @php
                                        $tampil = substr($item->deskripsi,3, 300);
                                    @endphp
                                    <td><?=$tampil?>...</td>
                                    <td><img src="{{ url('pengumuman/'.$item->gambar) }}" alt="" srcset="" height="100" width="auto"></td>
                                    <td><?=tgl_indo(substr($item->created_at, 0, 10), false);?></td>
                                    <td>
                                        <a href="/admin/pengumuman/edit/{{ $item->id }}" class="btn btn-primary btn-sm">Edit</a>
                                        <form action="/admin/pengumuman/{{$item->id}}" method="post">
                                            {{csrf_field()}}
                                            {{method_field('DELETE')}}
                                            <button type="submit" value="delete" class="btn btn-danger btn-sm mt-1" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                            </form>
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