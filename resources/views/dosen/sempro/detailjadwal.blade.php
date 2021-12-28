@extends('dosen.main')

@section('content')
    <div class="container-fluid mt-4">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-2 text-gray-800">Detail Jadwal Seminar Proposal</h1>
            <div class="pull-right">
              <a href="{{ route('datajadwalsemprodosen')}}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>

        {{-- Form --}}
        <form class="user" action="/dosen/sempro/inserthasil" method="POST">
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
                        <td>Judul</td>
                        <td>:</td>
                        <th>{{ $item->judul }}</th>
                      </tr>
                      <tr>
                        <td>Berkas Seminar</td>
                        <td>:</td>
                        <th><a href="/download/{{ $item->nim }}/berkas_sempro/{{$item->berkas_sempro}}">{{$item->berkas_sempro}}</a></th>
                      </tr>
                      <tr>
                        <td>Dosen Pembimbing Utama</td>
                        <td>:</td>
                        <th>{{ $dosen1->gelar3 }} {{ $dosen1->name }}, {{ $dosen1->gelar1 }}, {{ $dosen1->gelar2 }}</th>
                      </tr>
                      <tr>
                        <td>Dosen Pembimbing Pembantu</td>
                        <td>:</td>
                        <th>{{ $dosen2->gelar3 }} {{ $dosen2->name }}, {{ $dosen2->gelar1 }}, {{ $dosen2->gelar2 }}</th>
                      </tr>
                      <tr>
                        <td>Jadwal Seminar</td>
                        <td>:</td>
                        <th>{{ tgl_indo($item->tanggal, true)}}</th>
                      </tr>
                      <tr>
                        <td>Pukul / Tempat</td>
                        <td>:</td>
                        <th>{{ $item -> jam }} WIB / {{ $item -> tempat }}</th>
                      </tr>
                      <tr>
                        <td>Keterangan</td>
                        <td>:</td>
                        <th><textarea cols="30" rows="10" class="form-control">{{  $item -> ket  }}</textarea></th>
                      </tr>
                      <input type="hidden" value="{{ $item -> nim }}" name="nim">
                      <input type="hidden" value="{{ $item -> id_proposal }}" name="id_proposal">
                      <input type="hidden" value="{{ $item -> id }}" name="id_jadwal_sempro">
                      <input type="hidden" value="{{ $id_hasil_sempro->id }}" name="id_hasil_sempro">
                    </tbody>
                  </table>
            </div>
            
        </div>

      <div class="d-sm-flex align-items-center justify-content-between mb-4 mt-5">
          <h1 class="h3 mb-2 text-gray-800">Dosen Pembimbing Utama</h1>
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
                          <input class="form-check-input" type="radio" name="berita_acara" id="inlineRadio1" value="Diterima" <?=$item->dosbing1==$user->no_induk ? '' : 'disabled'?>>
                          <label class="form-check-label" for="inlineRadio1">Diterima</label>
                          <input class="form-check-input ml-5" type="radio" name="berita_acara" id="inlineRadio2" value="Ditolak" <?=$item->dosbing1==$user->no_induk ? '' : 'disabled'?>>
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
                      <td>Nilai Sikap(20%)</td>
                      <td>:</td>
                      <th><input type="text" class="form-control" name="sikap1" placeholder="Masukkan Nilai Sikap" required <?=$item->dosbing1==$user->no_induk ? '' : 'disabled'?>></th>
                    </tr>
                    <tr>
                      <td>Nilai Presentasi(30%)</td>
                      <td>:</td>
                      <th><input type="text" class="form-control" name="presentasi1" placeholder="Masukkan Nilai Presentasi" required <?=$item->dosbing1==$user->no_induk ? '' : 'disabled'?>></th>
                    </tr>
                    <tr>
                      <td>Nilai Penguasaan Teori(50%)</td>
                      <td>:</td>
                      <th><input type="text" class="form-control" name="penguasaan1" placeholder="Masukkan Nilai Penguasaan Teori" required <?=$item->dosbing1==$user->no_induk ? '' : 'disabled'?>></th>
                    </tr>
                    <tr>
                      <td>Jumlah</td>
                      <td>:</td>
                      <th><input type="text" class="form-control" name="jumlah1" placeholder="Masukkan Jumlah" required <?=$item->dosbing1==$user->no_induk ? '' : 'disabled'?>></th>
                    </tr>
                    <tr>
                      <td>Grade</td>
                      <td>:</td>
                      <th>
                        <select class="form-control" name="grade1" <?=$item->dosbing1==$user->no_induk ? '' : 'disabled'?>>
                          <option>Pilih Grade --</option>
                          <option>A</option>
                          <option>AB</option>
                          <option>B</option>
                          <option>BC</option>
                          <option>C</option>
                          <option>CD</option>
                          <option>D</option>
                          <option>E</option>
                      </select>
                    </th>
                    </tr>
                    <tr>
                      <td><hr class="sidebar-divider"></td>
                      <td></td>
                      <td><hr class="sidebar-divider"></td>
                    </tr>
                    <tr>
                      <td>Revisi</td>
                      <td>:</td>
                      <th><textarea class="form-control" name="revisi1" placeholder="Masukkan Revisi" <?=$item->dosbing1==$user->no_induk ? '' : 'disabled'?>></textarea></th>
                    </tr>
                    <tr>
                      <td></td>
                      <td></td>
                      <td>
                        <button class="btn btn-primary" <?=$item->dosbing1==$user->no_induk ? '' : 'disabled'?>>Simpan</button>
                        <a href="{{url()->previous()}}" class="btn btn-secondary" <?=$item->dosbing1==$user->no_induk ? '' : 'style="pointer-events: none;"'?>>Batal</a>
                      </td>
                    </tr>
                  </tbody>
                </table>
          </div>
      </div>

      <div class="d-sm-flex align-items-center justify-content-between mb-4 mt-5">
        <h1 class="h3 mb-2 text-gray-800">Dosen Pembimbing Pembantu</h1>
    </div>
    <div class="row mt-5">
      <div class="col-md-12">
        <table class="table table-borderless">
                <tbody>
                  <tr>
                    <td>Nilai Sikap(20%)</td>
                    <td>:</td>
                    <th><input type="text" class="form-control" name="sikap2" placeholder="Masukkan Nilai Sikap" required <?=$item->dosbing2==$user->no_induk ? '' : 'disabled'?>></th>
                  </tr>
                  <tr>
                    <td>Nilai Presentasi(30%)</td>
                    <td>:</td>
                    <th><input type="text" class="form-control" name="presentasi2" placeholder="Masukkan Nilai Presentasi" required <?=$item->dosbing2==$user->no_induk ? '' : 'disabled'?>></th>
                  </tr>
                  <tr>
                    <td>Nilai Penguasaan Teori(50%)</td>
                    <td>:</td>
                    <th><input type="text" class="form-control" name="penguasaan2" placeholder="Masukkan Nilai Penguasaan Teori" required <?=$item->dosbing2==$user->no_induk ? '' : 'disabled'?>></th>
                  </tr>
                  <tr>
                    <td>Jumlah</td>
                    <td>:</td>
                    <th><input type="text" class="form-control" name="jumlah2" placeholder="Masukkan Jumlah" required <?=$item->dosbing2==$user->no_induk ? '' : 'disabled'?>></th>
                  </tr>
                  <tr>
                    <td>Grade</td>
                    <td>:</td>
                    <th>
                      <select class="form-control" name="grade2" <?=$item->dosbing2==$user->no_induk ? '' : 'disabled'?>>
                        <option>Pilih Grade --</option>
                        <option>A</option>
                        <option>AB</option>
                        <option>B</option>
                        <option>BC</option>
                        <option>C</option>
                        <option>CD</option>
                        <option>D</option>
                        <option>E</option>
                    </select>
                  </th>
                  </tr>
                  <tr>
                    <td><hr class="sidebar-divider"></td>
                    <td></td>
                    <td><hr class="sidebar-divider"></td>
                  </tr>
                  <tr>
                    <td>Revisi</td>
                    <td>:</td>
                    <th><textarea class="form-control" name="revisi2" placeholder="Masukkan Revisi" <?=$item->dosbing2==$user->no_induk ? '' : 'disabled'?>></textarea></th>
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
      @endforeach
      </form>

    </div>
@endsection