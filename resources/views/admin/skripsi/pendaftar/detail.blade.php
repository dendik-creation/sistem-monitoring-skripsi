@extends('admin.main')

@section('content')
    <div class="container-fluid mt-4">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-2 text-gray-800">Detail Pendaftar</h1>
        </div>

        {{-- Form --}}
        @foreach($data as $item)
        <div class="row-mt-5">
          <div class="col-md-12">
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
                  <td>No. HP/WA</td>
                  <td>:</td>
                  <th>{{ $item->hp }}</th>
                </tr>
                <tr>
                  <td>Email</td>
                  <td>:</td>
                  <th>{{ $item->email }}</th>
                </tr>
                <tr>
                  <td>Judul</td>
                  <td>:</td>
                  <th>{{ $item->judul }}</th>
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
                <tr>
                  <td>Berkas Ujian</td>
                  <td>:</td>
                  <th><a href="/download/{{ $item->nim }}/berkas_ujian/{{$item->berkas_ujian}}"><?=$item->berkas_ujian == null ? '' : 'Download berkas'?></a></th>
                </tr>
                <tr>
                  <td>Tanggal Pendaftaran</td>
                  <td>:</td>
                  <th><?=tgl_indo(substr($item->tgl_daftar, 0, 10), true);?></th>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <hr class="sidebar-divider mt-5">
        <div class="row mt-5">
          <div class="col-md-6">
            <form action="/admin/skripsi/insertjadwalujian" method="POST">
              {{csrf_field()}}
              <table class="table table-borderless">
                  <tbody>
                    <div class="form-group">
                      <label for="" class="small">Tanggal Ujian Skripsi*</label>
                      <input type="text" class="form-control" id="datepicker" name="tanggal" placeholder="Masukkan Tanggal" required>
                    </div>
                    <div class="form-group">
                      <label for="" class="small">Jam Ujian Skripsi*</label>
                      <input type="text" class="form-control" id="timepicker" name="jam" placeholder="Masukkan Jam (Jam:Menit:Detik)" required>
                    </div>
                    <div class="form-group">
                      <label for="" class="small">Tempat Ujian Skripsi*</label>
                      <input type="text" class="form-control" name="tempat" placeholder="Masukkan Tempat" required>
                    </div>
                    <div class="form-group">
                      <label for="" class="small">Keterangan*</label>
                      <textarea class="form-control form-control" name="ket" placeholder="Masukkan Keterangan"></textarea>
                      <input type="hidden" name="nim" value="{{ $item->nim }}">
                      <input type="hidden" name="id_berkas_ujian" value="{{ $item->id }}">
                      <input type="hidden" name="id_proposal" value="{{ $item->id_proposal }}">
                    </div>
                  </tbody>
                </table>
                <div class="mt-4 mb-4">
                    <button type="submit" class="btn btn-primary mr-2">Jadwalkan</button>
                    <a href="{{ route('dataskripsipenjadwalan')}}" class="btn btn-secondary">Batal</a>
                  
                </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
                <label for="" class="small">Ketua Penguji*</label>
                <select class="form-control" name="ketua">
                    <option>Ketua Penguji --</option>
                    @foreach($ketua as $item)
                    @if ($item->depan == "Y")
                    <option value="{{ $item->nidn }}">{{ $item->gelar3 }} {{ $item->name }}, {{ $item->gelar1 }}, {{ $item->gelar2 }}</option>
                @else
                    <option value="{{ $item->nidn }}">{{ $item->name }}, {{ $item->gelar1 }}, {{ $item->gelar2 }}, {{ $item->gelar3 }} </option>
                @endif
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="" class="small">Anggota Penguji 1*</label>
                <select class="form-control" name="anggota1">
                    <option>Anggota Penguji 1 --</option>
                    @foreach($anggota1 as $item)
                        @if ($item->depan == "Y")
                            <option value="{{ $item->nidn }}">{{ $item->gelar3 }} {{ $item->name }}, {{ $item->gelar1 }}, {{ $item->gelar2 }}</option>
                        @else
                            <option value="{{ $item->nidn }}">{{ $item->name }}, {{ $item->gelar1 }}, {{ $item->gelar2 }}, {{ $item->gelar3 }} </option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="" class="small">Anggota Penguji 2*</label>
                <select class="form-control" name="anggota2">
                    <option>Anggota Penguji 2 --</option>
                    @foreach($anggota2 as $item)
                        @if ($item->depan == "Y")
                            <option value="{{ $item->nidn }}">{{ $item->gelar3 }} {{ $item->name }}, {{ $item->gelar1 }}, {{ $item->gelar2 }}</option>
                        @else
                            <option value="{{ $item->nidn }}">{{ $item->name }}, {{ $item->gelar1 }}, {{ $item->gelar2 }}, {{ $item->gelar3 }} </option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>
          </form>
        </div>
        @endforeach
    </div>
@endsection