@extends('dosen.main')

@section('content')
    <div class="container-fluid mt-4">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Hasil Akhir Seminar Proposal</h1>
            <div class="pull-right">
                @php
                    $smt = DB::table('semester')->get();
                @endphp
                <select class="custom-select" id="filtersemesterhasilsempro">
                    <option value="0" id="0">All</option>
                    @foreach ($smt as $item)
                    <option value="{{ $item->id }}" id="{{ $item->id }}">{{ $item->semester }} {{ $item->tahun }}</option>    
                    @endforeach
                </select>
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
                                <th>Semester</th>
                                <th>NIM</th>
                                <th>Nama</th>
                                <th>Judul</th>
                                <th>Total Nilai</th>
                                <th>Grade</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody id="datatabel">
                            <?php $no=1?>
                              @foreach($data as $item)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $item -> semester}} {{ $item -> tahun}}</td>
                                    <td>{{ $item -> nim}}</td>
                                    <td>{{ $item -> nama}}</td>
                                    <td>{{ $item -> judul}}</td>
                                    {{-- <td>{{ tgl_indo($item->tanggal, true)}}</td> --}}
                                    {{-- @php
                                    $ba = DB::table('hasil_sempro')
                                    ->join('jadwal_sempro', 'hasil_sempro.id_jadwal_sempro', '=', 'jadwal_sempro.id')
                                    ->where('id_jadwal_sempro', $item->id)->first();
                                    dd($ba);
                                    @endphp --}}
                                    {{-- <td><p style="pointer-events: none;" class="btn btn-sm <?=//($item->berita_acara == "Diterima" ? 'btn-success' : ($item->berita_acara == "Ditolak" ? 'btn-danger' : 'btn-warning' ))?>">{{ $item -> berita_acara }}</td> --}}
                                        {{-- <td><a href="/dosen/sempro/hasil/detail/{{ $item->id }}" class="btn btn-sm btn-primary">Detail</a></td> --}}
                                    <td>{{ $item -> nilai_akhir}}</td>
                                    <td>{{ $item -> grade_akhir}}</td>
                                    <td><a href="/sempro/hasil/cetak/{{ $item->id }}" target="_blank" class="btn btn-primary btn-sm">Cetak Dokumen</a></td>
                                </tr>
                           @endforeach
                        </tbody>
                    </table>
                </div>
    
            </div>
        </div>

        
    </div>
@endsection