@extends('mahasiswa.main')

@section('content')
    <div class="container-fluid mt-4">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Bimbingan Skripsi</h1>
            <div class="pull-right">

                @php
                    $ceksempro = DB::table('hasil_sempro')->where('hasil_sempro.berita_acara', 'Diterima')->where('hasil_sempro.nim', $user->no_induk)->first();
                @endphp
                <div class="row">
                    @php
dd(ceksempro);
@endphp
                    <div class="dropdown mr-2">
                        <button type="button" class="btn btn-success dropdown-toggle" id="dropdownMenuOffset" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-offset="10,20" <?=$cekbimbinganselesai != null || $ceksempro == null ? 'disabled' : '' ?>>
                          Tambah
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuOffset">
                          <a class="dropdown-item" href="/mahasiswa/skripsi/bimbingan/tambah">Bimbingan Ke Dosen Pembimbing Utama</a>
                          <a class="dropdown-item <?=$plot->dosbing2==null ? 'disabled' : ''?>" href="/mahasiswa/skripsi/bimbingan/tambah/2">Bimbingan Ke Dosen Pembimbing Pembantu</a>
                        </div>
                    </div>
                    <a href="/mahasiswa/skripsi/bimbingan/tampil" class="btn btn-outline-success btn-flat <?=$cekbimbinganselesai != null || $ceksempro == null ? 'disabled' : '' ?>">
                        Rekap Bimbingan
                    </a>
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

        <ul class="nav nav-tabs mt-5">
            <li class="nav-item active">
              <a data-toggle="tab" class="nav-link h6 active" href="#dosen1">Dosen Pembimbing Utama</a>
            </li>
            <li class="nav-item">
              <a data-toggle="tab" class="nav-link h6 <?=$plot->dosbing2==null ? 'disabled' : ''?>" href="#dosen2">Dosen Pembimbing Pembantu</a>
            </li>
          </ul>

          <div class="tab-content">
            <div id="dosen1" class="tab-pane fade show active">
              <!-- Content Row -->
              <div class="card shadow mt-4">
                  <div class="card-body">
                      <div class="table-responsive">
                          <table id="dataTable" style="width:100%" class="table table-bordered">
                              <thead>
                                  <tr>
                                      <th>No.</th>
                                      <th>Semester</th>
                                      <th>NIM</th>
                                      <th>Nama</th>
                                      <th>Bimbingan Ke</th>
                                      <th>Bimbingan Kepada</th>
                                      <th>Status</th>
                                      <th>Detail</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <?php $no=1?>
                                    @foreach($data1 as $item)
                                      <tr>
                                          <td>{{ $no++ }}</td>
                                          <td>{{ $item -> smt }} {{ $item -> thn }}</td>
                                          <td>{{ $item -> nim }}</td>
                                          <td>{{ $item -> nama }}</td>
                                          <td>{{ $item -> bimbingan_ke }}</td>
                                          <td>
                                              @if ($item -> depan1 == "Y")
                                                  {{ $item -> gelar31 }} {{ $item -> dosbing1 }}, {{ $item -> gelar11 }}, {{ $item -> gelar21 }}</p>
                                              @else
                                              @if ($item->depan1==null)
                                              {{ $item -> dosbing1 }}, {{ $item -> gelar11 }}, {{ $item -> gelar21 }}
                                              @else

                                              {{ $item -> dosbing1 }}, {{ $item -> gelar11 }}, {{ $item -> gelar21 }}, {{ $item -> gelar31 }}</p>
                                              @endif
                                              @endif
                                          </td>
                                          <td>
                                              {{-- @if ($item->ket1 == "-") --}}
                                              {{-- <p style="pointer-events: none;" class="btn btn-sm <?=(//$item -> ket2 == 'Ok' || $item -> ket2 == 'Siap ujian' ? 'btn-success' : 'btn-warning')?>">{{ $item -> ket2 }}</p> --}}
                                              {{-- @elseif($item->ket2 == "-")  --}}
                                              <p style="pointer-events: none;" class="btn btn-sm <?=($item -> ket1 == 'Ok' || $item -> ket1 == 'Siap ujian' ? 'btn-success' : 'btn-warning')?>">{{ $item -> ket1 }}</p>
                                              {{-- @endif --}}
                                          </td>
                                          <td><a href="/mahasiswa/skripsi/bimbingan/detail/{{ $item->id  }}" class="btn btn-sm btn-primary">Lihat Detail</a></td>
                                      </tr>
                                      @endforeach
                              </tbody>
                          </table>
                      </div>

                  </div>
              </div>
            </div>

            <div id="dosen2" class="tab-pane fade">
                <!-- Content Row -->
                <div class="card shadow mt-4">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="dataTable2" style="width:100%" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Semester</th>
                                        <th>NIM</th>
                                        <th>Nama</th>
                                        <th>Bimbingan Ke</th>
                                        <th>Bimbingan Kepada</th>
                                        <th>Status</th>
                                        <th>Detail</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no=1?>
                                      @foreach($data2 as $item)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $item -> smt }} {{ $item -> thn }}</td>
                                            <td>{{ $item -> nim }}</td>
                                            <td>{{ $item -> nama }}</td>
                                            <td>{{ $item -> bimbingan_ke }}</td>
                                            <td>
                                                @if ($item -> depan1 == "Y")
                                                    {{ $item -> gelar31 }} {{ $item -> dosbing1 }}, {{ $item -> gelar11 }}, {{ $item -> gelar21 }}</p>
                                                @else
                                                @if ($item->depan1==null)
                                                {{ $item -> dosbing1 }}, {{ $item -> gelar11 }}, {{ $item -> gelar21 }}
                                                @else

                                                {{ $item -> dosbing1 }}, {{ $item -> gelar11 }}, {{ $item -> gelar21 }}, {{ $item -> gelar31 }}</p>
                                                @endif
                                                @endif
                                            </td>
                                            <td>
                                                {{-- @if ($item->ket1 == "-") --}}
                                                <p style="pointer-events: none;" class="btn btn-sm <?=($item -> ket2 == 'Ok' || $item -> ket2 == 'Siap ujian' ? 'btn-success' : 'btn-warning')?>">{{ $item -> ket2 }}</p>
                                                {{-- @elseif($item->ket2 == "-")  --}}
                                                {{-- <p style="pointer-events: none;" class="btn btn-sm <?=($item -> ket1 == 'Ok' || $item -> ket1 == 'Siap ujian' ? 'btn-success' : 'btn-warning')?>">{{ $item -> ket1 }}</p> --}}
                                                {{-- @endif --}}
                                            </td>
                                            <td><a href="/mahasiswa/skripsi/bimbingan/detail/{{ $item->id  }}" class="btn btn-sm btn-primary">Lihat Detail</a></td>
                                        </tr>
                                        @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
              </div>
          </div>


    </div>
@endsection
