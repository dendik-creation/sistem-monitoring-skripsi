@extends('dosen.main')

@section('content')
    <div class="container-fluid mt-4">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-2 text-gray-800">Edit Nilai Seminar Proposal</h1>
            <div class="pull-right">
              <a href="/dosen/sempro/nilai" class="btn btn-secondary ml-1">Kembali</a>
            </div>
        </div>

        @if (count($errors) > 0)
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button> 
                <strong>{{ $error }}</strong>
            </div>
        @endforeach
    @endif

        {{-- Form --}}
        @foreach($data as $item)
        <form class="user" action="/dosen/sempro/nilai/{{ $item->id }}" method="POST" enctype="multipart/form-data">
          {{csrf_field()}}
          {{method_field('PUT')}}
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
                        <th>@if ($dosen1 -> depan == "Y")
                              {{ $dosen1 -> gelar3 }} {{ $dosen1 -> name }}, {{ $dosen1 -> gelar1 }}, {{ $dosen1 -> gelar2 }}
                          @else
                          @if ($dosen1->depan == null)
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
                          @if ($dosen2->depan == null)
                          {{ $dosen2 -> name }}, {{ $dosen2 -> gelar1 }}, {{ $dosen2 -> gelar2 }}    
                          @else
                              
                          {{ $dosen2 -> name }}, {{ $dosen2 -> gelar1 }}, {{ $dosen2 -> gelar2 }}, {{ $dosen2 -> gelar3 }}
                          @endif
                          @endif @endif</th>
                      </tr>
                      <tr>
                        <td>Status</td>
                        <td>:</td>
                        <th class="<?=($item->berita_acara == "Diterima" ? 'text-success' : ( $item->berita_acara == "Ditolak" ? 'text-danger' : 'text-warning')) ?>">{{ $item->berita_acara }}</th>
                      </tr>
                    </tbody>
                  </table>
                {{-- <div class="ml-2 mt-4">
                    <a href="/sempro/hasil/cetak/{{ $item->id }}" target="_blank" class="btn btn-primary <?=//$item->status1 == "Sudah" && $item->status2 == "Sudah" ? '' : 'disabled'?>">Lihat Nilai</a>
                    <a href="/dosen/sempro/nilai" class="btn btn-secondary ml-1">Kembali</a>
                </div> --}}
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
                      <input type="hidden" value="{{ $item -> nim }}" name="nim">
                      <input type="hidden" value="{{ $item -> id_proposal }}" name="id_proposal">
                      <input type="hidden" value="{{ $item -> id_jadwal_sempro }}" name="id_jadwal_sempro">
                      <input type="hidden" value="{{ $item -> id }}" name="id_hasil_sempro">
                      {{-- <input type="hidden" value="{{ $dosen2 }}" name="pemb2"> --}}
                    </tbody>
                  </table>
            </div>
            @endforeach
        </div>

        <ul class="nav nav-tabs mt-5">
          <li class="nav-item active">
            <a data-toggle="tab" class="nav-link h6 <?=$item->dosbing1==$user->no_induk ? 'active' : ''?>" href="#dosen1">Dosen Pembimbing Utama</a>
          </li>
          <li class="nav-item">
            <a data-toggle="tab" class="nav-link h6 <?=$item->dosbing2==$user->no_induk ? 'active' : ''?>" href="#dosen2">Dosen Pembimbing Pembantu</a>
          </li>
        </ul>

        <div class="tab-content">
          <div id="dosen1" class="tab-pane fade <?=$item->dosbing1==$user->no_induk ? 'show active' : ''?>">
            <div class="d-sm-flex align-items-center justify-content-between mb-4 mt-5">
              <h1 class="h3 mb-2 text-gray-800">Dosen Pembimbing Utama</h1>
            </div>
            <div class="row mt-5">
              <div class="col-md-12">
                <table class="table table-borderless">
                        <tbody>
                          <tr>
                            <td>Proposal Skripsi</td>
                            <td>:</td>
                            <th>
                              <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="berita_acara" id="inlineRadio1" value="Diterima" <?=$item->dosbing1==$user->no_induk ? '' : 'disabled'?> <?=$item->berita_acara=="Diterima" ? 'checked' : ''?>>
                                <label class="form-check-label" for="inlineRadio1">Diterima</label>
                                <input class="form-check-input ml-5" type="radio" name="berita_acara" id="inlineRadio2" value="Ditolak" <?=$item->dosbing1==$user->no_induk ? '' : 'disabled'?> <?=$item->berita_acara=="Ditolak" ? 'checked' : ''?>>
                                <label class="form-check-label" for="inlineRadio2">Ditolak</label>
                              </div>
                          </th>
                          </tr>
                          <tr>
                            <td><hr class="sidebar-divider"></td>
                            <td></td>
                            <td><hr class="sidebar-divider"></td>
                          </tr>
                          <tr>
                            <td>Nilai Sikap(20%) (1-100)</td>
                            <td>:</td>
                            <th><input type="number" class="form-control" id="semprosikap1" name="sikap1" onkeyup="sempro1()" value="{{ $item->sikap1 }}"  placeholder="Masukkan Nilai Sikap" <?=$item->dosbing1==$user->no_induk ? '' : 'disabled'?>></th>
                          </tr>
                          <tr>
                            <td>Nilai Presentasi(30%) (1-100)</td>
                            <td>:</td>
                            <th><input type="number" class="form-control" id="sempropresentasi1" name="presentasi1" onkeyup="sempro1()" value="{{ $item->presentasi1 }}" placeholder="Masukkan Nilai Presentasi" <?=$item->dosbing1==$user->no_induk ? '' : 'disabled'?>></th>
                          </tr>
                          <tr>
                            <td>Nilai Penguasaan Teori(50%) (1-100)</td>
                            <td>:</td>
                            <th><input type="number" class="form-control" id="sempropenguasaan1" name="penguasaan1" onkeyup="sempro1()" value="{{ $item->penguasaan1 }}" placeholder="Masukkan Nilai Penguasaan Teori" <?=$item->dosbing1==$user->no_induk ? '' : 'disabled'?>></th>
                          </tr>
                          <tr>
                            <td>Jumlah* (1-100)</td>
                            <td>:</td>
                            <th><input type="number" class="form-control" id="semprojumlah1" name="jumlah1" value="{{ $item->jumlah1 }}" placeholder="Masukkan Jumlah" required <?=$item->dosbing1==$user->no_induk ? '' : 'disabled'?>></th>
                          </tr>
                          <tr>
                            <td><hr class="sidebar-divider"></td>
                            <td></td>
                            <td><hr class="sidebar-divider"></td>
                          </tr>
                          <tr>
                            <td>Revisi</td>
                            <td>:</td>
                            <th><textarea class="form-control" name="revisi1" placeholder="Masukkan Revisi" <?=$item->dosbing1==$user->no_induk ? '' : 'disabled'?> rows="5">{{ $item->revisi1 }}</textarea></th>
                          </tr>
                          <tr>
                            <td>File Pendukung (DOCX, DOC, PDF) (Max 30MB)</td>
                            <td>:</td>
                            <th><input type="file" name="file_pendukung1"  placeholder="Masukkan File Pendukung" accept=".doc, .docx, .pdf"><a href="/download/{{$item->nim}}/proposal/revisi dari dosen/{{$item->file1}}"><?=$item->file1 == null ? '-' : 'Download file'?></a></th>
                          </tr>
                          <tr>
                            <td></td>
                            <td></td>
                            <td>
                              <button class="btn btn-primary" <?=$item->dosbing1==$user->no_induk ? '' : 'disabled'?>>Edit</button>
                              <a href="{{url()->previous()}}" class="btn btn-secondary" <?=$item->dosbing1==$user->no_induk ? '' : 'style="pointer-events: none;"'?>>Batal</a>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                </div>
            </div>
          </div>
          <div id="dosen2" class="tab-pane fade <?=$item->dosbing2==$user->no_induk ? 'show active' : 'disabled'?>">
            <div class="d-sm-flex align-items-center justify-content-between mb-4 mt-5">
              <h1 class="h3 mb-2 text-gray-800">Dosen Pembimbing Pembantu</h1>
            </div>
            <div class="row mt-5">
              <div class="col-md-12">
                <table class="table table-borderless">
                        <tbody>
                          <tr>
                            <td>Nilai Sikap(20%) (1-100)</td>
                            <td>:</td>
                            <th><input type="number" class="form-control" id="semprosikap2" name="sikap2" value="{{ $item->sikap2 }}" onkeyup="sempro2()" placeholder="Masukkan Nilai Sikap" <?=$item->dosbing2==$user->no_induk ? '' : 'disabled'?>></th>
                          </tr>
                          <tr>
                            <td>Nilai Presentasi(30%) (1-100)</td>
                            <td>:</td>
                            <th><input type="number" class="form-control" id="sempropresentasi2" name="presentasi2" value="{{ $item->presentasi2 }}" onkeyup="sempro2()" placeholder="Masukkan Nilai Presentasi" <?=$item->dosbing2==$user->no_induk ? '' : 'disabled'?>></th>
                          </tr>
                          <tr>
                            <td>Nilai Penguasaan Teori(50%) (1-100)</td>
                            <td>:</td>
                            <th><input type="number" class="form-control" id="sempropenguasaan2" name="penguasaan2" value="{{ $item->penguasaan2 }}" onkeyup="sempro2()" placeholder="Masukkan Nilai Penguasaan Teori" <?=$item->dosbing2==$user->no_induk ? '' : 'disabled'?>></th>
                          </tr>
                          <tr>
                            <td>Jumlah* (1-100)</td>
                            <td>:</td>
                            <th><input type="number" class="form-control" id="semprojumlah2" name="jumlah2" value="{{ $item->jumlah2 }}" placeholder="Masukkan Jumlah" required <?=$item->dosbing2==$user->no_induk ? '' : 'disabled'?>></th>
                          </tr>
                          <tr>
                            <td><hr class="sidebar-divider"></td>
                            <td></td>
                            <td><hr class="sidebar-divider"></td>
                          </tr>
                          <tr>
                            <td>Revisi</td>
                            <td>:</td>
                            <th><textarea class="form-control" name="revisi2" placeholder="Masukkan Revisi" <?=$item->dosbing2==$user->no_induk ? '' : 'disabled'?> rows="5">{{ $item->revisi2 }}</textarea></th>
                          </tr>
                          <tr>
                            <td>File Pendukung (DOCX, DOC, PDF) (Max 30MB)</td>
                            <td>:</td>
                            <th><input type="file" name="file_pendukung2" placeholder="Masukkan File Pendukung" accept=".doc, .docx, .pdf"><a href="/download/{{$item->nim}}/proposal/revisi dari dosen/{{$item->file2}}"><?=$item->file2 == null ? '-' : 'Download file'?></a></th>
                          </tr>
                          <tr>
                            <td></td>
                            <td></td>
                            <td>
                              <button class="btn btn-primary" <?=$item->dosbing2==$user->no_induk ? '' : 'disabled'?>>Edit</button>
                              <a href="{{url()->previous()}}" class="btn btn-secondary" <?=$item->dosbing2==$user->no_induk ? '' : 'style="pointer-events: none;"'?>>Batal</a>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                </div>
            </div>
              </form>
          </div>
        </div>

    </div>
@endsection