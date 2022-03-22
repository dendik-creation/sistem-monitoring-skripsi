@extends('dosen.main')

@section('content')
    <div class="container-fluid mt-4">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Monitoring Bimbingan Skripsi Mahasiswa</h1>
            
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

        <ul class="nav nav-tabs mt-5">
            <li class="nav-item active">
              <a data-toggle="tab" class="nav-link h6 active" href="#dosen1">Bimbingan Kepada Saya</a>
            </li>
            <li class="nav-item">
              <a data-toggle="tab" class="nav-link h6" href="#dosen2">Bimbingan Kepada Dosen Lain</a>
            </li>
          </ul>

        <!-- Content Row -->
        <div class="tab-content">
            <div id="dosen1" class="tab-pane fade show active">
                <div class="card shadow mt-4">
                    <div class="card-body">
                        <div class="pull-right col-md-2 mb-5 float-right">
                            <select class="custom-select" id="filterbimbingan">
                                <option value="3" id="3">All</option>
                                <option value="4" id="4">Review</option>
                                <option value="1" id="1">Pembimbing Utama</option>
                                <option value="2" id="2">Pembimbing Pembantu</option>
                            </select>
                        </div>
                        <div class="table-responsive">
                            <table id="dataTable" style="width:100%" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Semester</th>
                                        <th>NIM</th>
                                        <th>Nama</th>
                                        <th>Judul</th>
                                        <th>Bimbingan Ke</th>
                                        <th>Bimbingan Kepada</th>
                                        <th>Status</th>
                                        <th>Detail</th>
                                    </tr>
                                </thead>
                                <tbody id="datatabel">
                                    <?php $no=1?>
                                    @foreach($dosbing1 as $item)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $item -> semester}} {{ $item -> tahun}}</td>
                                            <td>{{ $item -> nim }}</td>
                                            <td>{{ $item -> nama }}</td>
                                            <td>{{ $item -> judul }}</td>
                                            <td>{{ $item -> bimbingan_ke }}</td>
                                            <td>
                                                @if ($item -> depan1 == "Y")
                                                    {{ $item -> gelar31 }} {{ $item -> dosen }}, {{ $item -> gelar11 }}, {{ $item -> gelar21 }}</p>
                                                @else
                                                @if ($item->depan1==null)
                                                {{ $item -> dosen }}, {{ $item -> gelar11 }}, {{ $item -> gelar21 }}    
                                                @else
                                                    
                                                {{ $item -> dosen }}, {{ $item -> gelar11 }}, {{ $item -> gelar21 }}, {{ $item -> gelar31 }}</p>
                                                @endif
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item -> bimbingan_kepada == $user -> no_induk && $item -> dosbing1 == $user -> no_induk)
                                                <p style="pointer-events: none;" class="btn btn-sm <?=($item -> ket1 == 'Ok' || $item -> ket1 == 'Siap ujian' ? 'btn-success' : 'btn-warning')?>">{{ $item -> ket1 }}
                                                @elseif ($item -> bimbingan_kepada != $user -> no_induk && $item -> dosbing1 == $user -> no_induk)
                                                <p style="pointer-events: none;" class="btn btn-sm <?=($item -> ket2 == 'Ok' || $item -> ket2 == 'Siap ujian' ? 'btn-success' : 'btn-warning')?>">{{ $item -> ket2 }}
                                                @elseif ($item -> bimbingan_kepada == $user -> no_induk && $item -> dosbing2 == $user -> no_induk)
                                                <p style="pointer-events: none;" class="btn btn-sm <?=($item -> ket2 == 'Ok' || $item -> ket2 == 'Siap ujian' ? 'btn-success' : 'btn-warning')?>">{{ $item -> ket2 }}
                                                @elseif ($item -> bimbingan_kepada != $user -> no_induk && $item -> dosbing2 == $user -> no_induk)
                                                <p style="pointer-events: none;" class="btn btn-sm <?=($item -> ket1 == 'Ok' || $item -> ket1 == 'Siap ujian' ? 'btn-success' : 'btn-warning')?>">{{ $item -> ket1 }}
                                                @endif
                                            </td>
                                            <td><a href="/dosen/monitoring/bimbingan/detail/{{ $item->nim }}/{{ $item->id }}" class="btn btn-sm btn-primary">Lihat Detail</a></td>
                                        </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
            
                    </div>
                </div>
            </div>
            <div id="dosen2" class="tab-pane fade">
                <div class="card shadow mt-4">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="dataTable2" style="width:100%" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Semester</th>
                                        <th>NIM</th>
                                        <th>Nama</th>
                                        <th>Judul</th>
                                        <th>Bimbingan Ke</th>
                                        <th>Bimbingan Kepada</th>
                                        <th>Status</th>
                                        <th>Detail</th>
                                    </tr>
                                </thead>
                                <tbody id="datatabel">
                                    <?php $no=1?>
                                    @foreach($dosbing2 as $item)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $item -> semester}} {{ $item -> tahun}}</td>
                                            <td>{{ $item -> nim }}</td>
                                            <td>{{ $item -> nama }}</td>
                                            <td>{{ $item -> judul }}</td>
                                            <td>{{ $item -> bimbingan_ke }}</td>
                                            <td>
                                                @if ($item -> depan1 == "Y")
                                                    {{ $item -> gelar31 }} {{ $item -> dosen }}, {{ $item -> gelar11 }}, {{ $item -> gelar21 }}</p>
                                                @else
                                                @if ($item->depan1==null)
                                                {{ $item -> dosen }}, {{ $item -> gelar11 }}, {{ $item -> gelar21 }}    
                                                @else
                                                    
                                                {{ $item -> dosen }}, {{ $item -> gelar11 }}, {{ $item -> gelar21 }}, {{ $item -> gelar31 }}</p>
                                                @endif
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item -> bimbingan_kepada == $user -> no_induk && $item -> dosbing1 == $user -> no_induk)
                                                <p style="pointer-events: none;" class="btn btn-sm <?=($item -> ket1 == 'Ok' || $item -> ket1 == 'Siap ujian' ? 'btn-success' : 'btn-warning')?>">{{ $item -> ket1 }}
                                                @elseif ($item -> bimbingan_kepada != $user -> no_induk && $item -> dosbing1 == $user -> no_induk)
                                                <p style="pointer-events: none;" class="btn btn-sm <?=($item -> ket2 == 'Ok' || $item -> ket2 == 'Siap ujian' ? 'btn-success' : 'btn-warning')?>">{{ $item -> ket2 }}
                                                @elseif ($item -> bimbingan_kepada == $user -> no_induk && $item -> dosbing2 == $user -> no_induk)
                                                <p style="pointer-events: none;" class="btn btn-sm <?=($item -> ket2 == 'Ok' || $item -> ket2 == 'Siap ujian' ? 'btn-success' : 'btn-warning')?>">{{ $item -> ket2 }}
                                                @elseif ($item -> bimbingan_kepada != $user -> no_induk && $item -> dosbing2 == $user -> no_induk)
                                                <p style="pointer-events: none;" class="btn btn-sm <?=($item -> ket1 == 'Ok' || $item -> ket1 == 'Siap ujian' ? 'btn-success' : 'btn-warning')?>">{{ $item -> ket1 }}
                                                @endif
                                            </td>
                                            <td><a href="/dosen/monitoring/bimbingan/detail/{{ $item->nim }}/{{ $item->id }}" class="btn btn-sm btn-primary">Lihat Detail</a></td>
                                        </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
            
                    </div>
                </div>
            </div>
        </div>

        
    </div>

@endsection