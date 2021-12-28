@extends('mahasiswa.main')

@section('content')
    <div class="container-fluid mt-4">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-2 text-gray-800">Detail Pengajuan Proposal</h1>
        </div>

        {{-- Form --}}
        <div class="row mt-5">
          @foreach($data as $item)
          <div class="col-md-6">
            <table class="table table-borderless">
                    <tbody>
                      <tr>
                        <td>NIM</td>
                        <td>:</td>
                        <th>{{ $item->nim }}</th>
                      </tr>
                      <tr>
                        <td>Nama</td>
                        <td>:</td>
                        <th>{{ $item->name }}</th>
                      </tr>
                      <tr>
                        <td>Judul</td>
                        <td>:</td>
                        <th>{{ $item->judul }}</th>
                      </tr>
                      <tr>
                        <td>File</td>
                        <td>:</td>
                        <th><a href="/download/{{ $item->nim }}/proposal/{{$item->proposal}}">{{$item->proposal}}</a></th>
                      </tr>
                      <tr>
                        <td>Keterangan</td>
                        <td>:</td>
                        <th>{{ $item->komentar }}</th>
                      </tr>
                    </tbody>
                  </table>
                <div class="ml-2 mt-4">
                    <a href="{{ route('datapengajuanproposal')}}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tbody>
                      <tr>
                        <td>Dosen Pembimbing Utama</td>
                        <td>:</td>
                        <th>{{ $dosen1->gelar3 }} {{ $dosen1->name }}, {{ $dosen1->gelar1 }}, {{ $dosen1->gelar2 }} - <p style="pointer-events: none;" class="btn btn-sm mt-2 <?=($item -> ket1 == 'Disetujui' ? 'btn-success' : ($item -> ket1 == 'Revisi' ? 'btn-warning' : ($item -> ket1 == 'Ditolak' ? 'btn-danger' : 'btn-secondary')))?>">{{ $item -> ket1 }}</th>
                      </tr>
                      <tr>
                        <td>Dosen Pembimbing Pembantu</td>
                        <td>:</td>
                        <th>{{ $dosen2->gelar3 }} {{ $dosen2->name }}, {{ $dosen2->gelar1 }}, {{ $dosen2->gelar2 }} - <p style="pointer-events: none;" class="btn btn-sm mt-2 <?=($item -> ket2 == 'Disetujui' ? 'btn-success' : ($item -> ket2 == 'Revisi' ? 'btn-warning' : ($item -> ket2 == 'Ditolak' ? 'btn-danger' : 'btn-secondary')))?>">{{ $item -> ket2 }}</th>
                      </tr>
                      <tr>
                        <td>Revisi Dosen Pembimbing Utama</td>
                        <td>:</td>
                        <th>{{ $item->komentar1 }}</th>
                      </tr>
                      <tr>
                        <td>Revisi Dosen Pembimbing Pembantu</td>
                        <td>:</td>
                        <th>{{ $item->komentar2 }}</th>
                      </tr>
                    </tbody>
                  </table>
            </div>
            @endforeach
        </div>

    </div>
@endsection