@extends('admin.main')

@section('content')
    <div class="container-fluid mt-4">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-2 text-gray-800">Cek Berkas Seminar Proposal</h1>
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
                      <tr>
                        <td>Tanggal Pendaftaran</td>
                        <td>:</td>
                        <th><?=tgl_indo(substr($item->tgl_daftar, 0, 10), true);?></th>
                      </tr>
                    </tbody>
                  </table>
                
            </div>
        </div>
        <div class="row mt-2">
          <table class="table table-bordered mt-2">
            <thead>
                <th>No.</th>
                <th>Berkas</th>
                <th>File</th>
            </thead>
            <tbody>
                <tr>
                    <td>1.</td>
                    <td>Scan Bukti Pembayaran (JPG/PNG/PDF) (Max 2MB)</td>
                    <td><a href="<?=url('/filemhs/'.$item->nim.'/berkas_sempro/'.$item->scan_bukti_bayar)?>" target="_blank"><?=$item->scan_bukti_bayar == null ? '' : 'Lihat berkas'?></a></td>
                </tr>
                <tr>
                    <td>2.</td>
                    <td>Proposal Skripsi (PDF) (Max 10MB)</td>
                    <td><a href="<?=url('/filemhs/'.$item->nim.'/berkas_sempro/'.$item->proposal)?>" target="_blank"><?=$item->proposal == null ? '' : 'Lihat berkas'?></a></td>
                </tr>
                <tr>
                    <td>3.</td>
                    <td>Scan KRS (JPG/PNG/PDF) (Max 2MB)</td>
                    <td><a href="<?=url('/filemhs/'.$item->nim.'/berkas_sempro/'.$item->krs)?>" target="_blank"><?=$item->krs == null ? '' : 'Lihat berkas'?></a></td>
                </tr>
                <tr>
                    <td>4.</td>
                    <td>Scan Transkrip Nilai (JPG/PNG/PDF) (Max 2MB)</td>
                    <td><a href="<?=url('/filemhs/'.$item->nim.'/berkas_sempro/'.$item->transkrip)?>" target="_blank"><?=$item->transkrip == null ? '' : 'Lihat berkas'?></a></td>
                </tr>
            </tbody>
        </table>
          <div class="ml-2 mt-4 mb-4 row">
            <form action="/admin/berkas/sempro/ok/{{ $item->id }}" method="POST">
              {{csrf_field()}}
              {{method_field('PUT')}}
              <button type="submit" value="Berkas OK" class="btn btn-primary mr-2">Berkas OK</button>
          </form>
          <button type="button" class="btn btn-primary mr-2" data-toggle="modal" data-target="#modal{{$item->id}}">
            Berkas tidak lengkap
        </button>
        <div class="modal fade" id="modal{{$item->id}}" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Komentar</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
              </div>
              <form class="user" method="POST" action="/admin/berkas/sempro/kurang/{{ $item->id }}">
                  {{csrf_field()}}
                  {{method_field('PUT')}}
                  <div class="modal-body">
                      <div class="form-group">
                          <label for="" class="small">Komentar*</label>
                          <textarea class="form-control" name="komentar_admin" placeholder="Masukkan Komentar" required></textarea>
                      </div>
                  </div>
                  <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" name="submit" class="btn btn-primary">Komentar</button>
                  </div>
              </form>
          </div>
          </div>
      </div>
              <a href="/admin/proposal/pendaftar" class="btn btn-secondary">Batal</a>
          </div>
        </div>
        @endforeach
    </div>
@endsection


