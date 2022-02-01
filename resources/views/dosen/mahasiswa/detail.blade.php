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
                        <th>@if ($dosen1 -> depan == "Y")
                              {{ $dosen1 -> gelar3 }} {{ $dosen1 -> name }}, {{ $dosen1 -> gelar1 }}, {{ $dosen1 -> gelar2 }}
                          @else
                              {{ $dosen1 -> name }}, {{ $dosen1 -> gelar1 }}, {{ $dosen1 -> gelar2 }}, {{ $dosen1 -> gelar3 }}
                          @endif</th>
                      </tr>
                      <tr>
                        <td>Dosen Pembimbing Pembantu</td>
                        <td>:</td>
                        <th>@if ($dosen2 -> depan == "Y")
                              {{ $dosen2 -> gelar3 }} {{ $dosen2 -> name }}, {{ $dosen2 -> gelar1 }}, {{ $dosen2 -> gelar2 }}
                          @else
                              {{ $dosen2 -> name }}, {{ $dosen2 -> gelar1 }}, {{ $dosen2 -> gelar2 }}, {{ $dosen2 -> gelar3 }}
                          @endif</th>
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
                          @if ($mhs -> status_proposal == "Belum mengajukan proposal")
                            <th style="pointer-events: none;" class="btn btn-sm btn-danger">Belum mengajukan proposal</th>
                          @else
                            <th style="pointer-events: none;" class="btn btn-sm btn-success">Sudah mengajukan proposal</th>
                          @endif
                      </tr>
                      <tr>
                        <td>Seminar Proposal</td>
                        <td>:</td>
                          @if ($mhs -> status_sempro == "Belum seminar proposal")
                            <th style="pointer-events: none;" class="btn btn-sm btn-danger">Belum seminar proposal</th>
                          @else
                            <th style="pointer-events: none;" class="btn btn-sm btn-success">Sudah seminar proposal</th>
                          @endif
                      </tr>
                      <tr>
                        <td>Bimbingan Skripsi</td>
                        <td>:</td>
                          @if ($mhs -> status_bimbingan == "Belum melakukan bimbingan")
                            <th style="pointer-events: none;" class="btn btn-sm btn-danger">Belum melakukan bimbingan</th>
                          @else
                            <th style="pointer-events: none;" class="btn btn-sm btn-success">{{ $mhs->status_bimbingan }}</th>
                          @endif
                      </tr>
                      <tr>
                        <td>Status Skripsi</td>
                        <td>:</td>
                          @if ($mhs -> status_skripsi == "Belum mengerjakan")
                            <th style="pointer-events: none;" class="btn btn-sm btn-danger">Belum mengerjakan</th>
                          @elseif($mhs -> status_skripsi == 'Sedang dikerjakan')
                            <th style="pointer-events: none;" class="btn btn-sm btn-warning">Sedang dikerjakan</th>
                          @else
                            <th style="pointer-events: none;" class="btn btn-sm btn-success">Selesai</th>
                          @endif
                      </tr>
                      <tr>
                        <td>Status Ujian</td>
                        <td>:</td>
                          @if ($mhs -> status_ujian == "Lulus")
                            <th style="pointer-events: none;" class="btn btn-sm btn-success">Lulus</th>
                          @elseif($mhs->status_ujian == 'Belum ujian')
                            <th style="pointer-events: none;" class="btn btn-sm btn-danger">Belum ujian</th>
                          @elseif($mhs->status_ujian == 'Tidak Lulus')
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