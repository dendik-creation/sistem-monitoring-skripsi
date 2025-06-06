@extends('admin.main')

@section('content')
    <div class="container-fluid mt-4">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Data Mahasiswa</h1>
<div class="pull-right">
                <div class="row">
                    <a class="btn btn-flat btn-outline-success mr-2" href="/file_excel/Format_Import_Master_Mahasiswa.xlsx" download="">Download Format Excel</a>
                    <div class="dropdown mr-1">
                        <button type="button" class="btn btn-success dropdown-toggle" id="dropdownMenuOffset" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-offset="10,20">
                          Tambah
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuOffset">
                          <a class="dropdown-item" href="/admin/mahasiswa/tambah">Satu Mahasiswa</a>
                          <a class="dropdown-item" href="#" data-toggle="modal" data-target="#importExcel">Import Excel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="importExcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<form method="post" action="/admin/mahasiswa/importexcel" enctype="multipart/form-data">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Import Excel</h5>
						</div>
						<div class="modal-body">

							{{ csrf_field() }}

							<label for="" class="small">Pilih File Excel*</label>
							<div class="form-group">
								<input type="file" name="file" accept=".xls, .xlsx" required>
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

        @if (session('status'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ session('status') }}</strong>
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
                                <th>Nama Mahasiswa</th>
                                <th>Email</th>
                                <th>No. Hp/WA</th>
                                <th>Proposal</th>
                                <th>Sempro</th>
                                <th>Bimbingan</th>
                                <th>Skripsi</th>
                                <th>Ujian</th>
                                {{-- <th>Edit</th> --}}
                                <th>Reset</th>
                                <th>Hapus</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1?>
                              @foreach($data as $item)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $item -> nim }}</td>
                                    <td>{{ $item -> name }}</td>
                                    <td>{{ $item -> email }}</td>
                                    <td>{{ $item -> hp }}</td>
                                    <td class="<?=($item -> status_proposal == "Belum mengajukan proposal" || $item -> status_proposal == "Sudah mengajukan proposal - Ditolak" ? 'text-danger' : ($item -> status_proposal == "Sudah mengajukan proposal - Menunggu ACC" ? 'text-warning' : 'text-success'))?>"><strong>{{ $item -> status_proposal }}</td>
                                    <td class="<?=($item -> status_sempro == "Sudah seminar proposal - Diterima" ? 'text-success' : ($item -> status_sempro == "Menunggu Seminar Proposal" ? 'text-warning' : 'text-danger'))?>"><strong>{{ $item -> status_sempro }}</td>
                                    <td class="<?=$item -> status_bimbingan == "Belum melakukan bimbingan" ? 'text-danger' : 'text-success'?>"><strong>{{ $item -> status_bimbingan }}</td>
                                    <td class="<?=($item -> status_skripsi == "Belum mengerjakan" ? 'text-danger' : ($item -> status_skripsi == "Sedang dikerjakan" ? 'text-warning' : 'text-success'))?>"><strong>{{ $item -> status_skripsi }}</td>
                                    <td class="<?=($item -> status_ujian == "Sudah ujian - Lulus" ? 'text-success' : ($item -> status_ujian == "Menunggu Ujian" ? 'text-warning' : 'text-danger'))?>"><strong>{{ $item -> status_ujian }}</td>
                                    {{-- <td>
                                        <a href="/admin/mahasiswa/edit/{{$item->nim}}" class="btn btn-primary btn-sm">Edit</a>
                                    </td> --}}
                                    {{-- <td>
                                        <form action="/admin/mahasiswa/{{$item->nim}}" method="post">
                                        {{csrf_field()}}
                                        {{method_field('DELETE')}}
                                        <button type="submit" value="delete" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                        </form>
                                    </td> --}}
                                    <td>
                                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal{{$item->id}}">
                                            Reset
                                        </button>
                                        <!-- Modal -->
                                        <div class="modal fade" id="modal{{$item->id}}" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Reset Password</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                </div>
                                                <form class="user" method="POST" action="{{ route('resetmahasiswa', ['id' => $item->id]) }}">
                                                    {{csrf_field()}}
                                                    {{method_field('PUT')}}
                                                    <div class="modal-body">
                                                        <input type="hidden" name="nim" value="{{$item->nim}}">
                                                        <div class="form-group">
                                                            <label for="" class="small">Email*</label>
                                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $item->email }}" required autocomplete="email" placeholder="Masukkan Email" readonly>

                                                            @error('email')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        {{-- <p>Yakin ingin mereset password?</p> --}}
                                                    </div>
                                                    <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" name="submit" class="btn btn-primary">Reset</button>
                                                    </div>
                                                </form>
                                            </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <form action="/admin/mahasiswa/{{$item->nim}}" method="post">
                                            {{csrf_field()}}
                                            {{method_field('DELETE')}}
                                            <button type="submit" value="delete" class="btn btn-danger btn-sm">Hapus</button>
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
