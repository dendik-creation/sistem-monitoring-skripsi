@extends('mahasiswa.main')

@section('content')
    <div class="container-fluid mt-4">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-2 text-gray-800">Detail Bimbingan</h1>
            <div class="pull-right">
              <a href="/mahasiswa/skripsi/bimbingan" class="btn btn-secondary btn-flat">
                  Kembali
              </a>
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

        {{-- Form --}}
        <div class="row mt-5">
          <div class="col-md-6">
            <table class="table table-borderless">
                    <tbody>
                      <tr>
                        <td>NIM</td>
                        <td>:</td>
                        <th>{{ $data->nim }}</th>
                      </tr>
                      <tr>
                        <td>Nama</td>
                        <td>:</td>
                        <th>{{ $data->nama }}</th>
                      </tr>
                      <tr>
                        <td>Judul</td>
                        <td>:</td>
                        <th>{{ $data->judul }}</th>
                      </tr>
                      @if ($data->bimbingan_kepada == $data->dosbing1)
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
                            @endif - Bimbingan Ke-{{ $data->bimbingan_ke }} - {{ $data->ket1 }}</th>
                        </tr>
                      @else
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
                            @endif @endif - Bimbingan Ke-{{ $data->bimbingan_ke }} - {{ $data->ket2 }}</th>
                        </tr>
                      @endif
                    </tbody>
                  </table>
                {{-- <div class="ml-2 mt-4">
                    <a href="{{ route('databimbingan')}}" class="btn btn-secondary">Kembali</a>
                </div> --}}
            </div>
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tbody>
                      <tr>
                        <td>Bimbingan Ke</td>
                        <td>:</td>
                        <th>{{ $data->bimbingan_ke }}</th>
                      </tr>
                      <tr>
                        <td>File</td>
                        <td>:</td>
                        <th><a href="/download/{{ $data->nim }}/berkas_sempro/{{$data->file}}"><?=$data->file == null ? '' : 'Download file'?></th>
                      </tr>
                      <tr>
                        <td>Keterangan</td>
                        <td>:</td>
                        <th>{{ $data->komentar }}</th>
                      </tr>
                      <tr>
                        <td>Tanggal Upload</td>
                        <td>:</td>
                        <th><?=tgl_indo(substr($data->tgl, 0, 10), false);?> <?=substr($data->tgl, 11, 5)?> WIB</th>
                      </tr>
                    </tbody>
                  </table>
            </div>
        </div>

        <div class="d-sm-flex align-items-center justify-content-between mb-4 mt-4">
          <h1 class="h3 mb-2 text-gray-800">Catatan Bimbingan</h1>
          <div class="pull-right">
            <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modaldefault">
              Tambah Catatan Bimbingan
            </button>
            <!-- Modal -->
            <div class="modal fade" id="modaldefault" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Catatan Bimbingan</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
                  </div>
                  <form action="/mahasiswa/balas/pesan" method="post">
                      {{csrf_field()}}
                      {{method_field('POST')}}
                      <div class="modal-body">
                        {{-- <div class="form-group">
                          <label for="" class="small">File*</label><br>
                          <input type="file" name="file" placeholder="Masukkan File" required>
                        </div> --}}
                        <div class="form-group">
                            <label for="" class="small">Pesan</label><br>
                            <input type="hidden" name="id_bimbingan" value="{{ $data->id }}">
                            <input type="hidden" name="id_user" value="{{ $user->id }}">
                            <textarea class="form-control" name="pesan" placeholder="Masukkan Pesan"></textarea>
                        </div>
                      </div>
                      <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <button type="submit" name="submit" class="btn btn-primary">Tambah</button>
                      </div>
                  </form>
              </div>
              </div>
            </div>
          </div>
      </div>

        <div class="row-mt-5 mb-5">
          @foreach ($pesan as $item)
          <div class="card mb-4">
            <div class="card-header">
              {{ $item->name }}
              <p class="float-right small"><?=tgl_indo(substr($item->waktu, 0, 10), false);?> <?=substr($item->waktu, 11, 5)?> WIB</p>
            </div>
            <div class="card-body">
              {{ $item->pesan }}<br> <br>
              <a href="/download/{{ $data->nim }}/revisibimbingan/{{$item->file_pendukung}}"><?=$item->file_pendukung == null ? '' : 'Download file'?></a>
            </div>
          </div>
          @endforeach
        </div>



    </div>
@endsection