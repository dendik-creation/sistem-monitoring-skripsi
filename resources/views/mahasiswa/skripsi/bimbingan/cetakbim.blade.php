@extends('mahasiswa.main')

@section('content')
    <div class="container-fluid mt-4">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Bimbingan Kepada Dosen Pembimbing Utama</h1>
            <div class="pull-right">
                <div class="row">
                    <a class="btn btn-flat btn-primary mr-2" href="/mahasiswa/skripsi/bimbingan/cetak" target="_blank">Cetak PDF</a>
                </div>
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
                    <table style="width:100%" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Tanggal</th>
                                <th>Catatan Bimbingan</th>
                                <th>TTD</th>
                            </tr>
                        </thead>
                        <tbody id="datatabel">
                            <?php $no=1?>
                              @foreach($data1 as $item)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    {{-- <td>{{ substr(tgl_indo($item->created_at, true), 0, 9)}}</td> --}}
                                    <td>
                                        @php
                                            $tgl = substr($item->created_at, 0, 10);
                                            $hasil = tgl_indo($tgl, true);
                                            echo $hasil;
                                        @endphp
                                    </td>
                                    <td>
                                        Bimbingan Ke-{{ $item->bimbingan_ke }} kepada {{ $item->name }} <br>
                                        @if ($item->ket1 == "-")
                                            Status : {{ $item->ket2 }} <br><br>
                                        @else
                                            Status : {{ $item->ket1 }} <br><br>
                                        @endif
                                        @php
                                            $pesan = DB::table('pesan_bimbingan')
                                            ->select('pesan_bimbingan.*')
                                            ->where('id_bimbingan', $item->id)
                                            ->get();

                                            $count = DB::table('pesan_bimbingan')
                                            ->select('pesan_bimbingan.*')
                                            ->where('id_bimbingan', $item->id)
                                            ->count();
                                        @endphp
                                        @if ($count==0)
                                            Catatan : -<br>
                                        @else
                                            @foreach($pesan as $psn)
                                                Catatan : {{ $psn->pesan }}<br>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td><img src="{{ url('ttd/'.$item->nidn.'/'.$item->ttd) }}" alt="" srcset="" height="40" width="auto"></td>
                                </tr>
                           @endforeach
                        </tbody>
                    </table>
                </div>
    
            </div>
        </div>


        <div class="d-sm-flex align-items-center justify-content-between mb-4 mt-5">
            <h1 class="h3 mb-0 text-gray-800">Bimbingan Kepada Dosen Pembimbing Pembantu</h1>
            {{-- <div class="pull-right">
                <div class="row">
                    <a class="btn btn-flat btn-primary mr-2" href="#" data-toggle="modal" data-target="#cetakPDF">Cetak PDF</a>
                </div>
            </div>             --}}
        </div>


        <div class="card shadow">
            <div class="card-body">
                <div class="table-responsive">
                    <table style="width:100%" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Tanggal</th>
                                <th>Catatan Bimbingan</th>
                                <th>TTD</th>
                            </tr>
                        </thead>
                        <tbody id="datatabel">
                            <?php $no=1?>
                              @foreach($data2 as $item)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    {{-- <td>{{ substr(tgl_indo($item->created_at, true), 0, 9)}}</td> --}}
                                    <td>
                                        @php
                                            $tgl = substr($item->created_at, 0, 10);
                                            $hasil = tgl_indo($tgl, true);
                                            echo $hasil;
                                        @endphp
                                    </td>
                                    <td>
                                        Bimbingan Ke-{{ $item->bimbingan_ke }} kepada {{ $item->name }} <br>
                                        @if ($item->ket1 == "-")
                                            Status : {{ $item->ket2 }} <br><br>
                                        @else
                                            Status : {{ $item->ket1 }} <br><br>
                                        @endif
                                        @php
                                            $pesan = DB::table('pesan_bimbingan')
                                            ->select('pesan_bimbingan.*')
                                            ->where('id_bimbingan', $item->id)
                                            ->get();

                                            $count = DB::table('pesan_bimbingan')
                                            ->select('pesan_bimbingan.*')
                                            ->where('id_bimbingan', $item->id)
                                            ->count();
                                        @endphp
                                        @if ($count==0)
                                            Catatan : -<br>
                                        @else
                                            @foreach($pesan as $psn)
                                                Catatan : {{ $psn->pesan }}<br>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td><img src="{{ url('ttd/'.$item->nidn.'/'.$item->ttd) }}" alt="" srcset="" height="40" width="auto"></td>
                                </tr>
                           @endforeach
                        </tbody>
                    </table>
                </div>
    
            </div>
        </div>

        
    </div>
@endsection