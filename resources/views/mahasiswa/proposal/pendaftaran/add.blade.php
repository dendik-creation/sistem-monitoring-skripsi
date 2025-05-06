@extends('mahasiswa.main')

@section('content')
    <div class="container-fluid mt-4">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-2 text-gray-800">Pendaftaran Seminar Proposal</h1>
        </div>

        @if (count($errors) > 0)
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ $error }}</strong>
                </div>
            @endforeach
        @endif

        {{-- Form --}}
        <form class="user" action="/mahasiswa/insertsempro" method="POST" enctype="multipart/form-data">
            <div class="row mt-2">
                {{ csrf_field() }}
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="" class="small">NIM*</label>
                        <input type="text" class="form-control" name="nim" placeholder="Masukkan NIM"
                            value="{{ $user->no_induk }}" required readonly>
                    </div>
                    <div class="form-group">
                        <label for="" class="small">Nama Lengkap*</label>
                        <input type="text" class="form-control" name="name" placeholder="Masukkan Nama Lengkap"
                            value="{{ $user->name }}" required readonly>
                    </div>
                    <div class="form-group">
                        <label for="" class="small">No. HP/WA*</label>
                        <input type="text" class="form-control" name="hp" placeholder="Masukkan No. HP/WA"
                            value="{{ $datamhs->hp }}" required readonly>
                    </div>

                    <div class="form-group">
                        <label for="" class="small">Berkas* (ZIP) (Max 20MB)</label><br>
                        <input type="file" name="berkassempro" placeholder="Masukkan Berkas Seminar" required
                            accept=".zip,.rar,.7zip">
                    </div>
                    <div class="form-group mt-5">
                        <button type="submit" class="btn btn-primary mr-2" <?= $dataprop === null ? 'disabled' : '' ?>>
                            Daftar
                        </button>
                        <a href="{{ url()->previous() }}" class="btn btn-secondary">Batal</a>
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="" class="small">Dosen Pembimbing Utama*</label>
                        <input type="hidden" value="{{ $datadosbing->id }}" name="id_plot_dosbing">
                        <input type="email" class="form-control" name="dosbing1" placeholder="Masukkan Dosen Pembimbing 1"
                            value="@if ($dosen1->depan == 'Y') {{ $dosen1->gelar3 }} {{ $dosen1->name }}, {{ $dosen1->gelar1 }}, {{ $dosen1->gelar2 }}
                          @else
                          @if ($dosen1->depan == null)
                            {{ $dosen1->name }}, {{ $dosen1->gelar1 }}, {{ $dosen1->gelar2 }}
                          @else

                          {{ $dosen1->name }}, {{ $dosen1->gelar1 }}, {{ $dosen1->gelar2 }}, {{ $dosen1->gelar3 }} @endif
                          @endif"
                            required readonly>
                    </div>
                    <div class="form-group">
                        <label for="" class="small">Dosen Pembimbing Pembantu*</label>
                        <input type="email" class="form-control" name="dosbing2" placeholder="Masukkan Dosen Pembimbing 1"
                            value="
                        @if ($dosen2 == null) -
                                        @else
                        @if ($dosen2->depan == 'Y')
                              {{ $dosen2->gelar3 }} {{ $dosen2->name }}, {{ $dosen2->gelar1 }}, {{ $dosen2->gelar2 }}
                          @else
                          @if ($dosen2->depan == null)
                            {{ $dosen2->name }}, {{ $dosen2->gelar1 }}, {{ $dosen2->gelar2 }}
                          @else

                          {{ $dosen2->name }}, {{ $dosen2->gelar1 }}, {{ $dosen2->gelar2 }}, {{ $dosen2->gelar3 }} @endif
                          @endif
                          @endif"
                            required readonly>
                    </div>
                    <div class="form-group">
                        <label for="" class="small">Judul*</label>
                        {{-- //[Syahrul][05/05/2025] handling ketika data proposal kosong --}}
                        @if ($dataprop != null)
                            <input type="hidden" value="{{ $dataprop->id }}" name="id_proposal">
                        @endif
                        <input type="text" class="form-control" name="judul" placeholder="Masukkan Judul Skripsi"
                            value="<?= $dataprop === null ? 'Belum di ACC' : $dataprop->judul ?>" required readonly>
                    </div>


                </div>
            </div>
            {{-- <div class="row mt-2">
                <table class="table table-bordered mt-2">
                    <thead>
                        <th>No.</th>
                        <th>Berkas</th>
                        <th>File</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1.</td>
                            <td>Scan Bukti Pembayaran* (JPG/PNG/PDF) (Max 2MB)</td>
                            <td><input type="file" name="byr"  accept=".jpg,.jpeg,.png,.pdf"></td>
                        </tr>
                        <tr>
                            <td>2.</td>
                            <td>Proposal Skripsi* (PDF) (Max 10MB)</td>
                            <td><input type="file" name="proposal"  accept=".pdf"></td>
                        </tr>
                        <tr>
                            <td>3.</td>
                            <td>Scan KRS* (JPG/PNG/PDF) (Max 2MB)</td>
                            <td><input type="file" name="krs"  accept=".jpg,.jpeg,.png,.pdf"></td>
                        </tr>
                        <tr>
                            <td>4.</td>
                            <td>Scan Transkrip Nilai* (JPG/PNG/PDF) (Max 2MB)</td>
                            <td><input type="file" name="transkrip"  accept=".jpg,.jpeg,.png,.pdf"></td>
                        </tr>
                    </tbody>
                </table>
                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-primary mr-2" <?= $dataprop === null ? 'disabled' : '' ?>>
                        Daftar
                    </button>
                    <a href="{{url()->previous()}}" class="btn btn-secondary">Batal</a>
                </div>
            </div> --}}
        </form>

    </div>
@endsection
