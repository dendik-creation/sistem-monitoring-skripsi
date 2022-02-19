<!DOCTYPE html>
<html>
<head><meta http-equiv=Content-Type content="text/html; charset=UTF-8">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.3.0/paper.css">
<style type="text/css">


span.cls_003{font-family:Times,serif;font-size:16.0px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
div.cls_003{font-family:Times,serif;font-size:14.0px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
span.cls_004{font-family:Times,serif;font-size:20px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
div.cls_004{font-family:Times,serif;font-size:30px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
span.cls_005{font-family:Times,serif;font-size:14px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none; text-align: justify}
div.cls_005{font-family:Times,serif;font-size:12.1px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
span.cls_013{font-family:Times,serif;font-size:16.1px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
div.cls_013{font-family:Times,serif;font-size:16.1px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
span.cls_014{font-family:Times,serif;font-size:10px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
div.cls_014{font-family:Times,serif;font-size:12.1px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
hr.new4 {
  border: 1px solid black;
  width: 100%
}
@page { size: A5 }

</style>
<script type="text/javascript" src="a79abe0e-65bc-11eb-8b25-0cc47a792c0a_id_a79abe0e-65bc-11eb-8b25-0cc47a792c0a_files/wz_jsgraphics.js"></script>
</head>
<body class="A5">


  <div style="position:absolute;left:50%;margin-left:-306px;top:0px;width:612px;height:1008px;overflow:hidden">
    <div style="position: absolute; left: 15px; top: 27px"></div>
    <div style="position: absolute; left: 191px; top: 44px; letter-spacing: 0.1em;" class="cls_004"><span class="cls_004"><b>BUKU KONSULTASI</b></span></div>
      <div style="position: absolute; left: 178px; top: 78px; letter-spacing: 0.1em;" class="cls_005"><span class="cls_004"><b>SKRIPSI/TUGAS AKHIR</b></span></div>
	  <div style="position: absolute; left: 250px; top: 131px; width: 115px; height: 155px;">
        <img src="{{  url('photo.png') }}" width=113 height=151>
        </div>
	  
    <div style="position: absolute; left: 80px; top: 340px" class="cls_005"><b>Nama</b></div>
  <div style="position: absolute; left: 248px; top: 343px" class="cls_005">: {{ $user->name }}</div>
  <div style="position: absolute; left: 80px; top: 370px" class="cls_005"><span class="cls_005"><b>NIM</b></span></div>
    <div style="position: absolute; left: 248px; top: 373px" class="cls_005"><span class="cls_005">: {{ $user->no_induk }}</span></div>
  <div style="position: absolute; left: 80px; top: 400px; width: 146px;" class="cls_005"><span class="cls_005"><b>Pembimbing Utama</b></span></div>
  <div style="position: absolute; left: 248px; top: 403px" class="cls_005"><span class="cls_005">: @if ($dosen1 -> depan == "Y")
    {{ $dosen1 -> gelar3 }} {{ $dosen1 -> name }}, {{ $dosen1 -> gelar1 }}, {{ $dosen1 -> gelar2 }}
@else
    {{ $dosen1 -> name }}, {{ $dosen1 -> gelar1 }}, {{ $dosen1 -> gelar2 }}, {{ $dosen1 -> gelar3 }}
@endif</span></div>
  <div style="position: absolute; left: 80px; top: 432px; width: 191px;" class="cls_005"><span class="cls_005"><b>Pembimbing Pembantu</b></span></div>
	  <div style="position: absolute; left: 249px; top: 432px" class="cls_005"><span class="cls_005">: @if ($dosen2 -> depan == "Y")
      {{ $dosen2 -> gelar3 }} {{ $dosen2 -> name }}, {{ $dosen2 -> gelar1 }}, {{ $dosen2 -> gelar2 }}
  @else
      {{ $dosen2 -> name }}, {{ $dosen2 -> gelar1 }}, {{ $dosen2 -> gelar2 }}, {{ $dosen2 -> gelar3 }}
  @endif</span></div>
  <div style="position: absolute; left: 80px; top: 464px; width: 191px;" class="cls_005"><span class="cls_005"><b>Judul Skripsi/TA</b></span></div>
	  <div style="position: absolute; left: 93px; top: 495px" class="cls_005"><span class="cls_005">{{ $prop->judul }}</span></div>
	  <div style="position: absolute; left: 245px; top: 562px; width: 131px;" class="cls_005"><b>Kudus, <?=tgl_indo(date('Y-m-d'), false);?></b></div>
  <table style="position: absolute; left: 25px; top: 582px; width: 570px; height: 200px; border-collapse: collapse;"200" border="0">
    <tbody>
      <tr>
        <td style="text-align: center; border-bottom:none;" height="40" width="225"><span class="cls_005">Pembimbing Utama</span></td>
		    <td style="text-align: center; border-bottom:none;" height="40" width="225"><span class="cls_005">Pembimbing Pembantu</span></td>
      </tr>
      <tr>
        <td style="text-align: center; border-bottom:none; border-top:none;" height="120">
          <img src="{{ url('ttd/'.$dosen1->nidn.'/'.$dosen1->ttd) }}" alt="" srcset="" height="50" width="auto">
        </td>
	      <td style="text-align: center; border-bottom:none; border-top:none;" height="120">
          <img src="{{ url('ttd/'.$dosen2->nidn.'/'.$dosen2->ttd) }}" alt="" srcset="" height="50" width="auto">
        </td>
      </tr>
      <tr>
        <td style="text-align: center; border-top:none;"><span class="cls_005"><b>@if ($dosen1 -> depan == "Y")
                              {{ $dosen1 -> gelar3 }} {{ $dosen1 -> name }}, {{ $dosen1 -> gelar1 }}, {{ $dosen1 -> gelar2 }}
                          @else
                              {{ $dosen1 -> name }}, {{ $dosen1 -> gelar1 }}, {{ $dosen1 -> gelar2 }}, {{ $dosen1 -> gelar3 }}
                          @endif</b></span></td>
		    <td style="text-align: center; border-top:none;"><span class="cls_005"><b>@if ($dosen2 -> depan == "Y")
                              {{ $dosen2 -> gelar3 }} {{ $dosen2 -> name }}, {{ $dosen2 -> gelar1 }}, {{ $dosen2 -> gelar2 }}
                          @else
                              {{ $dosen2 -> name }}, {{ $dosen2 -> gelar1 }}, {{ $dosen2 -> gelar2 }}, {{ $dosen2 -> gelar3 }}
                          @endif</b></span></td>
      </tr>
    </tbody>
  </table>
</div>


<div style="position:absolute;left:50%;margin-left:-306px;top:810px;width:612px;height:850px;overflow:hidden">
  <table style="position: absolute; left: 45px; top: 80px; width: 530px; border-collapse: collapse;"200" border="0">
    <tr>
      <td colspan="4" style="text-align: center"><span class="cls_003"><b>CATATAN<br>BIMBINGAN DAN KONSULTASI<br>PEMBIMBING UTAMA</b></span></td>
    </tr>
    <tr>
      <td colspan="4">
        <table style="margin-top:20px; margin-bottom:20px; border-collapse: collapse;"200" border="1">
          <thead>
              <tr>
                  <th>No.</th>
                  <th>Tanggal</th>
                  <th>Catatan Bimbingan</th>
                  <th>TTD</th>
              </tr>
          </thead>
          <tbody id="datatabel">
              <?php $no=1?>
                @foreach($data1 as $item)
                  <tr>
                      <td>{{ $no++ }}</td>
                      {{-- <td>{{ substr(tgl_indo($item->created_at, true), 0, 9)}}</td> --}}
                      <td>
                          @php
                              $tgl = substr($item->created_at, 0, 10);
                              $hasil = tgl_indo($tgl, true);
                              echo $hasil;
                          @endphp
                      </td>
                      <td>
                          Bimbingan Ke-{{ $item->bimbingan_ke }} kepada {{ $item->name }} <br>
                          @if ($item->ket1 == "-")
                              Status : {{ $item->ket2 }} <br><br>
                          @else
                              Status : {{ $item->ket1 }} <br><br>
                          @endif
                          @php
                              $pesan = DB::table('pesan_bimbingan')
                              ->select('pesan_bimbingan.*')
                              ->where('id_bimbingan', $item->id)
                              ->get();
        
                              $count = DB::table('pesan_bimbingan')
                              ->select('pesan_bimbingan.*')
                              ->where('id_bimbingan', $item->id)
                              ->count();
                          @endphp
                          @if ($count==0)
                              Catatan : -<br>
                          @else
                              @foreach($pesan as $psn)
                                  Catatan : {{ $psn->pesan }}<br>
                              @endforeach
                          @endif
                      </td>
                      <td><img src="{{ url('ttd/'.$item->nidn.'/'.$item->ttd) }}" alt="" srcset="" height="40" width="auto"></td>
                  </tr>
             @endforeach
          </tbody>
        </table>
      </td>
    </tr>
    <tr>
      <td colspan="4" style="text-align: center"><span class="cls_003"><b>CATATAN<br>BIMBINGAN DAN KONSULTASI<br>PEMBIMBING PEMBANTU</b></span></td>
    </tr>
    <tr>
      <td colspan="4">
        <table style="margin-top:20px; margin-bottom:20px; border-collapse: collapse;"200" border="1">
          <thead>
              <tr>
                  <th>No.</th>
                  <th>Tanggal</th>
                  <th>Catatan Bimbingan</th>
                  <th>TTD</th>
              </tr>
          </thead>
          <tbody id="datatabel">
              <?php $no=1?>
                @foreach($data2 as $item)
                  <tr>
                      <td>{{ $no++ }}</td>
                      {{-- <td>{{ substr(tgl_indo($item->created_at, true), 0, 9)}}</td> --}}
                      <td>
                          @php
                              $tgl = substr($item->created_at, 0, 10);
                              $hasil = tgl_indo($tgl, true);
                              echo $hasil;
                          @endphp
                      </td>
                      <td>
                          Bimbingan Ke-{{ $item->bimbingan_ke }} kepada {{ $item->name }} <br>
                          @if ($item->ket1 == "-")
                              Status : {{ $item->ket2 }} <br><br>
                          @else
                              Status : {{ $item->ket1 }} <br><br>
                          @endif
                          @php
                              $pesan = DB::table('pesan_bimbingan')
                              ->select('pesan_bimbingan.*')
                              ->where('id_bimbingan', $item->id)
                              ->get();
        
                              $count = DB::table('pesan_bimbingan')
                              ->select('pesan_bimbingan.*')
                              ->where('id_bimbingan', $item->id)
                              ->count();
                          @endphp
                          @if ($count==0)
                              Catatan : -<br>
                          @else
                              @foreach($pesan as $psn)
                                  Catatan : {{ $psn->pesan }}<br>
                              @endforeach
                          @endif
                      </td>
                      <td><img src="{{ url('ttd/'.$item->nidn.'/'.$item->ttd) }}" alt="" srcset="" height="40" width="auto"></td>
                  </tr>
             @endforeach
          </tbody>
        </table>
      </td>
    </tr>
  </table>



<script>
	window.print()	
</script>
</body>
</html>