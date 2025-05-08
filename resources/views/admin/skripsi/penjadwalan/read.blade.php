@extends('admin.main')

@section('content')
    <div class="container-fluid mt-4">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Jadwal Ujian Skripsi</h1>
            <div class="pull-right">
                <div class="row">
                    <a href="/admin/berkas/ujian/exportexcel" class="btn btn-outline-success btn-flat mr-1">
                        <i class="fa fa-download"></i> Download Data Pendaftar Sudah OK
                    </a>
                    <a href="#" data-toggle="modal" data-target="#importExcel" class="btn btn-success btn-flat">
                        <i class="fa fa-calendar"></i> Import jadwal dari excel
                    </a>
                </div>
                <div class="row mt-2">
                    <select class="custom-select" id="filterjadwalujian">
                        <option value="3" id="3">All</option>
                        <option value="1" id="1">Belum dijadwalkan</option>
                        <option value="2" id="2">Sudah dijadwalkan</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="modal fade" id="importExcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form method="post" action="/admin/ujian/penjadwalan/importexcel" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Import Excel</h5>
                        </div>
                        <div class="modal-body">

                            {{ csrf_field() }}

                            <label for="" class="small">Pilih File Excel*</label>
                            <div class="form-group">
                                <input type="file" name="file" required>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Import</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @if (Session::has('import_errors'))
        <div class="alert alert-danger alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>Terjadi kesalahan saat import Excel:</strong>
            <ul class="mt-2 mb-0">
                @foreach (Session::get('import_errors') as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

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
                                <th>Judul</th>
                                <th>Status</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody id="datatabel">
                            <?php $no = 1; ?>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $item->semester }} {{ $item->tahun }}</td>
                                    <td>{{ $item->nim }}</td>
                                    <td>{{ $item->nama }}</td>
                                    <td>{{ $item->judul }}</td>
                                    {{-- <td>
                                        @if ($item->status1 == 'Belum' && $item->status2 == 'Belum')
                                        <p style="pointer-events: none;" class="btn btn-sm btn-warning">Belum ujian skripsi</p>
                                        @else
                                        @php
                                            $ba = DB::table('hasil_ujian')->where('id_jadwal_ujian', $item->id)->first();
                                            // dd($ba);
                                        @endphp
                                        <p style="pointer-events: none;" class="btn btn-sm btn-success">Sudah ujian skripsi</p>  - <p style="pointer-events: none;" class="btn btn-sm <?= $ba->berita_acara == 'Lulus' ? 'btn-success' : 'btn-danger' ?>">{{ $ba->berita_acara }}</p>
                                        @endif
                                    </td>
                                    <td><a href="/admin/skripsi/penjadwalan/detail/{{$item->id}}" class="btn btn-sm btn-primary">Lihat detail</td> --}}
                                    <td>
                                        @if ($item->status == 'Berkas OK')
                                            <p style="pointer-events: none;" class="btn btn-sm btn-warning">Belum
                                                dijadwalkan</p>
                                        @elseif($item->status == 'Terjadwal')
                                            <p style="pointer-events: none;" class="btn btn-sm btn-success">Sudah
                                                dijadwalkan</p>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->status == 'Berkas OK')
                                            <a href="/admin/skripsi/pendaftar/detail/{{ $item->id }}"
                                                class="btn btn-sm btn-primary">Jadwalkan manual
                                            @elseif($item->status == 'Terjadwal')
                                                <a href="/admin/skripsi/penjadwalan/detail/{{ $item->id }}"
                                                    class="btn btn-sm btn-primary">Lihat detail
                                        @endif
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
