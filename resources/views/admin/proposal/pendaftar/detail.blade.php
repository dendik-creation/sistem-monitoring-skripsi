@extends('admin.main')

@section('content')
    <div class="container-fluid mt-4">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-2 text-gray-800">Detail Pendaftar</h1>
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
                        <th>{{ $item->nama }}</th>
                      </tr>
                      <tr>
                        <td>Judul</td>
                        <td>:</td>
                        <th>{{ $item->judul }}</th>
                      </tr>
                      <tr>
                        <td>Dosen Pembimbing Utama</td>
                        <td>:</td>
                        <th>
                          @if ($dosen1 -> depan == "Y")
                              {{ $dosen1 -> gelar3 }} {{ $dosen1 -> name }}, {{ $dosen1 -> gelar1 }}, {{ $dosen1 -> gelar2 }}
                          @else
                          @if ($dosen1 -> depan == null)
                          {{ $dosen1 -> name }}, {{ $dosen1 -> gelar1 }}, {{ $dosen1 -> gelar2 }}
                          @else
                          {{ $dosen1 -> name }}, {{ $dosen1 -> gelar1 }}, {{ $dosen1 -> gelar2 }}, {{ $dosen1 -> gelar3 }}
                          @endif
                          @endif
                        </th>
                      </tr>
                      <tr>
                        <td>Dosen Pembimbing Pembantu</td>
                        <td>:</td>
                        <th>
                          @if ($dosen2==null)
                                            -
                                        @else
                          @if ($dosen2 -> depan == "Y")
                              {{ $dosen2 -> gelar3 }} {{ $dosen2 -> name }}, {{ $dosen2 -> gelar1 }}, {{ $dosen2 -> gelar2 }}
                          @else
                          @if ($dosen2 -> depan == null)
                          {{ $dosen2 -> name }}, {{ $dosen2 -> gelar1 }}, {{ $dosen2 -> gelar2 }}
                          @else
                              
                          {{ $dosen2 -> name }}, {{ $dosen2 -> gelar1 }}, {{ $dosen2 -> gelar2 }}, {{ $dosen2 -> gelar3 }}
                          @endif
                          @endif
                          @endif
                        </th>
                      </tr>
                      {{-- <tr>
                        <td>Berkas Seminar</td>
                        <td>:</td>
                        <th><a href="/download/{{ $item->nim }}/berkas_sempro/{{$item->krs}}"><?=$item->krs == null ? '' : 'Download berkas sempro'?></a></th>
                      </tr> --}}
                      <tr>
                        <td>Tanggal Pendaftaran</td>
                        <td>:</td>
                        <th><?=tgl_indo(substr($item->tgl_daftar, 0, 10), true);?></th>
                      </tr>
                    </tbody>
                  </table>
                <div class="ml-2 mt-4 mb-4">
                  <form class="user" action="/admin/proposal/insertjadwalsempro" method="POST">
                    {{csrf_field()}}
                    <button type="submit" class="btn btn-primary mr-2">Jadwalkan</button>
                    <a href="{{ route('dataproposalpenjadwalan')}}" class="btn btn-secondary">Batal</a>
                </div>
            </div>
            <div class="col-md-5 ml-4">
                <table class="table table-borderless">
                    <tbody>
                      <div class="form-group">
                        <label for="" class="small">Tanggal Seminar*</label>
                        <input type="text" class="form-control" id="datepicker" name="tanggal" placeholder="Masukkan Tanggal" required>
                      </div>
                      <div class="form-group">
                        <label for="" class="small">Jam Seminar*</label>
                        <input type="text" class="form-control" id="timepicker" name="jam" placeholder="Masukkan Jam (Jam:Menit:Detik)" required>
                      </div>
                      <div class="form-group">
                        <label for="" class="small">Tempat Seminar*</label>
                        <input type="text" class="form-control" name="tempat" placeholder="Masukkan Tempat" required>
                      </div>
                      <div class="form-group">
                        <label for="" class="small">Keterangan*</label>
                        <textarea class="form-control form-control-user" name="ket" placeholder="Masukkan Keterangan" rows="10"></textarea>
                        <input type="hidden" name="nim" value="{{ $item->nim }}">
                        <input type="hidden" name="id_berkas_sempro" value="{{ $item->id }}">
                        <input type="hidden" name="id_proposal" value="{{ $item->id_proposal }}">
                      </div>
                    </tbody>
                  </table>
            </div>
        </div>
        @endforeach
    </div>
@endsection