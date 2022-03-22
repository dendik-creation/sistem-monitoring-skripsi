@extends('dosen.main')

@section('content')
    <div class="container-fluid mt-4">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Jadwal Seminar Proposal</h1>
            {{-- <div class="pull-right">
                <a href="/mahasiswa/proposal/tambah" class="btn btn-success btn-flat">
                    <i class="fa fa-plus"></i> Ajukan
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
                                <th>NIM</th>
                                <th>Nama</th>
                                <th>Judul</th>
                                {{-- <th>Berkas</th> --}}
                                <th>Tanggal</th>
                                <th>Jam</th>
                                <th>Tempat</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1?>
                              @foreach($data as $item)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $item -> nim}}</td>
                                    <td>{{ $item -> nama}}</td>
                                    <td>{{ $item -> judul}}</td>
                                    {{-- <td><a href="/download/{{ $item->nim }}/berkas_sempro/{{$item->berkas_sempro}}">{{$item->berkas_sempro}}</td> --}}
                                    <td>{{ tgl_indo($item->tanggal, true)}}</td>
                                    <td>{{ $item -> jam }} WIB</td>
                                    <td>{{ $item -> tempat }}</td>
                                    <td>
                                        {{-- <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal{{$item->id}}">
                                            Update Hasil
                                        </button>
                                        <!-- Modal -->
                                        <div class="modal fade" id="modal{{$item->id}}" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Update Hasil Seminar Proposal</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                </div>
                                                <form action="/dosen/sempro/inserthasil" method="post">
                                                    {{csrf_field()}}
                                                    {{method_field('POST')}}
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <input type="hidden" name="nim" value="{{ $item->nim }}">
                                                            <input type="hidden" name="id_proposal" value="{{ $item->id_proposal }}">
                                                            <input type="hidden" name="id_jadwal_sempro" value="{{ $item->id }}">
                                                            <label for="" class="small">Status*</label>
                                                            <select class="form-control" name="status">
                                                                <option>Pilih Status --</option>
                                                                <option>Lulus</option>
                                                                <option>Tidak Lulus</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="" class="small">Nilai*</label>
                                                            <select class="form-control" name="nilai">
                                                                <option>Pilih Nilai --</option>
                                                                <option>A</option>
                                                                <option>AB</option>
                                                                <option>B</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" name="submit" class="btn btn-primary">Kirim</button>
                                                    </div>
                                                </form>
                                            </div>
                                            </div>
                                        </div> --}}

                                        <a href="/sempro/jadwal/cetak/{{ $item->jadwal_sempro_id }}" target="_blank" class="btn btn-primary btn-sm">Lihat Undangan</a>
                                        
                                        <a href="/dosen/sempro/jadwal/detail/{{ $item->jadwal_sempro_id }}" class="btn btn-primary btn-sm mt-1">Detail & Penilaian</a>
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