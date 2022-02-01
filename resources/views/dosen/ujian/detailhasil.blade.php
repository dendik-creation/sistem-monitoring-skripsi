@extends('dosen.main')

@section('content')
    <div class="container-fluid mt-4">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-2 text-gray-800">Detail Hasil Ujian Skripsi</h1>
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
                        <td>Ketua Penguji</td>
                        <td>:</td>
                        <th>@if ($ketua -> depan == "Y")
                              {{ $ketua -> gelar3 }} {{ $ketua -> name }}, {{ $ketua -> gelar1 }}, {{ $ketua -> gelar2 }}
                          @else
                              {{ $ketua -> name }}, {{ $ketua -> gelar1 }}, {{ $ketua -> gelar2 }}, {{ $ketua -> gelar3 }}
                          @endif</th>
                      </tr>
                      <tr>
                        <td>Anggota Penguji 1</td>
                        <td>:</td>
                        <th>@if ($anggota1 -> depan == "Y")
                              {{ $anggota1 -> gelar3 }} {{ $anggota1 -> name }}, {{ $anggota1 -> gelar1 }}, {{ $anggota1 -> gelar2 }}
                          @else
                              {{ $anggota1 -> name }}, {{ $anggota1 -> gelar1 }}, {{ $anggota1 -> gelar2 }}, {{ $anggota1 -> gelar3 }}
                          @endif</th>
                      </tr>
                      <tr>
                        <td>Anggota Penguji 2</td>
                        <td>:</td>
                        <th>@if ($anggota2 -> depan == "Y")
                              {{ $anggota2 -> gelar3 }} {{ $anggota2 -> name }}, {{ $anggota2 -> gelar1 }}, {{ $anggota2 -> gelar2 }}
                          @else
                              {{ $anggota2 -> name }}, {{ $anggota2 -> gelar1 }}, {{ $anggota2 -> gelar2 }}, {{ $anggota2 -> gelar3 }}
                          @endif</th>
                      </tr>
                      <tr>
                        <td>Status</td>
                        <td>:</td>
                        <th class="<?=$item->berita_acara == "Lulus" ? 'text-success' : 'text-danger' ?>">{{ $item->berita_acara }}</th>
                      </tr>
                    </tbody>
                  </table>
                <div class="ml-2 mt-4">
                  <a href="/ujian/hasil/cetak/{{ $item->id }}" target="_blank" class="btn btn-primary <?=$item->status1 == "Sudah" && $item->status2 == "Sudah" && $item->status3 == 
                    "Sudah" ? '' : 'disabled'?>">Lihat Nilai</a>
                  <a href="{{ route('datahasilujiandosen')}}" class="btn btn-secondary ml-1">Kembali</a>
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

        <div class="d-sm-flex align-items-center justify-content-between mb-4 mt-5">
            <h1 class="h3 mb-2 text-gray-800">Revisi Ketua Penguji</h1>
        </div>
        <div class="row mt-5">
          <div class="col-md-12">
            <table class="table table-borderless">
                    <tbody>
                      <tr>
                        <td>Revisi</td>
                        <td>:</td>
                        <th><textarea rows="10" class="form-control">{{ $item->revisi1 }}</textarea></th>
                      </tr>
                      <tr>
                        <td>File Pendukung</td>
                        <td>:</td>
                        <th><a href="/download/{{$item->nim}}/proposal/revisi dari dosen/{{$item->file1}}"><?=$item->file1 == null ? '-' : 'Download file'?></a></th>
                      </tr>
                      <tr>
                        <td><hr class="sidebar-divider"></td>
                        <td></td>
                        <td><hr class="sidebar-divider"></td>
                      </tr>
                    </tbody>
                  </table>
            </div>
        </div>

        <div class="d-sm-flex align-items-center justify-content-between mb-4 mt-5">
          <h1 class="h3 mb-2 text-gray-800">Revisi Anggota Penguji 1</h1>
      </div>
      <div class="row mt-5">
        <div class="col-md-12">
          <table class="table table-borderless">
                  <tbody>
                    <tr>
                      <td>Revisi</td>
                      <td>:</td>
                      <th><textarea rows="10" class="form-control">{{ $item->revisi2 }}</textarea></th>
                    </tr>
                    <tr>
                      <td>File Pendukung</td>
                      <td>:</td>
                      <th><a href="/download/{{$item->nim}}/proposal/revisi dari dosen/{{$item->file2}}"><?=$item->file2 == null ? '-' : 'Download file'?></a></th>
                    </tr>
                    <tr>
                      <td><hr class="sidebar-divider"></td>
                      <td></td>
                      <td><hr class="sidebar-divider"></td>
                    </tr>
                  </tbody>
                </table>
          </div>
      </div>


      <div class="d-sm-flex align-items-center justify-content-between mb-4 mt-5">
        <h1 class="h3 mb-2 text-gray-800">Revisi Anggota Penguji 2</h1>
    </div>
    <div class="row mt-5">
      <div class="col-md-12">
        <table class="table table-borderless">
                <tbody>
                  <tr>
                    <td>Revisi</td>
                    <td>:</td>
                    <th><textarea rows="10" class="form-control">{{ $item->revisi3 }}</textarea></th>
                  </tr>
                  <tr>
                    <td>File Pendukung</td>
                    <td>:</td>
                    <th><a href="/download/{{$item->nim}}/proposal/revisi dari dosen/{{$item->file3}}"><?=$item->file3 == null ? '-' : 'Download file'?></a></th>
                  </tr>
                  <tr>
                    <td><hr class="sidebar-divider"></td>
                    <td></td>
                    <td><hr class="sidebar-divider"></td>
                  </tr>
                </tbody>
              </table>
        </div>
    </div>

    </div>
@endsection