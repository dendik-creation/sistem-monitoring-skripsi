@extends('admin.main')

@section('content')
    <div class="container-fluid mt-4">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Rekap Pembimbing Skripsi</h1>
            <div class="pull-right">
                <div class="row">
                    <form method="post" action="/admin/rekap/pembimbing/skripsi/cetak" target="_blank">
                        {{ csrf_field() }}
                        <input type="hidden" value="{{ $idsmt }}" name="idsmt">
                        <button type="submit" class="btn btn-primary">Cetak Rekap PDF</button>
                    </form>
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
                                <th>Nama Dosen</th>
                                <th>Pembimbing Utama</th>
                                <th>Pembimbing Pembantu</th>
                                <th>Nama Mahasiswa</th>
                            </tr>
                        </thead>
                        <tbody id="datatabel">
                            <?php $no=1?>
                              @foreach($data as $item)
                                <tr>
                                    <td rowspan="2">{{ $no++ }}</td>
                                    <td rowspan="2">
                                        @if ($item -> depan == "Y")
                                            {{ $item -> gelar3 }} {{ $item -> name }}, {{ $item -> gelar1 }}, {{ $item -> gelar2 }}
                                        @else
                                        @if ($item -> depan == null)
                                        {{ $item -> name }}, {{ $item -> gelar1 }}, {{ $item -> gelar2 }}
                                        @else
                                            
                                        {{ $item -> name }}, {{ $item -> gelar1 }}, {{ $item -> gelar2 }}, {{ $item -> gelar3 }}
                                        @endif
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $jumlah1 = DB::table('plot_dosbing')
                                            ->join('hasil_sempro', 'hasil_sempro.nim', '=', 'plot_dosbing.nim')
                                            ->select('plot_dosbing.*')
                                            ->where('plot_dosbing.dosbing1', $item->nidn)
                                            ->where('hasil_sempro.id_semester', $idsmt)
                                            ->where('hasil_sempro.berita_acara', '!=', 'Menunggu hasil')
                                            ->count();
                        
                                            if($jumlah1==0){
                                                echo "-";
                                            }else{
                                                echo $jumlah1;
                                            }
                                        @endphp
                                    </td>
                                    <td>
                                        {{-- @php
                                            $jumlah1 = DB::table('plot_dosbing')
                                            ->join('hasil_sempro', 'hasil_sempro.nim', '=', 'plot_dosbing.nim')
                                            ->select('plot_dosbing.*')
                                            ->where('plot_dosbing.dosbing1', $item->nidn)
                                            ->where('hasil_sempro.id_semester', $idsmt)
                                            ->count();
                        
                                            if($jumlah1==0){
                                                echo "-";
                                            }else{
                                                echo $jumlah1;
                                            }
                                        @endphp --}}
                                        -
                                    </td>
                                    <td>
                                        @php
                                            $dts = DB::table('plot_dosbing')
                                            ->join('hasil_sempro', 'hasil_sempro.nim', '=', 'plot_dosbing.nim')
                                            ->select('plot_dosbing.*')
                                            ->where('plot_dosbing.dosbing1', $item->nidn)
                                            ->where('hasil_sempro.id_semester', $idsmt)
                                            ->where('hasil_sempro.berita_acara', '!=', 'Menunggu hasil')
                                            ->get();
                                        @endphp
                                        @foreach($dts as $dts)
                                            {{ $dts->nim }} - {{ $dts->name }} <br>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        {{-- @php
                                            $jumlah2 = DB::table('plot_dosbing')
                                            ->join('hasil_sempro', 'hasil_sempro.nim', '=', 'plot_dosbing.nim')
                                            ->select('plot_dosbing.*')
                                            ->where('plot_dosbing.dosbing2', $item->nidn)
                                            ->where('hasil_sempro.id_semester', $idsmt)
                                            ->count();
                        
                                            if($jumlah2==0){
                                                echo "-";
                                            }else{
                                                echo $jumlah2;
                                            }
                                        @endphp --}}
                                        -
                                    </td>
                                    <td>
                                        @php
                                            $jumlah2 = DB::table('plot_dosbing')
                                            ->join('hasil_sempro', 'hasil_sempro.nim', '=', 'plot_dosbing.nim')
                                            ->select('plot_dosbing.*')
                                            ->where('plot_dosbing.dosbing2', $item->nidn)
                                            ->where('hasil_sempro.id_semester', $idsmt)
                                            ->where('hasil_sempro.berita_acara', '!=', 'Menunggu hasil')
                                            ->count();
                        
                                            if($jumlah2==0){
                                                echo "-";
                                            }else{
                                                echo $jumlah2;
                                            }
                                        @endphp
                                    </td>
                                    <td>
                                        @php
                                            $dts = DB::table('plot_dosbing')
                                            ->join('hasil_sempro', 'hasil_sempro.nim', '=', 'plot_dosbing.nim')
                                            ->select('plot_dosbing.*')
                                            ->where('plot_dosbing.dosbing2', $item->nidn)
                                            ->where('hasil_sempro.id_semester', $idsmt)
                                            ->where('hasil_sempro.berita_acara', '!=', 'Menunggu hasil')
                                            ->get();
                                        @endphp
                                        @foreach($dts as $dts)
                                            {{ $dts->nim }} - {{ $dts->name }} <br>
                                        @endforeach
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