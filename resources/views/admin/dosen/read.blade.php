@extends('admin.main')

@section('content')
    <div class="container-fluid mt-4">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Data Dosen</h1>
            <div class="pull-right">
                <div class="row">
                    <a class="btn btn-flat btn-outline-success mr-2" href="/file_excel/Format_Import_Master_Dosen.xlsx" download="">Download Format Excel</a>
                    <div class="dropdown mr-1">
                        <button type="button" class="btn btn-success dropdown-toggle" id="dropdownMenuOffset" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-offset="10,20">
                          Tambah
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuOffset">
                          <a class="dropdown-item" href="/admin/dosen/tambah">Satu Dosen</a>
                          <a class="dropdown-item" href="#" data-toggle="modal" data-target="#importExcel">Import Excel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="importExcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<form method="post" action="/admin/dosen/importexcel" enctype="multipart/form-data">
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
                                            @if ($item -> depan == null)
                                                {{ $item -> name }}, {{ $item -> gelar1 }}, {{ $item -> gelar2 }}
                                            @else
                                                {{ $item -> name }}, {{ $item -> gelar1 }}, {{ $item -> gelar2 }}, {{ $item -> gelar3 }}
                                            @endif
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
