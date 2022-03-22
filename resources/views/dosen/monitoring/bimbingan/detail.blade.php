@extends('dosen.main')

@section('content')
    <div class="container-fluid mt-4">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-2 text-gray-800">Detail Bimbingan</h1>
            <div class="pull-right">
              <div class="ml-2 row">
                @if ($data->bimbingan_kepada == $user->no_induk)
                <a href="{{ route('databimbinganmahasiswa') }}" class="btn btn-secondary btn-flat">
                  Kembali 
                </a>
                <form action="/dosen/monitoring/bimbingan/selesai/{{ $data->id }}" method="post">
                    {{csrf_field()}}
                    {{method_field('PUT')}}
  
                    
                    @if ($data -> dosbing1 == $user -> no_induk)
                      @if ($data -> ket1 == 'Ok')
                        <button type="submit" class="btn btn-success ml-2" disabled>Bimbingan Ke-{{ $data->bimbingan_ke }} Selesai</button>
                        @elseif ($data -> ket1 == 'Selesai Bimbingan')
                        
                        @else
                        @if ($data->ket1=='Lanjut ke bimbingan selanjutnya' || $data->ket1=='Ok' || $data->ket1=='Siap ujian')
                            
                        @else
                        <button type="submit" value="Ok" class="btn btn-success ml-2">Ok</button>
                        @endif
                      @endif
                    @else
                    @if ($data -> ket2 == 'Ok')
                        <button type="submit" class="btn btn-success ml-2" disabled>Bimbingan Ke-{{ $data->bimbingan_ke }} Selesai</button>
                        @elseif ($data -> ket1 == 'Selesai Bimbingan')
                        @else
                        @if ($data->ket2=='Lanjut ke bimbingan selanjutnya' || $data->ket2=='Ok' || $data->ket2=='Siap ujian')
                            
                        @else
                        <button type="submit" value="Ok" class="btn btn-success ml-2">Ok</button>
                        @endif
                      @endif
                    @endif
                </form>
                <form action="/dosen/monitoring/bimbingan/revisi/{{ $data->id }}" method="post">
                  {{csrf_field()}}
                  {{method_field('PUT')}}
                  
                  @if ($data -> dosbing1 == $user -> no_induk)
                    @if ($data -> ket1 == 'Lanjut ke bimbingan selanjutnya')
                      <button type="submit" class="btn btn-warning ml-2" disabled>Lanjut ke bimbingan selanjutnya</button>
                      @elseif ($data -> ket1 == 'Selesai Bimbingan')
                      @else
                      @if ($data->ket1=='Ok' || $data->ket1=='Lanjut ke bimbingan selanjutnya' || $data->ket1=='Siap ujian')
                          
                      @else
                      <button type="submit" value="Ok" class="btn btn-warning ml-2">Revisi</button>    
                      @endif
                    @endif
                  @else
                  @if ($data -> ket2 == 'Lanjut ke bimbingan selanjutnya')
                      <button type="submit" class="btn btn-warning ml-2" disabled>Lanjut ke bimbingan selanjutnya</button>
                      @elseif ($data -> ket1 == 'Selesai Bimbingan')
                      @else
                      @if ($data->ket2=='Ok' || $data->ket2=='Lanjut ke bimbingan selanjutnya' || $data->ket2=='Siap ujian')
                          
                      @else
                      <button type="submit" value="Ok" class="btn btn-warning ml-2">Revisi</button>    
                      @endif
                    @endif
                  @endif
              </form>
              <form action="/dosen/monitoring/bimbingan/siapujian/{{ $data->id }}" method="post">
                {{csrf_field()}}
                {{method_field('PUT')}}
              
                
                @if ($data -> dosbing1 == $user -> no_induk)
                          @if ($data -> ket1 == 'Siap ujian')
                            <button type="submit" class="btn btn-success ml-2" disabled>Mahasiswa siap ujian</button>
                          @else
                            @if ($data->ket1=='Ok' || $data->ket1=='Siap ujian' || $data->ket1=='Lanjut ke bimbingan selanjutnya')
                                
                            @else
                            <button type="submit" class="btn btn-success btn-flat ml-2" onclick="return confirm('Yakin?');">
                              Siap ujian
                            </button>                              
                            @endif
                            @endif
                          @else
                          @if ($data -> ket2 == 'Siap ujian')
                          <button type="submit" class="btn btn-success ml-2" disabled>Mahasiswa siap ujian</button>
                        @else
                            @if ($data->ket2=='Ok' || $data->ket2=='Siap ujian' || $data->ket2=='Lanjut ke bimbingan selanjutnya')
                                
                            @else
                            <button type="submit" class="btn btn-success btn-flat ml-2" onclick="return confirm('Yakin?');">
                              Siap ujian
                            </button>
                            @endif
                          @endif
                        {{-- @else
                        @if ($data -> ket2 == 'Selesai Bimbingan')
                            <button type="submit" class="btn btn-success ml-2" disabled>Mahasiswa sudah selesai bimbingan</button>
                          @else
                            <button type="submit" class="btn btn-success btn-flat" onclick="return confirm('Yakin?');">
                  Selesai Semua Bimbingan
                </button>
                          @endif --}}
                        @endif
      
              </form>                
                @else
                <a href="{{ route('databimbinganmahasiswa') }}" class="btn btn-secondary btn-flat">
                  Kembali
                </a>
                @endif
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
                      <tr>
                        <td>Dosen Pembimbing Utama</td>
                        <td>:</td>
                        <th>@if ($dosen1 -> depan == "Y")
                              {{ $dosen1 -> gelar3 }} {{ $dosen1 -> name }}, {{ $dosen1 -> gelar1 }}, {{ $dosen1 -> gelar2 }}
                          @else
                          @if ($dosen1 -> depan ==null)
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
                          @if ($dosen2 -> depan ==null)
                          {{ $dosen2 -> name }}, {{ $dosen2 -> gelar1 }}, {{ $dosen2 -> gelar2 }}    
                          @else
                              
                          {{ $dosen2 -> name }}, {{ $dosen2 -> gelar1 }}, {{ $dosen2 -> gelar2 }}, {{ $dosen2 -> gelar3 }}
                          @endif
                          @endif @endif</th>
                      </tr>
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
                        <th><a href="/download/{{$data->nim}}/bimbingan/{{$data->file}}"><?=$data->file == null ? '' : 'Download file'?></a></th>
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
            @if ($data->bimbingan_kepada != $user->no_induk)
                
            @else
            <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modaldefault">
              Tambah Catatan Bimbingan
            </button>                
            @endif
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
                  <form action="/dosen/balas/pesan" method="post" enctype="multipart/form-data">
                      {{csrf_field()}}
                      {{method_field('POST')}}
                      <div class="modal-body">
                        <div class="form-group">
                          <label for="" class="small">Pesan*</label><br>
                          <textarea class="form-control" name="pesan" placeholder="Masukkan Pesan" required></textarea>
                      </div>
                      <div class="form-group">
                        <label for="" class="small">File Pendukung</label><br>
                        <input type="file" name="file_pendukung" placeholder="Masukkan File Pendukung" accept=".doc, .docx, .pdf">
                      </div>
                      <input type="hidden" name="nim" value="{{$data->nim}}" id="">
                      <input type="hidden" name="id_bimbingan" value="{{ $data->id }}">
                      <input type="hidden" name="id_user" value="{{ $user->id }}">
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
              <p class="card-text">
                {{ $item->pesan }}<br> <br>
                <a href="/download/{{ $data->nim }}/revisibimbingan/{{$item->file_pendukung}}"><?=$item->file_pendukung == null ? '' : 'Download file'?></a>
              </p>
            </div>
          </div>
          @endforeach
        </div>

        

    </div>
@endsection