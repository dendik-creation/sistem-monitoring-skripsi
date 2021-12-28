@extends('admin.main')

@section('content')
    <div class="container-fluid mt-4">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-2 text-gray-800">Detail Jadwal Seminar</h1>
            <div class="pull-right">
              @foreach($data as $item)
              <a href="{{ route('dataproposalpenjadwalan')}}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>

        {{-- Form --}}
        <div class="row mt-5">
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
                        <th>{{ $item -> gelar31 }} {{ $item -> dosbing1 }}, {{ $item -> gelar11 }}, {{ $item -> gelar21 }}</th>
                      </tr>
                      <tr>
                        <td>Dosen Pembimbing Pembantu</td>
                        <td>:</td>
                        <th>{{ $item -> gelar32 }} {{ $item -> dosbing2 }}, {{ $item -> gelar12 }}, {{ $item -> gelar22 }}</th>
                      </tr>
                    </tbody>
                  </table>
                <div class="ml-2 mt-4 mb-4">
                  @if ($item -> status1 == 'Belum' && $item -> status2 == 'Belum')
                    <a href="https://wa.me/{{ $item->hp }}" class="btn btn-success btn-flat" target="_blank">
                      Kirim Pesan WA
                    </a>
                  @else
                    <a href="/sempro/hasil/cetak/{{ $hasil_sempro->id }}" target="_blank" class="btn btn-primary">Cetak Dokumen</a>
                  @endif
                  

                </div>
            </div>
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tbody>
                      <tr>
                        <td>Hari/Tanggal</td>
                        <td>:</td>
                        <th>{{ tgl_indo($item->tanggal, true)}}</th>
                      </tr>
                      <tr>
                        <td>Jam</td>
                        <td>:</td>
                        <th>{{ $item->jam }} WIB</th>
                      </tr>
                      <tr>
                        <td>Tempat</td>
                        <td>:</td>
                        <th>{{ $item->tempat }}</th>
                      </tr>
                      <tr>
                        <td>Keterangan</td>
                        <td>:</td>
                        <th><textarea rows="10" class="form-control">{{ $item->ket }}</textarea></th>
                      </tr>
                    </tbody>
                  </table>
            </div>
            @endforeach
        </div>

    </div>
@endsection