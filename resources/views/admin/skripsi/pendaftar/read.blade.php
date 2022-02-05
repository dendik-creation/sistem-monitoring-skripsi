@extends('admin.main')

@section('content')
    <div class="container-fluid mt-4">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Pendaftar Ujian Skripsi</h1>
            
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
                                <th>NIM</th>
                                <th>Nama</th>
                                <th>Tanggal Daftar</th>
                                <th>Berkas</th>
                                <th>Aksi</th>
                                {{-- <th>Opsi</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1?>
                              @foreach($data as $item)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $item -> semester }} {{ $item -> tahun }}</td>
                                    <td>{{ $item -> nim }}</td>
                                    <td>{{ $item -> nama }}</td>
                                    <td><?=tgl_indo(substr($item->tgl_daftar, 0, 10), true);?></td>
                                    <td><a href="/download/{{ $item->nim }}/berkas_ujian/{{$item->berkas_ujian}}"><?=$item->berkas_ujian == null ? '' : 'Download berkas ujian'?></a></td>
                                    @if ($item->status == "Berkas OK")
                                        <td>Berkas OK</td>
                                    @elseif($item->status == "Berkas tidak lengkap")
                                        <td>Berkas tidak lengkap - {{ $item->komentar }}</td>
                                    @else
                                        <td>
                                            <form action="/admin/berkas/ujian/ok/{{ $item->id }}" method="POST">
                                                {{csrf_field()}}
                                                {{method_field('PUT')}}
                                                <button type="submit" value="Berkas OK" class="btn btn-sm btn-primary mb-1">Berkas OK</button>
                                            </form>
                                        
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal{{$item->id}}">
                                                Berkas tidak lengkap
                                            </button>
                                            <!-- Modal -->
                                            <div class="modal fade" id="modal{{$item->id}}" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Komentar</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    </div>
                                                    <form class="user" method="POST" action="/admin/berkas/ujian/kurang/{{ $item->id }}">
                                                        {{csrf_field()}}
                                                        {{method_field('PUT')}}
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="" class="small">Komentar*</label>
                                                                <textarea class="form-control" name="komentar_admin" placeholder="Masukkan Komentar" required></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        <button type="submit" name="submit" class="btn btn-primary">Komentar</button>
                                                        </div>
                                                    </form>
                                                </div>
                                                </div>
                                            </div>
                                        </td>
                                    @endif
                                    {{-- <td><a href="/admin/skripsi/pendaftar/detail/{{$item->id}}" class="btn btn-primary btn-sm">Lihat detail</td> --}}
                                </tr>
                           @endforeach
                        </tbody>
                    </table>
                </div>
    
            </div>
        </div>

        
    </div>
@endsection