@extends('admin.main')

@section('content')
    <div class="container-fluid mt-4">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-2 text-gray-800">Detail Jadwal Ujian Skripsi</h1>
            <div class="pull-right">
              <a href="{{ route('dataskripsipenjadwalan')}}" class="btn btn-secondary">Kembali</a>
            </div>
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
                          @if ($dosen1->depan==null)
                          {{ $dosen1 -> name }}, {{ $dosen1 -> gelar1 }}, {{ $dosen1 -> gelar2 }}
                          @else
                              
                          {{ $dosen1 -> name }}, {{ $dosen1 -> gelar1 }}, {{ $dosen1 -> gelar2 }}, {{ $dosen1 -> gelar3 }}
                          @endif
                          @endif</th>
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
                          @if ($dosen2->depan==null)
                          {{ $dosen2 -> name }}, {{ $dosen2 -> gelar1 }}, {{ $dosen2 -> gelar2 }}
                          @else
                              
                          {{ $dosen2 -> name }}, {{ $dosen2 -> gelar1 }}, {{ $dosen2 -> gelar2 }}, {{ $dosen2 -> gelar3 }}
                          @endif
                          @endif
                        @endif</th>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <hr class="sidebar-divider mt-5">
        <div class="row mt-5">
          <div class="col-md-6">
            <table class="table table-borderless">
                    <tbody>
                      <tr>
                        <td>Ketua Penguji</td>
                        <td>:</td>
                        <th>@if ($ketua -> depan == "Y")
                          {{ $ketua -> gelar3 }} {{ $ketua -> name }}, {{ $ketua -> gelar1 }}, {{ $ketua -> gelar2 }}
                      @else
                      @if ($ketua -> depan ==null)
                      {{ $ketua -> name }}, {{ $ketua -> gelar1 }}, {{ $ketua -> gelar2 }}    
                      @else
                          
                      {{ $ketua -> name }}, {{ $ketua -> gelar1 }}, {{ $ketua -> gelar2 }}, {{ $ketua -> gelar3 }}
                      @endif
                      @endif</th>
                      </tr>
                      <tr>
                        <td>Anggota Penguji 1</td>
                        <td>:</td>
                        <th>@if ($anggota1 -> depan == "Y")
                          {{ $anggota1 -> gelar3 }} {{ $anggota1 -> name }}, {{ $anggota1 -> gelar1 }}, {{ $anggota1 -> gelar2 }}
                      @else
                      @if ($anggota1 -> depan ==null)
                      {{ $anggota1 -> name }}, {{ $anggota1 -> gelar1 }}, {{ $anggota1 -> gelar2 }}    
                      @else
                          
                      {{ $anggota1 -> name }}, {{ $anggota1 -> gelar1 }}, {{ $anggota1 -> gelar2 }}, {{ $anggota1 -> gelar3 }}
                      @endif
                      @endif</th>
                      </tr>
                      <tr>
                        <td>Anggota Penguji 2</td>
                        <td>:</td>
                        <th>@if ($anggota2 -> depan == "Y")
                          {{ $anggota2 -> gelar3 }} {{ $anggota2 -> name }}, {{ $anggota2 -> gelar1 }}, {{ $anggota2 -> gelar2 }}
                      @else
                      @if ($anggota2 -> depan ==null)
                      {{ $anggota2 -> name }}, {{ $anggota2 -> gelar1 }}, {{ $anggota2 -> gelar2 }}    
                      @else
                          
                      {{ $anggota2 -> name }}, {{ $anggota2 -> gelar1 }}, {{ $anggota2 -> gelar2 }}, {{ $anggota2 -> gelar3 }}
                      @endif
                      @endif</th>
                      </tr>
                    </tbody>
                  </table>
                  <div class="ml-2 mt-4 mb-4">
                    @if ($item -> status1 == 'Sudah' && $item -> status2 == 'Sudah' && $item -> status3 == 'Sudah')
                      {{-- <a href="/ujian/hasil/cetak/{{ $hasil_ujian->id }}" target="_blank" class="btn btn-primary">Cetak Dokumen</a> --}}
                    @else
                      <a href="https://wa.me/{{ $item->hp }}" class="btn btn-success btn-flat" target="_blank">
                        Kirim Pesan WA
                      </a>
                    @endif
                    
  
                  </div>
            </div>
            <div class="col-md-5 ml-4">
              
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
        </div>
        @endforeach
    </div>
@endsection