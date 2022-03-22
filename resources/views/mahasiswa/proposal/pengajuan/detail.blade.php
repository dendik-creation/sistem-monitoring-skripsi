@extends('mahasiswa.main')

@section('content')
    <div class="container-fluid mt-4">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-2 text-gray-800">Detail Pengajuan Proposal</h1>
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
                        <th>{{ $item->name }}</th>
                      </tr>
                      <tr>
                        <td>Topik</td>
                        <td>:</td>
                        <th>{{ $item->topik }}</th>
                      </tr>
                      <tr>
                        <td>Judul</td>
                        <td>:</td>
                        <th>{{ $item->judul }}</th>
                      </tr>
                      <tr>
                        <td>File</td>
                        <td>:</td>
                        <th><a href="/download/{{ $item->nim }}/proposal/{{$item->proposal}}"><?=$item->proposal == null ? '' : 'Download file proposal mahasiswa'?></a></th>
                      </tr>
                      <tr>
                        <td>Keterangan</td>
                        <td>:</td>
                        <th>{{ $item->komentar }}</th>
                      </tr>
                    </tbody>
                  </table>
                <div class="ml-2 mt-4">
                  @if ($item->ket1 =="Ditolak" || $item->ket2 =="Ditolak")
                  <a class="btn btn-danger mr-2" style="pointer-events: none">
                    Proposal ditolak, silahkan ajukan proposal baru
                  </a>
                  @elseif($item->ket1 =="Revisi" && $item->ket2 =="Revisi")
                  <button type="button" class="btn btn-primary mr-2" data-toggle="modal" data-target="#modalrev{{$item->id}}">
                    Upload Revisi Proposal
                  </button>
                  @elseif($item->ket1 =="Revisi" || $item->ket2 =="Revisi")
                  <button type="button" class="btn btn-primary mr-2" data-toggle="modal" data-target="#modalrev{{$item->id}}">
                    Upload Revisi Proposal
                  </button>
                  @endif
                    <a href="{{ route('datapengajuanproposal')}}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
            <div class="modal fade" id="modalrev{{$item->id}}" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Upload Revisi Proposal</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
                  </div>
                  <form action="/mahasiswa/proposal/revisi/{{$item->id}}" method="post" enctype="multipart/form-data">
                      {{csrf_field()}}
                      {{method_field('PUT')}}
                      <div class="modal-body">
                        <div class="form-group">
                          <label for="" class="small">Revisi Proposal* (DOCX, DOC, PDF) (Max 10MB)</label><br>
                          <input type="file" name="proposal" placeholder="Masukkan File" accept=".doc, .docx, .pdf">
                        </div>
                        <div class="form-group">
                            <label for="" class="small">Keterangan(Optional)</label><br>
                            <textarea class="form-control" name="komentar" placeholder="Masukkan Keterangan"></textarea>
                        </div>
                        <input type="hidden" name="nim" value="{{$item->nim}}" id="">
                      </div>
                      <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <button type="submit" name="submit" class="btn btn-primary">Upload</button>
                      </div>
                  </form>
              </div>
              </div>
          </div>
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tbody>
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
                          @endif - <p style="pointer-events: none;" class="btn btn-sm mt-2 <?=($item -> ket1 == 'Disetujui' ? 'btn-success' : ($item -> ket1 == 'Revisi' ? 'btn-warning' : ($item -> ket1 == 'Ditolak' ? 'btn-danger' : 'btn-secondary')))?>">{{ $item -> ket1 }}</th>
                      </tr>
                      <tr>
                        <td>Dosen Pembimbing Pembantu</td>
                        <td>:</td>
                        <th>
                          @if ($dosen2==null)
                                            -
                                        @else
                                        @if ($dosen2 -> depan == "Y")
                              {{ $dosen2 -> gelar3 }} {{ $dosen2 -> name }}, {{ $dosen2 -> gelar1 }}, {{ $dosen2 -> gelar2 }} - <p style="pointer-events: none;" class="btn btn-sm mt-2 <?=($item -> ket2 == 'Disetujui' ? 'btn-success' : ($item -> ket2 == 'Revisi' ? 'btn-warning' : ($item -> ket2 == 'Ditolak' ? 'btn-danger' : 'btn-secondary')))?>">{{ $item -> ket2 }}
                          @else
                          @if ($dosen2->depan==null)
                          {{ $dosen2 -> name }}, {{ $dosen2 -> gelar1 }}, {{ $dosen2 -> gelar2 }} - <p style="pointer-events: none;" class="btn btn-sm mt-2 <?=($item -> ket2 == 'Disetujui' ? 'btn-success' : ($item -> ket2 == 'Revisi' ? 'btn-warning' : ($item -> ket2 == 'Ditolak' ? 'btn-danger' : 'btn-secondary')))?>">{{ $item -> ket2 }}
                          @else
                              
                          {{ $dosen2 -> name }}, {{ $dosen2 -> gelar1 }}, {{ $dosen2 -> gelar2 }}, {{ $dosen2 -> gelar3 }} - <p style="pointer-events: none;" class="btn btn-sm mt-2 <?=($item -> ket2 == 'Disetujui' ? 'btn-success' : ($item -> ket2 == 'Revisi' ? 'btn-warning' : ($item -> ket2 == 'Ditolak' ? 'btn-danger' : 'btn-secondary')))?>">{{ $item -> ket2 }}
                          @endif
                          @endif @endif </th>
                      </tr>
                      <tr>
                        <td>Keterangan Dosen Pembimbing Utama</td>
                        <td>:</td>
                        <th>
                          @if ($item->file1 == null || $item->file1 == '-')
                          {{ $item->komentar1 }}
                          @else
                          {{ $item->komentar1 }} - <a href="/download/{{ $item->nim }}/revisiproposal/{{$item->file1}}">Download file revisi proposal</a></th>
                          @endif
                        </th>
                      </tr>
                      <tr>
                        <td>Keterangan Dosen Pembimbing Pembantu</td>
                        <td>:</td>
                        <th>
                          @if ($dosen2==null)
                                            -
                                        @else
                          @if ($item->file2 == null || $item->file2 == '-')
                          {{ $item->komentar2 }}
                          @else
                          {{ $item->komentar2 }} - <a href="/download/{{ $item->nim }}/revisiproposal/{{$item->file2}}">Download file revisi proposal</a></th>
                          @endif
                          @endif
                        </th>
                      </tr>
                    </tbody>
                  </table>
            </div>
            @endforeach
        </div>

    </div>
@endsection