<!DOCTYPE html>
<html>
<head><meta http-equiv=Content-Type content="text/html; charset=UTF-8">
<style type="text/css">


span.cls_003{font-family:Times,serif;font-size:14.0px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
div.cls_003{font-family:Times,serif;font-size:14.0px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
span.cls_004{font-family:Times,serif;font-size:22.1px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
div.cls_004{font-family:Times,serif;font-size:22.1px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
span.cls_005{font-family:Times,serif;font-size:14px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
div.cls_005{font-family:Times,serif;font-size:12.1px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
span.cls_013{font-family:Times,serif;font-size:16.1px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: underline}
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
<div style="position:absolute;left:50%;margin-left:-306px;top:0px;width:612px;height:1008px;overflow:hidden">
<div style="position: absolute; left: 77px; top: 70px">
<img src="{{  url('logo.png') }}" width=50 height=50>
</div>
<div style="position: absolute; left: 159px; top: 80px" class="cls_003"><span class="cls_014">Program Studi Teknik Informatika | Fakultas Teknik</span></div>
<div style="position: absolute; left: 236px; top: 103px" class="cls_003"><span class="cls_014">Universitas Muria Kudus</span></div>
<hr class="new4" style="margin-top:145px">
<div style="position: absolute; left: 218px; top: 166px" class="cls_013"><span class="cls_014">UNDANGAN UJIAN SKRIPSI</span></div>

<div style="position: absolute; left: 38px; top: 210px" class="cls_005"><span class="cls_005">Nama</span></div>
<div style="position: absolute; left: 198px; top: 210px" class="cls_005"><span class="cls_005">: {{ $data->nama }}</span></div>
<div style="position: absolute; left: 430px; top: 210px" class="cls_005"><span class="cls_005">Nim</span></div>
<div style="position: absolute; left: 503px; top: 210px" class="cls_005"><span class="cls_005">: {{ $data->nim }}</span></div>
<div style="position: absolute; left: 38px; top: 240px; width: 106px;" class="cls_005"><span class="cls_005">Pembimbing 1-2</span></div>
<div style="position: absolute; left: 198px; top: 240px" class="cls_005"><span class="cls_005">:</span></div>
<div style="position: absolute; left: 206px; top: 240px" class="cls_005"><span class="cls_005">@if ($dosen1 -> depan == "Y")
                              {{ $dosen1 -> gelar3 }} {{ $dosen1 -> name }}, {{ $dosen1 -> gelar1 }}, {{ $dosen1 -> gelar2 }}
                          @else
                          @if ($dosen1->depan==null)
                          {{ $dosen1 -> name }}, {{ $dosen1 -> gelar1 }}, {{ $dosen1 -> gelar2 }}      
                          @else
                              
                          {{ $dosen1 -> name }}, {{ $dosen1 -> gelar1 }}, {{ $dosen1 -> gelar2 }}, {{ $dosen1 -> gelar3 }}
                          @endif
                          @endif - @if ($dosen2==null)
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
                          @endif @endif</span></div>
<div style="position: absolute; left: 38px; top: 279px" class="cls_005"><span class="cls_005">Judul</span></div>
<div style="position: absolute; left: 198px; top: 279px" class="cls_005"><span class="cls_005">:</span></div>
<div style="position: absolute; left: 206px; top: 279px" class="cls_005"><span class="cls_005">{{ $data->judul }}</span></div>
<div style="position: absolute; left: 38px; top: 319px" class="cls_005"><span class="cls_005">Ketua Penguji</span></div>
<div style="position: absolute; left: 198px; top: 319px" class="cls_005"><span class="cls_005">: @if ($ketua -> depan == "Y")
  {{ $ketua -> gelar3 }} {{ $ketua -> name }}, {{ $ketua -> gelar1 }}, {{ $ketua -> gelar2 }}
@else
@if ($ketua->depan==null)
{{ $ketua -> name }}, {{ $ketua -> gelar1 }}, {{ $ketua -> gelar2 }}    
@else
    
{{ $ketua -> name }}, {{ $ketua -> gelar1 }}, {{ $ketua -> gelar2 }}, {{ $ketua -> gelar3 }}
@endif
@endif</span></div>
<div style="position: absolute; left: 38px; top: 349px" class="cls_005"><span class="cls_005">Anggota Penguji 1</span></div>
<div style="position: absolute; left: 198px; top: 349px" class="cls_005"><span class="cls_005">: @if ($anggota1 -> depan == "Y")
  {{ $anggota1 -> gelar3 }} {{ $anggota1 -> name }}, {{ $anggota1 -> gelar1 }}, {{ $anggota1 -> gelar2 }}
@else
@if ($anggota1->depan==null)
{{ $anggota1 -> name }}, {{ $anggota1 -> gelar1 }}, {{ $anggota1 -> gelar2 }}    
@else
    
{{ $anggota1 -> name }}, {{ $anggota1 -> gelar1 }}, {{ $anggota1 -> gelar2 }}, {{ $anggota1 -> gelar3 }}
@endif
@endif</span></div>
<div style="position: absolute; left: 38px; top: 379px;" class="cls_005"><span class="cls_005">Anggota Penguji 2</span></div>
<div style="position: absolute; left: 198px; top: 379px" class="cls_005"><span class="cls_005">: @if ($anggota2 -> depan == "Y")
  {{ $anggota2 -> gelar3 }} {{ $anggota2 -> name }}, {{ $anggota2 -> gelar1 }}, {{ $anggota2 -> gelar2 }}
@else
@if ($anggota2->depan==null)
{{ $anggota2 -> name }}, {{ $anggota2 -> gelar1 }}, {{ $anggota2 -> gelar2 }}    
@else
    
{{ $anggota2 -> name }}, {{ $anggota2 -> gelar1 }}, {{ $anggota2 -> gelar2 }}, {{ $anggota2 -> gelar3 }}
@endif
@endif</span></div>
<div style="position: absolute; left: 38px; top: 409px" class="cls_005"><span class="cls_005">Jadwal Ujian</span></div>
<div style="position: absolute; left: 198px; top: 409px" class="cls_005"><span class="cls_005">: {{ tgl_indo($data->tanggal, true)}}</span></div>
<div style="position: absolute; left: 38px; top: 439px" class="cls_005"><span class="cls_005">Pukul</span></div>
<div style="position: absolute; left: 198px; top: 439px" class="cls_005"><span class="cls_005">: {{ $data -> jam }} WIB</span></div>
<div style="position: absolute; left: 38px; top: 469px" class="cls_005"><span class="cls_005">Tempat</span></div>
<div style="position: absolute; left: 198px; top: 469px" class="cls_005"><span class="cls_005">: {{ $data -> tempat }}</span></div>
	
<table style="position: absolute; left: 0px; top: 47px; height: 480px; border-collapse: collapse;" width="612" height="492" border="1">
  <tbody>
    <tr>
      <td height="450">&nbsp;</td>
    </tr>
  </tbody>
</table>

</div>
	<script>
		window.print()	
	</script>

</body>
</html>