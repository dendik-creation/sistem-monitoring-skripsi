@extends('dosen.main')

@section('content')
    <div class="container-fluid mt-4">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-2 text-gray-800">Detail Progress Mahasiswa</h1>
            <div class="pull-right">
              <a href="{{ route('datamhsbimbingan')}}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>

        {{-- Form --}}
        <div class="row mt-5">
          {{-- @foreach($data as $item) --}}
          <div class="col-md-6">
            <table class="table table-borderless">
                    <tbody>
                      <tr>
                        <td>Semester</td>
                        <td>:</td>
                        <th>{{ $plot->smt }}</th>
                      </tr>
                      <tr>
                        <td>NIM</td>
                        <td>:</td>
                        <th>{{ $mhs->nim }}</th>
                      </tr>
                      <tr>
                        <td>Nama</td>
                        <td>:</td>
                        <th>{{ $mhs->name }}</th>
                      </tr>
                      <tr>
                        <td>Dosen Pembimbing Utama</td>
                        <td>:</td>
                        <th>{{ $dosen1->gelar3 }} {{ $dosen1->name }}, {{ $dosen1->gelar1 }}, {{ $dosen1->gelar2 }}</th>
                      </tr>
                      <tr>
                        <td>Dosen Pembimbing Pembantu</td>
                        <td>:</td>
                        <th>{{ $dosen2->gelar3 }} {{ $dosen2->name }}, {{ $dosen2->gelar1 }}, {{ $dosen2->gelar2 }}</th>
                      </tr>
                    </tbody>
                  </table>
            </div>
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tbody>
                      <tr>
                        <td>Pengajuan Proposal</td>
                        <td>:</td>
                          @if ($pengajuan == 0)
                            <th style="pointer-events: none;" class="btn btn-sm btn-danger">Belum Mengajukan Proposal</th>
                          @else
                            <th style="pointer-events: none;" class="btn btn-sm btn-success">Sudah Mengajukan Proposal</th>
                          @endif
                      </tr>
                      <tr>
                        <td>Seminar Proposal</td>
                        <td>:</td>
                          @if ($sempro == null)
                            <th style="pointer-events: none;" class="btn btn-sm btn-danger">Belum Mendaftar Seminar Proposal</th>
                          @elseif($sempro->status1 == 'Sudah' && $sempro->status2 == 'Sudah')
                            <th style="pointer-events: none;" class="btn btn-sm btn-success">Sudah Seminar Proposal</th>
                          @else
                            <th style="pointer-events: none;" class="btn btn-sm btn-warning">Belum Seminar Proposal</th>
                          @endif
                      </tr>
                      <tr>
                        <td>Status Skripsi</td>
                        <td>:</td>
                          @if ($status == null)
                            <th style="pointer-events: none;" class="btn btn-sm btn-danger">Belum Mengerjakan Skripsi</th>
                          @elseif($status->status_skripsi == 'Sedang Dikerjakan')
                            <th style="pointer-events: none;" class="btn btn-sm btn-warning">Sedang Dikerjakan</th>
                          @else
                            <th style="pointer-events: none;" class="btn btn-sm btn-success">Selesai</th>
                          @endif
                      </tr>
                      <tr>
                        <td>Bimbingan Skripsi</td>
                        <td>:</td>
                          @if ($bimbingan == null)
                            <th style="pointer-events: none;" class="btn btn-sm btn-danger">Belum Melakukan Bimbingan</th>
                          @else
                            @if ($dosen1->nidn == $user->no_induk)
                              <th>Bimbingan Ke-{{ $bimbingan->bimbingan_ke }} - {{ $bimbingan->ket1 }}</th>
                            @else
                              <th>Bimbingan Ke-{{ $bimbingan->bimbingan_ke }} - {{ $bimbingan->ket2 }}</th>
                            @endif
                          @endif
                      </tr>
                      <tr>
                        <td>Status Ujian</td>
                        <td>:</td>
                          @if ($status == null)
                            <th style="pointer-events: none;" class="btn btn-sm btn-danger">Belum Ujian Skripsi</th>
                          @elseif($status->status_ujian == 'Belum Ujian')
                            <th style="pointer-events: none;" class="btn btn-sm btn-warning">Belum Ujian</th>
                          @elseif($status->status_ujian == 'Lulus')
                            <th style="pointer-events: none;" class="btn btn-sm btn-success">Lulus</th>
                          @else
                            <th style="pointer-events: none;" class="btn btn-sm btn-danger">Tidak Lulus</th>
                          @endif
                      </tr>
                    </tbody>
                  </table>
            </div>
            {{-- @endforeach --}}
        </div>

    </div>
@endsection