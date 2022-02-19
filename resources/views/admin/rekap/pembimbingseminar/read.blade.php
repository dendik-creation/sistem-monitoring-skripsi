@extends('admin.main')

@section('content')
    <div class="container-fluid mt-4">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Rekap Pembimbing Seminar</h1>
            <div class="pull-right">
                <div class="row">
                    <a class="btn btn-flat btn-primary mr-2" href="#" data-toggle="modal" data-target="#cetakPDF">Cetak Rekap PDF</a>
                </div>
            </div>            
        </div>

        <div class="modal fade" id="cetakPDF" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<form method="post" action="/admin/rekap/pembimbing/seminar/cetak" enctype="multipart/form-data" target="_blank">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Cetak Rekap PDF</h5>
						</div>
						<div class="modal-body">
 
							{{ csrf_field() }}
 
							<label for="" class="small">Nomor*</label>
							<div class="form-group">
								<input type="text" class="form-control" name="nomor" placeholder="Masukkan Nomor" required>
                                <input type="hidden" value="{{ $idsmt }}" name="idsmt">
							</div>
                            <label for="" class="small">Kaprogdi*</label>
							<div class="form-group">
								<select class="form-control" name="kaprodi">
                                    <option>Kaprogdi --</option>
                                    @foreach($data as $item)
                                        @if ($item->depan == "Y")
                                            <option value="{{ $item->nidn }}">{{ $item->gelar3 }} {{ $item->name }}, {{ $item->gelar1 }}, {{ $item->gelar2 }}</option>
                                        @else
                                            <option value="{{ $item->nidn }}">{{ $item->name }}, {{ $item->gelar1 }}, {{ $item->gelar2 }}, {{ $item->gelar3 }} </option>
                                        @endif
                                    @endforeach
                                </select>
							</div>
 
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-primary">Cetak</button>
						</div>
					</div>
				</form>
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
                                            {{ $item -> name }}, {{ $item -> gelar1 }}, {{ $item -> gelar2 }}, {{ $item -> gelar3 }}
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