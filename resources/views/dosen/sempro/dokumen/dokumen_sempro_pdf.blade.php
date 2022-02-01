<!DOCTYPE html>
<html>
<head><meta http-equiv=Content-Type content="text/html; charset=UTF-8">
<style type="text/css">


span.cls_003{font-family:Times,serif;font-size:16.0px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
div.cls_003{font-family:Times,serif;font-size:14.0px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
span.cls_004{font-family:Times,serif;font-size:16px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
div.cls_004{font-family:Times,serif;font-size:22.1px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
span.cls_005{font-family:Times,serif;font-size:14px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
div.cls_005{font-family:Times,serif;font-size:12.1px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
span.cls_013{font-family:Times,serif;font-size:16.1px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
div.cls_013{font-family:Times,serif;font-size:16.1px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
span.cls_014{font-family:Times,serif;font-size:14px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
div.cls_014{font-family:Times,serif;font-size:12.1px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
hr.new4 {
  border: 1px solid black;
  width: 100%
}

</style>
<script type="text/javascript" src="a79abe0e-65bc-11eb-8b25-0cc47a792c0a_id_a79abe0e-65bc-11eb-8b25-0cc47a792c0a_files/wz_jsgraphics.js"></script>
</head>
<body>

{{-- Berita Acara --}}
<div style="position:absolute;left:50%;margin-left:-306px;top:0px;width:612px;height:1008px;overflow:hidden">
  <div style="position: absolute; left: 40px; top: 27px">
  <img src="{{  url('logo.png') }}" width=100 height=100>
  </div>
  <div style="position: absolute; left: 247px; top: 35px" class="cls_003"><span class="cls_003">FAKULTAS TEKNIK</span></div>
  <div style="position: absolute; left: 171px; top: 57px" class="cls_004"><span class="cls_004">PROGRAM STUDI TEKNIK INFORMATIKA</span></div>
  <div style="position: absolute; left: 224px; top: 90px" class="cls_005"><span class="cls_003">UNIVERSITAS MURIA KUDUS</span></div>
  <div style="position: absolute; left: 248px; top: 115px" class="cls_005"><span class="cls_005">Jl. Gondang Manis Kudus</span></div>
  <hr class="new4" style="margin-top:145px">
  <div style="position: absolute; left: 154px; top: 168px; width: 321px;" class="cls_013"><span class="cls_014">BERITA ACARA SEMINAR PROPOSAL SKRIPSI</span></div>
  <div style="position: absolute; left: 40px; top: 273px" class="cls_005">Nim</div>
  <div style="position: absolute; left: 200px; top: 273px" class="cls_005"><span class="cls_005">: {{ $data->nim }}</span></div>
  <div style="position: absolute; left: 40px; top: 303px" class="cls_005"><span class="cls_005">Nama</span></div>
  <div style="position: absolute; left: 200px; top: 303px" class="cls_005"><span class="cls_005">: {{ $data->nama }}</span></div>
  <div style="position: absolute; left: 40px; top: 333px" class="cls_005"><span class="cls_005">Judul</span></div>
  <div style="position: absolute; left: 200px; top: 333px" class="cls_005"><span class="cls_005">:</span></div>
  <div style="position: absolute; left: 208px; top: 333px" class="cls_005"><span class="cls_005">{{ $data->judul }}</span></div>
  <div style="position: absolute; left: 40px; top: 370px" class="cls_005"><span class="cls_005">Pembimbing Utama</span></div>
  <div style="position: absolute; left: 200px; top: 370px" class="cls_005"><span class="cls_005">: @if ($dosen1 -> depan == "Y")
                              {{ $dosen1 -> gelar3 }} {{ $dosen1 -> name }}, {{ $dosen1 -> gelar1 }}, {{ $dosen1 -> gelar2 }}
                          @else
                              {{ $dosen1 -> name }}, {{ $dosen1 -> gelar1 }}, {{ $dosen1 -> gelar2 }}, {{ $dosen1 -> gelar3 }}
                          @endif</span></div>
  <div style="position: absolute; left: 40px; top: 403px" class="cls_005"><span class="cls_005">Pembimbing Pembantu</span></div>
  <div style="position: absolute; left: 200px; top: 403px" class="cls_005"><span class="cls_005">: @if ($dosen2 -> depan == "Y")
                              {{ $dosen2 -> gelar3 }} {{ $dosen2 -> name }}, {{ $dosen2 -> gelar1 }}, {{ $dosen2 -> gelar2 }}
                          @else
                              {{ $dosen2 -> name }}, {{ $dosen2 -> gelar1 }}, {{ $dosen2 -> gelar2 }}, {{ $dosen2 -> gelar3 }}
                          @endif</span></div>
  <div style="position: absolute; left: 40px; top: 456px;" class="cls_005"><span class="cls_005">Berdasarkan hasil seminar proposal yang telah dipaparkan, maka proposal skripsi ini dinyatakan :</span></div>
  <div style="position: absolute; left: 289px; top: 513px" class="cls_005"><span class="cls_013">{{ $data -> berita_acara }}</span></div>
  <div style="position: absolute; left: 38px; top: 218px; width: 542px;"><span class="cls_005">Pada hari {{ tgl_indo($data->tanggal, true)}} Jam {{ $data -> jam }} WIB di {{ $data -> tempat }} telah dilaksanakan Seminar Proposal Skripsi</span></div>
  
    
  <table style="position: absolute; left: 42px; top: 583px; width: 570px; height: 200px; border-collapse: collapse;"200" border="1">
    <tbody>
      <tr>
        <td style="text-align: center; border-bottom:none;" height="40" width="225"><span class="cls_005">Pembimbing Utama</span></td>
		    <td style="text-align: center; border-bottom:none;" height="40" width="225"><span class="cls_005">Pembimbing Pembantu</span></td>
      </tr>
      <tr>
        <td style="text-align: center; border-bottom:none; border-top:none;" height="120">
          <img src="{{ url('ttd/'.$dosen1->nidn.'/'.$dosen1->ttd) }}" alt="" srcset="" height="90" width="auto">
        </td>
	      <td style="text-align: center; border-bottom:none; border-top:none;" height="120">
          <img src="{{ url('ttd/'.$dosen2->nidn.'/'.$dosen2->ttd) }}" alt="" srcset="" height="90" width="auto">
        </td>
      </tr>
      <tr>
        <td style="text-align: center; border-top:none;"><span class="cls_005"><b>(@if ($dosen1 -> depan == "Y")
                              {{ $dosen1 -> gelar3 }} {{ $dosen1 -> name }}, {{ $dosen1 -> gelar1 }}, {{ $dosen1 -> gelar2 }}
                          @else
                              {{ $dosen1 -> name }}, {{ $dosen1 -> gelar1 }}, {{ $dosen1 -> gelar2 }}, {{ $dosen1 -> gelar3 }}
                          @endif)</b></span></td>
		    <td style="text-align: center; border-top:none;"><span class="cls_005"><b>(@if ($dosen2 -> depan == "Y")
                              {{ $dosen2 -> gelar3 }} {{ $dosen2 -> name }}, {{ $dosen2 -> gelar1 }}, {{ $dosen2 -> gelar2 }}
                          @else
                              {{ $dosen2 -> name }}, {{ $dosen2 -> gelar1 }}, {{ $dosen2 -> gelar2 }}, {{ $dosen2 -> gelar3 }}
                          @endif)</b></span></td>
      </tr>
    </tbody>
  </table>
  </div>

  {{-- Lembar Penilaian --}}
<div style="position:absolute;left:50%;margin-left:-306px;top:1020px;width:612px;height:1008px;overflow:hidden">
  <div style="position: absolute; left: 180px; top: 60px" class="cls_004"><span class="cls_004">PENILAIAN SEMINAR PROPOSAL</span></div>
  <div style="position: absolute; left: 35px; top: 129px" class="cls_005">Nim</div>
  <div style="position: absolute; left: 195px; top: 129px" class="cls_005"><span class="cls_005">: {{ $data->nim }}</span></div>
  <div style="position: absolute; left: 35px; top: 103px" class="cls_005"><span class="cls_005">Nama</span></div>
  <div style="position: absolute; left: 195px; top: 103px" class="cls_005"><span class="cls_005">: {{ $data->nama }}</span></div>
  <div style="position: absolute; left: 35px; top: 156px" class="cls_005"><span class="cls_005">Judul</span></div>
  <div style="position: absolute; left: 195px; top: 156px" class="cls_005"><span class="cls_005">:</span></div>
  <div style="position: absolute; left: 204px; top: 156px" class="cls_005"><span class="cls_005">{{ $data->judul }}</span></div>
  <div style="position: absolute; left: 35px; top: 194px;" class="cls_005"><span class="cls_005">Pembimbing Utama</span></div>
  <div style="position: absolute; left: 195px; top: 194px" class="cls_005"><span class="cls_005">: @if ($dosen1 -> depan == "Y")
                              {{ $dosen1 -> gelar3 }} {{ $dosen1 -> name }}, {{ $dosen1 -> gelar1 }}, {{ $dosen1 -> gelar2 }}
                          @else
                              {{ $dosen1 -> name }}, {{ $dosen1 -> gelar1 }}, {{ $dosen1 -> gelar2 }}, {{ $dosen1 -> gelar3 }}
                          @endif</span></div>
  <table style="position: absolute; left: 36px; top: 215px; width: 543px; height: 38px; border-collapse: collapse;"200" border="1">
    <tbody>
      <tr style="line-height: 17px;">
        <td width="193" style="text-align: center"><span class="cls_004"><b>PENILAIAN</b></td>
        <td width="153" style="text-align: center"><span class="cls_004"><b>PROSENTASE</b></td>
        <td style="text-align: center"><span class="cls_004"><b>NILAI</b></td>
      </tr>
      <tr style="line-height: 17px;">
        <td><span class="cls_005">Sikap</td>
        <td style="text-align: center"><span class="cls_005">20%</td>
        <td style="text-align: center">{{ $data->sikap1 }}</td>
      </tr>
      <tr style="line-height: 17px;">
        <td><span class="cls_005">Presentasi</td>
        <td style="text-align: center"><span class="cls_005">30%</td>
        <td style="text-align: center">{{ $data->presentasi1 }}</td>
      </tr>
      <tr style="line-height: 17px;">
        <td><span class="cls_005">Penguasaan Teori</td>
        <td style="text-align: center"><span class="cls_005">50%</td>
        <td style="text-align: center">{{ $data->penguasaan1 }}</td>
      </tr>
      <tr style="line-height: 17px;">
        <td style="text-align: center" colspan="2"><span class="cls_005">JUMLAH</td>
        <td style="text-align: center">{{ $data->jumlah1 }}</td>
      </tr>
      <tr style="line-height: 17px;">
        <td style="text-align: center" colspan="2"><span class="cls_005">GRADE</td>
        <td style="text-align: center" width="175">{{ $data->grade1 }}</td>
      </tr>
    </tbody>
  </table>
  </div>
	
	{{-- Lembar Penilaian --}}
<div style="position:absolute;left:50%;margin-left:-306px;top:1345px;width:612px;height:1008px;overflow:hidden">
  <div style="position: absolute; left: 180px; top: 60px" class="cls_004"><span class="cls_004">PENILAIAN SEMINAR PROPOSAL</span></div>
  <div style="position: absolute; left: 35px; top: 129px" class="cls_005">Nim</div>
  <div style="position: absolute; left: 195px; top: 129px" class="cls_005"><span class="cls_005">: {{ $data->nim }}</span></div>
  <div style="position: absolute; left: 35px; top: 103px" class="cls_005"><span class="cls_005">Nama</span></div>
  <div style="position: absolute; left: 195px; top: 103px" class="cls_005"><span class="cls_005">: {{ $data->nama }}</span></div>
  <div style="position: absolute; left: 35px; top: 156px" class="cls_005"><span class="cls_005">Judul</span></div>
  <div style="position: absolute; left: 195px; top: 156px" class="cls_005"><span class="cls_005">:</span></div>
  <div style="position: absolute; left: 204px; top: 156px" class="cls_005"><span class="cls_005">{{ $data->judul }}</span></div>
  <div style="position: absolute; left: 35px; top: 190px;" class="cls_005"><span class="cls_005">Pembimbing Pembantu</span></div>
  <div style="position: absolute; left: 195px; top: 190px" class="cls_005"><span class="cls_005">: @if ($dosen2 -> depan == "Y")
                              {{ $dosen2 -> gelar3 }} {{ $dosen2 -> name }}, {{ $dosen2 -> gelar1 }}, {{ $dosen2 -> gelar2 }}
                          @else
                              {{ $dosen2 -> name }}, {{ $dosen2 -> gelar1 }}, {{ $dosen2 -> gelar2 }}, {{ $dosen2 -> gelar3 }}
                          @endif</span></div>
  <table style="position: absolute; left: 36px; top: 215px; width: 543px; height: 38px; border-collapse: collapse;"200" border="1">
    <tbody>
      <tr style="line-height: 17px;">
        <td width="193" style="text-align: center"><span class="cls_004"><b>PENILAIAN</b></td>
        <td width="153" style="text-align: center"><span class="cls_004"><b>PROSENTASE</b></td>
        <td style="text-align: center"><span class="cls_004"><b>NILAI</b></td>
      </tr>
      <tr style="line-height: 17px;">
        <td><span class="cls_005">Sikap</td>
        <td style="text-align: center"><span class="cls_005">20%</td>
        <td style="text-align: center">{{ $data->sikap2 }}</td>
      </tr>
      <tr style="line-height: 17px;">
        <td><span class="cls_005">Presentasi</td>
        <td style="text-align: center"><span class="cls_005">30%</td>
        <td style="text-align: center">{{ $data->presentasi2 }}</td>
      </tr>
      <tr style="line-height: 17px;">
        <td><span class="cls_005">Penguasaan Teori</td>
        <td style="text-align: center"><span class="cls_005">50%</td>
        <td style="text-align: center">{{ $data->penguasaan2 }}</td>
      </tr>
      <tr style="line-height: 17px;">
        <td style="text-align: center" colspan="2"><span class="cls_005">JUMLAH</td>
        <td style="text-align: center">{{ $data->jumlah2 }}</td>
      </tr>
      <tr style="line-height: 17px;">
        <td style="text-align: center" colspan="2"><span class="cls_005">GRADE</td>
        <td style="text-align: center" width="175">{{ $data->grade2 }}</td>
      </tr>
    </tbody>
  </table>
  </div>

{{-- Revisi 1 --}}
<div style="position:absolute;left:50%;margin-left:-306px;top:2060px;width:612px;height:1008px;overflow:hidden">
  <div style="position: absolute; left: 135px; top: 66px" class="cls_004"><span class="cls_004">LEMBAR REVISI SEMINAR PROPOSAL SKRIPSI</span></div>
  <div style="position: absolute; left: 35px; top: 158px" class="cls_005">Nim</div>
  <div style="position: absolute; left: 195px; top: 158px" class="cls_005"><span class="cls_005">: {{ $data->nim }}</span></div>
  <div style="position: absolute; left: 35px; top: 120px" class="cls_005"><span class="cls_005">Nama</span></div>
  <div style="position: absolute; left: 195px; top: 120px" class="cls_005"><span class="cls_005">: {{ $data->nama }}</span></div>
  <div style="position: absolute; left: 35px; top: 198px" class="cls_005"><span class="cls_005">Judul</span></div>
  <div style="position: absolute; left: 195px; top: 198px" class="cls_005"><span class="cls_005">:</span></div>
  <div style="position: absolute; left: 204px; top: 198px" class="cls_005"><span class="cls_005">{{ $data->judul }}</span></div>
 
  <table style="position: absolute; left: 36px; top: 257px; width: 543px; height: 485px; border-collapse: collapse;"200" border="1">
    <tbody>
      <tr>
        <td style="padding-top:6px; padding-left:6px; vertical-align: top; text-align: left;" width="192"><span class="cls_005"><b>PEMBIMBING UTAMA</b></td>
        <td style="padding-top:6px; padding-left:6px; vertical-align: top; text-align: left; width="335">{{ $data->revisi1 }}</td>
      </tr>
    </tbody>
  </table>

  <table style="position: absolute; left: 110px; top: 773px; width: 388px; height: 200px; border-collapse: collapse;"200">
    <tbody>
      <tr>
        <td style="text-align: center" height="30"><span class="cls_005">Kudus, {{ tgl_indo($data->tanggal, false)}}</span></td>
      </tr>
      <tr>
        <td style="text-align: center" height="30"><span class="cls_005">Pembimbing Utama</span></td>
      </tr>
      <tr>
        <td style="text-align: center"  height="100">
          <img src="{{ url('ttd/'.$dosen1->nidn.'/'.$dosen1->ttd) }}" alt="" srcset="" height="100" width="auto">
        </td>
      </tr>
      <tr>
        <td style="text-align: center"><span class="cls_005"><b>(@if ($dosen1 -> depan == "Y")
                              {{ $dosen1 -> gelar3 }} {{ $dosen1 -> name }}, {{ $dosen1 -> gelar1 }}, {{ $dosen1 -> gelar2 }}
                          @else
                              {{ $dosen1 -> name }}, {{ $dosen1 -> gelar1 }}, {{ $dosen1 -> gelar2 }}, {{ $dosen1 -> gelar3 }}
                          @endif)</b></span></td>
      </tr>
    </tbody>
  </table>
  </div>


{{-- Revisi 2 --}}
<div style="position:absolute;left:50%;margin-left:-306px;top:3110px;width:612px;height:1008px;overflow:hidden">
  <div style="position: absolute; left: 135px; top: 66px" class="cls_004"><span class="cls_004">LEMBAR REVISI SEMINAR PROPOSAL SKRIPSI</span></div>
  <div style="position: absolute; left: 35px; top: 158px" class="cls_005">Nim</div>
  <div style="position: absolute; left: 195px; top: 158px" class="cls_005"><span class="cls_005">: {{ $data->nim }}</span></div>
  <div style="position: absolute; left: 35px; top: 120px" class="cls_005"><span class="cls_005">Nama</span></div>
  <div style="position: absolute; left: 195px; top: 120px" class="cls_005"><span class="cls_005">: {{ $data->nama }}</span></div>
  <div style="position: absolute; left: 35px; top: 198px" class="cls_005"><span class="cls_005">Judul</span></div>
  <div style="position: absolute; left: 195px; top: 198px" class="cls_005"><span class="cls_005">:</span></div>
  <div style="position: absolute; left: 204px; top: 198px" class="cls_005"><span class="cls_005">{{ $data->judul }}</span></div>
 
  <table style="position: absolute; left: 36px; top: 257px; width: 543px; height: 485px; border-collapse: collapse;"200" border="1">
    <tbody>
      <tr>
        <td style="padding-top:6px; padding-left:6px; vertical-align: top; text-align: left;" width="192"><span class="cls_005"><b>PEMBIMBING PEMBANTU</b></td>
        <td style="padding-top:6px; padding-left:6px; vertical-align: top; text-align: left; width="335">{{ $data->revisi2 }}</td>
      </tr>
    </tbody>
  </table>

  <table style="position: absolute; left: 110px; top: 773px; width: 388px; height: 200px; border-collapse: collapse;"200">
    <tbody>
      <tr>
        <td style="text-align: center" height="30"><span class="cls_005">Kudus, {{ tgl_indo($data->tanggal, false)}}</span></td>
      </tr>
      <tr>
        <td style="text-align: center" height="30"><span class="cls_005">Pembimbing Pembantu</span></td>
      </tr>
      <tr>
        <td style="text-align: center" height="100">
          <img src="{{ url('ttd/'.$dosen2->nidn.'/'.$dosen2->ttd) }}" alt="" srcset="" height="100" width="auto">
        </td>
      </tr>
      <tr>
        <td style="text-align: center"><span class="cls_005"><b>(@if ($dosen2 -> depan == "Y")
                              {{ $dosen2 -> gelar3 }} {{ $dosen2 -> name }}, {{ $dosen2 -> gelar1 }}, {{ $dosen2 -> gelar2 }}
                          @else
                              {{ $dosen2 -> name }}, {{ $dosen2 -> gelar1 }}, {{ $dosen2 -> gelar2 }}, {{ $dosen2 -> gelar3 }}
                          @endif)</b></span></td>
      </tr>
    </tbody>
  </table>
  </div>

<script>
	window.print()	
</script>
</body>
</html>