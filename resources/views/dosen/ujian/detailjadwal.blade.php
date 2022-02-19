@extends('dosen.main')

@section('content')
    <div class="container-fluid mt-4">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-2 text-gray-800">Detail Jadwal Ujian Skripsi</h1>
            <div class="pull-right">
              <a href="{{ route('datajadwalujiandosen')}}" class="btn btn-secondary">Kembali</a>
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
        <form class="user" action="/dosen/skripsi/inserthasil" method="POST" enctype="multipart/form-data">
        {{csrf_field()}}

        <div class="row mt-5">
          @foreach($data as $item)
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
                  <td><hr class="sidebar-divider"></td>
                  <td></td>
                  <td><hr class="sidebar-divider"></td>
                </tr>
                <tr>
                  <td>Judul</td>
                  <td>:</td>
                  <th>{{ $item->judul }}</th>
                </tr>
                <tr>
                  <td>Berkas Ujian</td>
                  <td>:</td>
                  <th><a href="/download/{{ $item->nim }}/berkas_ujian/{{$item->berkas_ujian}}"><?=$item->berkas_ujian == null ? '' : 'Download berkas ujian'?></a></th>
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
                  <td><hr class="sidebar-divider"></td>
                  <td></td>
                  <td><hr class="sidebar-divider"></td>
                </tr>
                <tr>
                  <td>Ketua Penguji</td>
                  <td>:</td>
                  <th>
                    @if ($ketua -> depan == "Y")
                        {{ $ketua -> gelar3 }} {{ $ketua -> name }}, {{ $ketua -> gelar1 }}, {{ $ketua -> gelar2 }}
                    @else
                        {{ $ketua -> name }}, {{ $ketua -> gelar1 }}, {{ $ketua -> gelar2 }}, {{ $ketua -> gelar3 }}
                    @endif
                  </th>
                </tr>
                <tr>
                  <td>Anggota Penguji 1</td>
                  <td>:</td>
                  <th>
                    @if ($anggota1 -> depan == "Y")
                        {{ $anggota1 -> gelar3 }} {{ $anggota1 -> name }}, {{ $anggota1 -> gelar1 }}, {{ $anggota1 -> gelar2 }}
                    @else
                        {{ $anggota1 -> name }}, {{ $anggota1 -> gelar1 }}, {{ $anggota1 -> gelar2 }}, {{ $anggota1 -> gelar3 }}
                    @endif
                  </th>
                </tr>
                <tr>
                  <td>Anggota Penguji 2</td>
                  <td>:</td>
                  <th>
                    @if ($anggota2 -> depan == "Y")
                        {{ $anggota2 -> gelar3 }} {{ $anggota2 -> name }}, {{ $anggota2 -> gelar1 }}, {{ $anggota2 -> gelar2 }}
                    @else
                        {{ $anggota2 -> name }}, {{ $anggota2 -> gelar1 }}, {{ $anggota2 -> gelar2 }}, {{ $anggota2 -> gelar3 }}
                    @endif
                  </th>
                </tr>
                <tr>
                  <td><hr class="sidebar-divider"></td>
                  <td></td>
                  <td><hr class="sidebar-divider"></td>
                </tr>
                <tr>
                  <td>Jadwal Ujian Skripsi</td>
                  <td>:</td>
                  <th>{{ tgl_indo($item->tanggal, true)}}</th>
                </tr>
                <tr>
                  <td>Pukul</td>
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
                  <th><textarea cols="30" rows="10" class="form-control">{{ $item->ket }}</textarea></th>
                </tr>
                <input type="hidden" value="{{ $item -> nim }}" name="nim">
                <input type="hidden" value="{{ $item -> id_proposal }}" name="id_proposal">
                <input type="hidden" value="{{ $item -> id }}" name="id_jadwal_ujian">
                <input type="hidden" value="{{ $id_hasil_ujian->id }}" name="id_hasil_ujian">
                <input type="hidden" value="{{ $id_status_skripsi->id }}" name="id_status_skripsi">
              </tbody>
            </table>
          </div>
                
        </div>
              

        <ul class="nav nav-tabs mt-5">
          <li class="nav-item active">
            <a data-toggle="tab" class="nav-link h6 <?=$item->ketua_penguji==$user->no_induk ? 'active' : 'disabled'?>" href="#ketua">Ketua Penguji</a>
          </li>
          <li class="nav-item">
            <a data-toggle="tab" class="nav-link h6 <?=$item->anggota_penguji_1==$user->no_induk ? 'active' : 'disabled'?>" href="#anggota1">Anggota Penguji 1</a>
          </li>
          <li class="nav-item">
            <a data-toggle="tab" class="nav-link h6 <?=$item->anggota_penguji_2==$user->no_induk ? 'active' : 'disabled'?>" href="#anggota2">Anggota Penguji 2</a>
          </li>
          <li class="nav-item">
            <a data-toggle="tab" class="nav-link h6 <?=$item->dosbing2==$user->no_induk ? 'active' : 'disabled'?>" href="#dosbing2">Dosen Pembimbing Pembantu</a>
          </li>
        </ul>

        <div class="tab-content">
          <div id="ketua" class="tab-pane fade <?=$item->ketua_penguji==$user->no_induk ? 'show active' : ''?>">
            {{-- Ketua Penguji --}}
            <div class="d-sm-flex align-items-center justify-content-between mb-4 mt-5">
              <h1 class="h3 mb-2 text-gray-800">Ketua Penguji</h1>
            </div>
            <div class="row mt-5">
              <div class="col-md-12">
                <table class="table table-borderless">
                        <tbody>
                          <tr>
                            <td>Berita Acara</td>
                            <td>:</td>
                            <th>
                              <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="berita_acara" id="inlineRadio1" value="Lulus" <?=$item->ketua_penguji==$user->no_induk ? '' : 'disabled'?>>
                                <label class="form-check-label" for="inlineRadio1">Lulus</label>
                                <input class="form-check-input ml-5" type="radio" name="berita_acara" id="inlineRadio2" value="Tidak Lulus" <?=$item->ketua_penguji==$user->no_induk ? '' : 'disabled'?>>
                                <label class="form-check-label" for="inlineRadio2">Tidak Lulus</label>
                              </div>
                          </th>
                          </tr>
                          <tr>
                            <td><hr class="sidebar-divider"></td>
                            <td></td>
                            <td><hr class="sidebar-divider"></td>
                          </tr>
                          <tr>
                            <td>Nilai Sikap(10%) (1-100)</td>
                            <td>:</td>
                            <th><input type="text" class="form-control" name="sikap1" id="ujiansikap1" onkeyup="ujian1()" placeholder="Masukkan Nilai Sikap" <?=$item->ketua_penguji==$user->no_induk ? '' : 'disabled'?>></th>
                          </tr>
                          <tr>
                            <td>Nilai Presentasi(10%) (1-100)</td>
                            <td>:</td>
                            <th><input type="text" class="form-control" name="presentasi1" id="ujianpresentasi1" onkeyup="ujian1()" placeholder="Masukkan Nilai Presentasi" <?=$item->ketua_penguji==$user->no_induk ? '' : 'disabled'?>></th>
                          </tr>
                          <tr>
                            <td>Nilai Penguasaan Teori(40%) (1-100)</td>
                            <td>:</td>
                            <th><input type="text" class="form-control" name="teori1" id="ujianteori1" onkeyup="ujian1()" placeholder="Masukkan Nilai Penguasaan Teori" <?=$item->ketua_penguji==$user->no_induk ? '' : 'disabled'?>></th>
                          </tr>
                          <tr>
                            <td>Nilai Penguasaan Program(40%) (1-100)</td>
                            <td>:</td>
                            <th><input type="text" class="form-control" name="program1" id="ujianprogram1" onkeyup="ujian1()" placeholder="Masukkan Nilai Penguasaan Program" <?=$item->ketua_penguji==$user->no_induk ? '' : 'disabled'?>></th>
                          </tr>
                          <tr>
                            <td>Jumlah</td>
                            <td>:</td>
                            <th><input type="text" class="form-control" name="jumlah1" id="ujianjumlah1" placeholder="Masukkan Jumlah" required <?=$item->ketua_penguji==$user->no_induk ? '' : 'disabled'?>></th>
                          </tr>
                          {{-- <tr>
                            <td>Keterangan</td>
                            <td>:</td>
                            <th>
                              <select class="form-control" name="keterangan1" <?=//$item->ketua_penguji==$user->no_induk ? '' : 'disabled'?> required>
                                <option>Pilih Keterangan --</option>
                                <option>Lulus</option>
                                <option>Tidak Lulus</option>
                            </select>
                          </th>
                          </tr> --}}
                          <tr>
                            <td><hr class="sidebar-divider"></td>
                            <td></td>
                            <td><hr class="sidebar-divider"></td>
                          </tr>
                          <tr>
                            <td>Revisi</td>
                            <td>:</td>
                            <th><textarea class="form-control" name="revisi1" placeholder="Masukkan Revisi" <?=$item->ketua_penguji==$user->no_induk ? '' : 'disabled'?>></textarea></th>
                          </tr>
                          <tr>
                            <td>File Pendukung (DOC, DOCX, PDF) (Max 30MB)</td>
                            <td>:</td>
                            <th><input type="file" name="file_pendukung1" placeholder="Masukkan File Pendukung (DOC, DOCX, PDF) (Max 30MB)" accept=".doc, .docx, .pdf"></th>
                          </tr>
                          <tr>
                            <td></td>
                            <td></td>
                            <td>
                              <button class="btn btn-primary" <?=$item->ketua_penguji==$user->no_induk ? '' : 'disabled'?>>Simpan</button>
                              <a href="{{url()->previous()}}" class="btn btn-secondary" <?=$item->ketua_penguji==$user->no_induk ? '' : 'style="pointer-events: none;"'?>>Batal</a>
                            </td>
                          </tr>
                        </tbody>
                      </table>
              </div>
            </div>
          </div>
          <div id="anggota1" class="tab-pane fade <?=$item->anggota_penguji_1==$user->no_induk ? 'show active' : ''?>">
              {{-- Anggota Penguji 1 --}}
              <div class="d-sm-flex align-items-center justify-content-between mb-4 mt-5">
                  <h1 class="h3 mb-2 text-gray-800">Anggota Penguji 1 / Dosen Pembimbing Utama</h1>
              </div>
              <div class="row mt-5">
                <div class="col-md-12">
                  <table class="table table-borderless">
                          <tbody>
                            <tr>
                              <td>Nilai Sikap(10%) (1-100)</td>
                              <td>:</td>
                              <th><input type="text" class="form-control" name="sikap2" id="ujiansikap2" onkeyup="ujian2()" placeholder="Masukkan Nilai Sikap" <?=$item->anggota_penguji_1==$user->no_induk ? '' : 'disabled'?>></th>
                            </tr>
                            <tr>
                              <td>Nilai Presentasi(10%) (1-100)</td>
                              <td>:</td>
                              <th><input type="text" class="form-control" name="presentasi2" id="ujianpresentasi2" onkeyup="ujian2()" placeholder="Masukkan Nilai Presentasi" <?=$item->anggota_penguji_1==$user->no_induk ? '' : 'disabled'?>></th>
                            </tr>
                            <tr>
                              <td>Nilai Penguasaan Teori(40%) (1-100)</td>
                              <td>:</td>
                              <th><input type="text" class="form-control" name="teori2" id="ujianteori2" onkeyup="ujian2()" placeholder="Masukkan Nilai Penguasaan Teori" <?=$item->anggota_penguji_1==$user->no_induk ? '' : 'disabled'?>></th>
                            </tr>
                            <tr>
                              <td>Nilai Penguasaan Program(40%) (1-100)</td>
                              <td>:</td>
                              <th><input type="text" class="form-control" name="program2" id="ujianprogram2" onkeyup="ujian2()" placeholder="Masukkan Nilai Penguasaan Program" <?=$item->anggota_penguji_1==$user->no_induk ? '' : 'disabled'?>></th>
                            </tr>
                            <tr>
                              <td>Jumlah</td>
                              <td>:</td>
                              <th><input type="text" class="form-control" name="jumlah2" id="ujianjumlah2" placeholder="Masukkan Jumlah" required <?=$item->anggota_penguji_1==$user->no_induk ? '' : 'disabled'?>></th>
                            </tr>
                            {{-- <tr>
                              <td>Keterangan</td>
                              <td>:</td>
                              <th>
                                <select class="form-control" name="keterangan2" <?=//$item->anggota_penguji_1==$user->no_induk ? '' : 'disabled'?> required>
                                  <option>Pilih Keterangan --</option>
                                  <option>Lulus</option>
                                  <option>Tidak Lulus</option>
                              </select>
                            </th>
                            </tr> --}}
                            <tr>
                              <td><hr class="sidebar-divider"></td>
                              <td></td>
                              <td><hr class="sidebar-divider"></td>
                            </tr>
                            <tr>
                              <td>Revisi</td>
                              <td>:</td>
                              <th><textarea class="form-control" name="revisi2" placeholder="Masukkan Revisi" <?=$item->anggota_penguji_1==$user->no_induk ? '' : 'disabled'?>></textarea></th>
                            </tr>
                            <tr>
                              <td>File Pendukung (DOC, DOCX, PDF) (Max 30MB)</td>
                              <td>:</td>
                              <th><input type="file" name="file_pendukung2" placeholder="Masukkan File Pendukung (DOC, DOCX, PDF) (Max 30MB)" accept=".doc, .docx, .pdf"></th>
                            </tr>
                            <tr>
                              <td></td>
                              <td></td>
                              <td>
                                <button class="btn btn-primary" <?=$item->anggota_penguji_1==$user->no_induk ? '' : 'disabled'?>>Simpan</button>
                                <a href="{{url()->previous()}}" class="btn btn-secondary" <?=$item->anggota_penguji_1==$user->no_induk ? '' : 'style="pointer-events: none;"'?>>Batal</a>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                  </div>
              </div>
          </div>
          <div id="anggota2" class="tab-pane fade <?=$item->anggota_penguji_2==$user->no_induk ? 'show active' : ''?>">
              {{-- Anggota Penguji 2 --}}
              <div class="d-sm-flex align-items-center justify-content-between mb-4 mt-5">
                  <h1 class="h3 mb-2 text-gray-800">Anggota Penguji 2</h1>
              </div>
              <div class="row mt-5">
                <div class="col-md-12">
                  <table class="table table-borderless">
                          <tbody>
                            <tr>
                              <td>Nilai Sikap(10%) (1-100)</td>
                              <td>:</td>
                              <th><input type="text" class="form-control" name="sikap3" id="ujiansikap3" onkeyup="ujian3()" placeholder="Masukkan Nilai Sikap" <?=$item->anggota_penguji_2==$user->no_induk ? '' : 'disabled'?>></th>
                            </tr>
                            <tr>
                              <td>Nilai Presentasi(10%) (1-100)</td>
                              <td>:</td>
                              <th><input type="text" class="form-control" name="presentasi3" id="ujianpresentasi3" onkeyup="ujian3()" placeholder="Masukkan Nilai Presentasi" <?=$item->anggota_penguji_2==$user->no_induk ? '' : 'disabled'?>></th>
                            </tr>
                            <tr>
                              <td>Nilai Penguasaan Teori(40%) (1-100)</td>
                              <td>:</td>
                              <th><input type="text" class="form-control" name="teori3" id="ujianteori3" onkeyup="ujian3()" placeholder="Masukkan Nilai Penguasaan Teori" <?=$item->anggota_penguji_2==$user->no_induk ? '' : 'disabled'?>></th>
                            </tr>
                            <tr>
                              <td>Nilai Penguasaan Program(40%) (1-100)</td>
                              <td>:</td>
                              <th><input type="text" class="form-control" name="program3" id="ujianprogram3" onkeyup="ujian3()" placeholder="Masukkan Nilai Penguasaan Program" <?=$item->anggota_penguji_2==$user->no_induk ? '' : 'disabled'?>></th>
                            </tr>
                            <tr>
                              <td>Jumlah</td>
                              <td>:</td>
                              <th><input type="text" class="form-control" name="jumlah3" id="ujianjumlah3" placeholder="Masukkan Jumlah" required <?=$item->anggota_penguji_2==$user->no_induk ? '' : 'disabled'?>></th>
                            </tr>
                            {{-- <tr>
                              <td>Keterangan</td>
                              <td>:</td>
                              <th>
                                <select class="form-control" name="keterangan3" <?=//$item->anggota_penguji_2==$user->no_induk ? '' : 'disabled'?> required>
                                  <option>Pilih Keterangan --</option>
                                  <option>Lulus</option>
                                  <option>Tidak Lulus</option>
                              </select>
                            </th>
                            </tr> --}}
                            <tr>
                              <td><hr class="sidebar-divider"></td>
                              <td></td>
                              <td><hr class="sidebar-divider"></td>
                            </tr>
                            <tr>
                              <td>Revisi</td>
                              <td>:</td>
                              <th><textarea class="form-control" name="revisi3" placeholder="Masukkan Revisi" <?=$item->anggota_penguji_2==$user->no_induk ? '' : 'disabled'?>></textarea></th>
                            </tr>
                            <tr>
                              <td>File Pendukung (DOC, DOCX, PDF) (Max 30MB)</td>
                              <td>:</td>
                              <th><input type="file" name="file_pendukung3" placeholder="Masukkan File Pendukung (DOC, DOCX, PDF) (Max 30MB)" accept=".doc, .docx, .pdf"></th>
                            </tr>
                            <tr>
                              <td></td>
                              <td></td>
                              <td>
                                <button class="btn btn-primary" <?=$item->anggota_penguji_2==$user->no_induk ? '' : 'disabled'?>>Simpan</button>
                                <a href="{{url()->previous()}}" class="btn btn-secondary" <?=$item->anggota_penguji_2==$user->no_induk ? '' : 'style="pointer-events: none;"'?>>Batal</a>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                  </div>
              </div>
          </div>
          <div id="dosbing2" class="tab-pane fade <?=$item->dosbing2==$user->no_induk ? 'show active' : ''?>">
              {{-- Dosbing 2 --}}
              <div class="d-sm-flex align-items-center justify-content-between mb-4 mt-5">
                  <h1 class="h3 mb-2 text-gray-800">Dosen Pembimbing Pembantu</h1>
              </div>
              <div class="row mt-5">
                <div class="col-md-12">
                  <table class="table table-borderless">
                          <tbody>
                            <tr>
                              <td>Nilai Sikap(10%) (1-100)</td>
                              <td>:</td>
                              <th><input type="text" class="form-control" name="sikap4" id="ujiansikap4" onkeyup="ujian4()" placeholder="Masukkan Nilai Sikap" <?=$item->dosbing2==$user->no_induk ? '' : 'disabled'?>></th>
                            </tr>
                            <tr>
                              <td>Nilai Presentasi(10%) (1-100)</td>
                              <td>:</td>
                              <th><input type="text" class="form-control" name="presentasi4" id="ujianpresentasi4" onkeyup="ujian4()" placeholder="Masukkan Nilai Presentasi" <?=$item->dosbing2==$user->no_induk ? '' : 'disabled'?>></th>
                            </tr>
                            <tr>
                              <td>Nilai Penguasaan Teori(40%) (1-100)</td>
                              <td>:</td>
                              <th><input type="text" class="form-control" name="teori4" id="ujianteori4" onkeyup="ujian4()" placeholder="Masukkan Nilai Penguasaan Teori" <?=$item->dosbing2==$user->no_induk ? '' : 'disabled'?>></th>
                            </tr>
                            <tr>
                              <td>Nilai Penguasaan Program(40%) (1-100)</td>
                              <td>:</td>
                              <th><input type="text" class="form-control" name="program4" id="ujianprogram4" onkeyup="ujian4()" placeholder="Masukkan Nilai Penguasaan Program" <?=$item->dosbing2==$user->no_induk ? '' : 'disabled'?>></th>
                            </tr>
                            <tr>
                              <td>Jumlah</td>
                              <td>:</td>
                              <th><input type="text" class="form-control" name="jumlah4" id="ujianjumlah4" placeholder="Masukkan Jumlah" required <?=$item->dosbing2==$user->no_induk ? '' : 'disabled'?>></th>
                            </tr>
                            {{-- <tr>
                              <td>Keterangan</td>
                              <td>:</td>
                              <th>
                                <select class="form-control" name="keterangan4" <?=//$item->dosbing2==$user->no_induk ? '' : 'disabled'?> required>
                                  <option>Pilih Keterangan --</option>
                                  <option>Lulus</option>
                                  <option>Tidak Lulus</option>
                              </select>
                            </th>
                            </tr> --}}
                            <tr>
                              <td><hr class="sidebar-divider"></td>
                              <td></td>
                              <td><hr class="sidebar-divider"></td>
                            </tr>
                            <tr>
                              <td>Revisi</td>
                              <td>:</td>
                              <th><textarea class="form-control" name="revisi4" placeholder="Masukkan Revisi" <?=$item->dosbing2==$user->no_induk ? '' : 'disabled'?>></textarea></th>
                            </tr>
                            <tr>
                              <td>File Pendukung (DOC, DOCX, PDF) (Max 30MB)</td>
                              <td>:</td>
                              <th><input type="file" name="file_pendukung4" placeholder="Masukkan File Pendukung (DOC, DOCX, PDF) (Max 30MB)" accept=".doc, .docx, .pdf"></th>
                            </tr>
                            <tr>
                              <td></td>
                              <td></td>
                              <td>
                                <button class="btn btn-primary" <?=$item->dosbing2==$user->no_induk ? '' : 'disabled'?>>Simpan</button>
                                <a href="{{url()->previous()}}" class="btn btn-secondary" <?=$item->dosbing2==$user->no_induk ? '' : 'style="pointer-events: none;"'?>>Batal</a>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                  </div>
              </div>
          </div>
        </div>
      
      @endforeach
      </form>

    </div>
@endsection