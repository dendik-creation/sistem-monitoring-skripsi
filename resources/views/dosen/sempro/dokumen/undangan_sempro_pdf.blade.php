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
<div style="position: absolute; left: 163px; top: 166px" class="cls_013"><span class="cls_014">UNDANGAN SEMINAR PROPOSAL SKRIPSI</span></div>

<div style="position: absolute; left: 38px; top: 210px" class="cls_005"><span class="cls_005">Nim</span></div>
<div style="position: absolute; left: 198px; top: 210px" class="cls_005"><span class="cls_005">: {{ $data->nim }}</span></div>
<div style="position: absolute; left: 38px; top: 240px" class="cls_005"><span class="cls_005">Nama</span></div>
<div style="position: absolute; left: 198px; top: 240px" class="cls_005"><span class="cls_005">: {{ $data->nama }}</span></div>
<div style="position: absolute; left: 38px; top: 270px" class="cls_005"><span class="cls_005">Judul</span></div>
<div style="position: absolute; left: 198px; top: 270px" class="cls_005"><span class="cls_005">:</span></div>
<div style="position: absolute; left: 206px; top: 270px" class="cls_005"><span class="cls_005">{{ $data->judul}}</span></div>
<div style="position: absolute; left: 38px; top: 310px" class="cls_005"><span class="cls_005">Pembimbing Utama</span></div>
<div style="position: absolute; left: 198px; top: 310px" class="cls_005"><span class="cls_005">: {{ $dosen1->gelar3 }} {{ $dosen1->name }}, {{ $dosen1->gelar1 }}, {{ $dosen1->gelar2 }}</span></div>
<div style="position: absolute; left: 38px; top: 340px" class="cls_005"><span class="cls_005">Pembimbing Pembantu</span></div>
<div style="position: absolute; left: 198px; top: 340px" class="cls_005"><span class="cls_005">: {{ $dosen2->gelar3 }} {{ $dosen2->name }}, {{ $dosen2->gelar1 }}, {{ $dosen2->gelar2 }}</span></div>
<div style="position: absolute; left: 38px; top: 370px" class="cls_005"><span class="cls_005">Jadwal Seminar</span></div>
<div style="position: absolute; left: 198px; top: 370px" class="cls_005"><span class="cls_005">: {{ tgl_indo($data->tanggal, true)}}</span></div>
<div style="position: absolute; left: 38px; top: 400px" class="cls_005"><span class="cls_005">Pukul / Tempat</span></div>
<div style="position: absolute; left: 198px; top: 400px" class="cls_005"><span class="cls_005">: {{ $data -> jam }} WIB / {{ $data -> tempat }}</span></div>
	
<table style="position: absolute; left: 0px; top: 47px; height: 400px;  border-collapse: collapse;" width="612" height="149" border="1">
  <tbody>
    <tr>
      <td height="143">&nbsp;</td>
    </tr>
  </tbody>
</table>

</div>
	<script>
		window.print()	
	</script>

</body>
</html>