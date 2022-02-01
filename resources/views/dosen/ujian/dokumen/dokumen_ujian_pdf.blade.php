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
  <div style="position: absolute; left: 193px; top: 168px; width: 240px;" class="cls_013"><span class="cls_014">BERITA ACARA SIDANG SKRIPSI</span></div>
  <div style="position: absolute; left: 40px; top: 273px" class="cls_005">Nama</div>
  <div style="position: absolute; left: 200px; top: 273px" class="cls_005"><span class="cls_005">: {{ $data->nama }}</span></div>
  <div style="position: absolute; left: 40px; top: 303px" class="cls_005"><span class="cls_005">Nim</span></div>
  <div style="position: absolute; left: 200px; top: 303px" class="cls_005"><span class="cls_005">: {{ $data->nim }}</span></div>
  <div style="position: absolute; left: 40px; top: 333px" class="cls_005"><span class="cls_005">Judul</span></div>
  <div style="position: absolute; left: 200px; top: 333px" class="cls_005"><span class="cls_005">:</span></div>
  <div style="position: absolute; left: 208px; top: 333px" class="cls_005"><span class="cls_005">{{ $data->judul }}</span></div>
  <div style="position: absolute; left: 40px; top: 374px" class="cls_005"><span class="cls_005">Pembimbing Utama</span></div>
  <div style="position: absolute; left: 200px; top: 374px" class="cls_005"><span class="cls_005">: @if ($dosen1 -> depan == "Y")
                              {{ $dosen1 -> gelar3 }} {{ $dosen1 -> name }}, {{ $dosen1 -> gelar1 }}, {{ $dosen1 -> gelar2 }}
                          @else
                              {{ $dosen1 -> name }}, {{ $dosen1 -> gelar1 }}, {{ $dosen1 -> gelar2 }}, {{ $dosen1 -> gelar3 }}
                          @endif</span></div>
  <div style="position: absolute; left: 40px; top: 405px" class="cls_005"><span class="cls_005">Pembimbing Pembantu</span></div>
  <div style="position: absolute; left: 200px; top: 405px" class="cls_005"><span class="cls_005">: @if ($dosen2 -> depan == "Y")
                              {{ $dosen2 -> gelar3 }} {{ $dosen2 -> name }}, {{ $dosen2 -> gelar1 }}, {{ $dosen2 -> gelar2 }}
                          @else
                              {{ $dosen2 -> name }}, {{ $dosen2 -> gelar1 }}, {{ $dosen2 -> gelar2 }}, {{ $dosen2 -> gelar3 }}
                          @endif</span></div>
  <div style="position: absolute; left: 40px; top: 438px" class="cls_005"><span class="cls_005">Ketua Penguji</span></div>
  <div style="position: absolute; left: 200px; top: 438px" class="cls_005"><span class="cls_005">: @if ($ketua -> depan == "Y")
                        {{ $ketua -> gelar3 }} {{ $ketua -> name }}, {{ $ketua -> gelar1 }}, {{ $ketua -> gelar2 }}
                    @else
                        {{ $ketua -> name }}, {{ $ketua -> gelar1 }}, {{ $ketua -> gelar2 }}, {{ $ketua -> gelar3 }}
                    @endif</span></div>
  <div style="position: absolute; left: 40px; top: 471px" class="cls_005"><span class="cls_005">Anggota Penguji 1</span></div>
<div style="position: absolute; left: 200px; top: 471px" class="cls_005"><span class="cls_005">: @if ($anggota1 -> depan == "Y")
                        {{ $anggota1 -> gelar3 }} {{ $anggota1 -> name }}, {{ $anggota1 -> gelar1 }}, {{ $anggota1 -> gelar2 }}
                    @else
                        {{ $anggota1 -> name }}, {{ $anggota1 -> gelar1 }}, {{ $anggota1 -> gelar2 }}, {{ $anggota1 -> gelar3 }}
                    @endif</span></div>
    <div style="position: absolute; left: 40px; top: 504px" class="cls_005"><span class="cls_005">Anggota Penguji 2</span></div>
  <div style="position: absolute; left: 200px; top: 504px" class="cls_005"><span class="cls_005">: @if ($anggota2 -> depan == "Y")
                        {{ $anggota2 -> gelar3 }} {{ $anggota2 -> name }}, {{ $anggota2 -> gelar1 }}, {{ $anggota2 -> gelar2 }}
                    @else
                        {{ $anggota2 -> name }}, {{ $anggota2 -> gelar1 }}, {{ $anggota2 -> gelar2 }}, {{ $anggota2 -> gelar3 }}
                    @endif</span></div>
  <div style="position: absolute; left: 39px; top: 555px;" class="cls_005"><span class="cls_005">Berdasarkan hasil pengujian pada Sidang Skripsi, maka mahasiswa yang bernama <strong>{{ $data->nama }}</strong> nim <strong>{{ $data->nim }} </strong>dinyatakan <strong>{{ $data -> berita_acara }}</strong></span></div>
  <div style="position: absolute; left: 38px; top: 218px; width: 542px;"><span class="cls_005">Pada hari {{ tgl_indo($data->tanggal, true)}} Jam {{ $data -> jam }} WIB di {{ $data -> tempat }} telah dilaksanakan Sidang Skripsi</span></div>
  
    
  <table style="position: absolute; left: 35px; top: 623px; width: 560px; height: 310px; border-collapse: collapse;"200" border="1">
    <tbody>
      <tr>
        <td width="261" height="30" style="border-bottom:none; text-align: center; vertical-align:text-bottom; padding-top:10px">Anggota Penguji 1</td>
        <td width="261" style="border-bottom:none; text-align: center; vertical-align:text-bottom;">Anggota Penguji 2</td>
      </tr>
      <tr>
        <td height="100" style="border-top:none; border-bottom:none; text-align: center; "><img src="{{ url('ttd/'.$anggota1->nidn.'/'.$anggota1->ttd) }}" alt="" srcset="" height="80" width="auto"></td>
        <td style="border-top:none; border-bottom:none; text-align: center; "><img src="{{ url('ttd/'.$anggota2->nidn.'/'.$anggota2->ttd) }}" alt="" srcset="" height="80" width="auto"></td>
      </tr>
      <tr>
        <td height="43" style="border-top:none; text-align: center; ">@if ($anggota1 -> depan == "Y")
                        {{ $anggota1 -> gelar3 }} {{ $anggota1 -> name }}, {{ $anggota1 -> gelar1 }}, {{ $anggota1 -> gelar2 }}
                    @else
                        {{ $anggota1 -> name }}, {{ $anggota1 -> gelar1 }}, {{ $anggota1 -> gelar2 }}, {{ $anggota1 -> gelar3 }}
                    @endif </td>
        <td style="border-top:none; text-align: center; ">@if ($anggota2 -> depan == "Y")
                        {{ $anggota2 -> gelar3 }} {{ $anggota2 -> name }}, {{ $anggota2 -> gelar1 }}, {{ $anggota2 -> gelar2 }}
                    @else
                        {{ $anggota2 -> name }}, {{ $anggota2 -> gelar1 }}, {{ $anggota2 -> gelar2 }}, {{ $anggota2 -> gelar3 }}
                    @endif</td>
      </tr>
      <tr>
        <td height="35" colspan="2" style="border-bottom:none; text-align: center; vertical-align:text-bottom; padding-top:10px">Ketua Penguji</td>
      </tr>
      <tr>
        <td height="100" colspan="2" style="border-top:none; border-bottom:none; text-align: center; "><img src="{{ url('ttd/'.$ketua->nidn.'/'.$ketua->ttd) }}" alt="" srcset="" height="80" width="auto"></td>
      </tr>
      <tr>
        <td colspan="2" style="border-top:none; text-align: center; padding-bottom:15px">@if ($ketua -> depan == "Y")
                        {{ $ketua -> gelar3 }} {{ $ketua -> name }}, {{ $ketua -> gelar1 }}, {{ $ketua -> gelar2 }}
                    @else
                        {{ $ketua -> name }}, {{ $ketua -> gelar1 }}, {{ $ketua -> gelar2 }}, {{ $ketua -> gelar3 }}
                    @endif</td>
      </tr>
    </tbody>
  </table>
  </div>

{{-- Lembar Penilaian --}}
<div style="position:absolute;left:50%;margin-left:-306px;top:1020px;width:612px;height:1008px;overflow:hidden">
  <div style="position: absolute; left: 200px; top: 60px" class="cls_004"><span class="cls_004">PENILAIAN SIDANG SKRIPSI</span></div>
  <div style="position: absolute; left: 35px; top: 129px" class="cls_005">Nim</div>
  <div style="position: absolute; left: 195px; top: 129px" class="cls_005"><span class="cls_005">: {{ $data->nim }}</span></div>
  <div style="position: absolute; left: 35px; top: 103px" class="cls_005"><span class="cls_005">Nama</span></div>
  <div style="position: absolute; left: 195px; top: 103px" class="cls_005"><span class="cls_005">: {{ $data->nama }}</span></div>
  <div style="position: absolute; left: 35px; top: 156px" class="cls_005"><span class="cls_005">Judul</span></div>
  <div style="position: absolute; left: 195px; top: 156px" class="cls_005"><span class="cls_005">:</span></div>
  <div style="position: absolute; left: 204px; top: 156px" class="cls_005"><span class="cls_005">{{ $data->judul }}</span></div>
  <div style="position: absolute; left: 35px; top: 190px;" class="cls_005"><span class="cls_005">Ketua Penguji</span></div>
  <div style="position: absolute; left: 195px; top: 190px" class="cls_005"><span class="cls_005">: @if ($ketua -> depan == "Y")
                        {{ $ketua -> gelar3 }} {{ $ketua -> name }}, {{ $ketua -> gelar1 }}, {{ $ketua -> gelar2 }}
                    @else
                        {{ $ketua -> name }}, {{ $ketua -> gelar1 }}, {{ $ketua -> gelar2 }}, {{ $ketua -> gelar3 }}
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
        <td style="text-align: center"><span class="cls_005">10%</td>
        <td style="text-align: center">{{ $data->sikap1 }}</td>
      </tr>
      <tr style="line-height: 17px;">
        <td><span class="cls_005">Presentasi</td>
        <td style="text-align: center"><span class="cls_005">10%</td>
        <td style="text-align: center">{{ $data->presentasi1 }}</td>
      </tr>
      <tr style="line-height: 17px;">
        <td><span class="cls_005">Penguasaan Teori</td>
        <td style="text-align: center"><span class="cls_005">40%</td>
        <td style="text-align: center">{{ $data->teori1 }}</td>
      </tr>
      <tr style="line-height: 17px;">
        <td><span class="cls_005">Penguasaan Program</td>
        <td style="text-align: center"><span class="cls_005">40%</td>
        <td style="text-align: center">{{ $data->program1 }}</td>
      </tr>
      <tr style="line-height: 17px;">
        <td style="text-align: center" colspan="2"><span class="cls_005">JUMLAH</td>
        <td style="text-align: center">{{ $data->jumlah1 }}</td>
      </tr>
      <tr style="line-height: 17px;">
        <td style="text-align: center" colspan="2"><span class="cls_005">KETERANGAN</td>
        <td style="text-align: center" width="175">{{ $data->keterangan1 }}</td>
      </tr>
    </tbody>
  </table>
  </div>
	
	{{-- Lembar Penilaian --}}
<div style="position:absolute;left:50%;margin-left:-306px;top:1345px;width:612px;height:1008px;overflow:hidden">
  <div style="position: absolute; left: 200px; top: 60px" class="cls_004"><span class="cls_004">PENILAIAN SIDANG SKRIPSI</span></div>
  <div style="position: absolute; left: 35px; top: 129px" class="cls_005">Nim</div>
  <div style="position: absolute; left: 195px; top: 129px" class="cls_005"><span class="cls_005">: {{ $data->nim }}</span></div>
  <div style="position: absolute; left: 35px; top: 103px" class="cls_005"><span class="cls_005">Nama</span></div>
  <div style="position: absolute; left: 195px; top: 103px" class="cls_005"><span class="cls_005">: {{ $data->nama }}</span></div>
  <div style="position: absolute; left: 35px; top: 156px" class="cls_005"><span class="cls_005">Judul</span></div>
  <div style="position: absolute; left: 195px; top: 156px" class="cls_005"><span class="cls_005">:</span></div>
  <div style="position: absolute; left: 204px; top: 156px" class="cls_005"><span class="cls_005">{{ $data->judul }}</span></div>
  <div style="position: absolute; left: 35px; top: 190px;" class="cls_005"><span class="cls_005">Anggota Penguji 1</span></div>
  <div style="position: absolute; left: 195px; top: 190px" class="cls_005"><span class="cls_005">: @if ($anggota1 -> depan == "Y")
                        {{ $anggota1 -> gelar3 }} {{ $anggota1 -> name }}, {{ $anggota1 -> gelar1 }}, {{ $anggota1 -> gelar2 }}
                    @else
                        {{ $anggota1 -> name }}, {{ $anggota1 -> gelar1 }}, {{ $anggota1 -> gelar2 }}, {{ $anggota1 -> gelar3 }}
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
        <td style="text-align: center"><span class="cls_005">10%</td>
        <td style="text-align: center">{{ $data->sikap2 }}</td>
      </tr>
      <tr style="line-height: 17px;">
        <td><span class="cls_005">Presentasi</td>
        <td style="text-align: center"><span class="cls_005">10%</td>
        <td style="text-align: center">{{ $data->presentasi2 }}</td>
      </tr>
      <tr style="line-height: 17px;">
        <td><span class="cls_005">Penguasaan Teori</td>
        <td style="text-align: center"><span class="cls_005">40%</td>
        <td style="text-align: center">{{ $data->teori2 }}</td>
      </tr>
      <tr style="line-height: 17px;">
        <td><span class="cls_005">Penguasaan Program</td>
        <td style="text-align: center"><span class="cls_005">40%</td>
        <td style="text-align: center">{{ $data->program2 }}</td>
      </tr>
      <tr style="line-height: 17px;">
        <td style="text-align: center" colspan="2"><span class="cls_005">JUMLAH</td>
        <td style="text-align: center">{{ $data->jumlah2 }}</td>
      </tr>
      <tr style="line-height: 17px;">
        <td style="text-align: center" colspan="2"><span class="cls_005">KETERANGAN</td>
        <td style="text-align: center" width="175">{{ $data->keterangan2}}</td>
      </tr>
    </tbody>
  </table>
  </div>
												  
{{-- Lembar Penilaian --}}
<div style="position:absolute;left:50%;margin-left:-306px;top:1670px;width:612px;height:1008px;overflow:hidden">
  <div style="position: absolute; left: 200px; top: 60px" class="cls_004"><span class="cls_004">PENILAIAN SIDANG SKRIPSI</span></div>
  <div style="position: absolute; left: 35px; top: 129px" class="cls_005">Nim</div>
  <div style="position: absolute; left: 195px; top: 129px" class="cls_005"><span class="cls_005">: {{ $data->nim }}</span></div>
  <div style="position: absolute; left: 35px; top: 103px" class="cls_005"><span class="cls_005">Nama</span></div>
  <div style="position: absolute; left: 195px; top: 103px" class="cls_005"><span class="cls_005">: {{ $data->nama }}</span></div>
  <div style="position: absolute; left: 35px; top: 156px" class="cls_005"><span class="cls_005">Judul</span></div>
  <div style="position: absolute; left: 195px; top: 156px" class="cls_005"><span class="cls_005">:</span></div>
  <div style="position: absolute; left: 204px; top: 156px" class="cls_005"><span class="cls_005">{{ $data->judul }}</span></div>
  <div style="position: absolute; left: 35px; top: 190px;" class="cls_005"><span class="cls_005">Anggota Penguji 2</span></div>
  <div style="position: absolute; left: 195px; top: 190px" class="cls_005"><span class="cls_005">: @if ($anggota2 -> depan == "Y")
                        {{ $anggota2 -> gelar3 }} {{ $anggota2 -> name }}, {{ $anggota2 -> gelar1 }}, {{ $anggota2 -> gelar2 }}
                    @else
                        {{ $anggota2 -> name }}, {{ $anggota2 -> gelar1 }}, {{ $anggota2 -> gelar2 }}, {{ $anggota2 -> gelar3 }}
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
        <td style="text-align: center"><span class="cls_005">10%</td>
        <td style="text-align: center">{{ $data->sikap3 }}</td>
      </tr>
      <tr style="line-height: 17px;">
        <td><span class="cls_005">Presentasi</td>
        <td style="text-align: center"><span class="cls_005">10%</td>
        <td style="text-align: center">{{ $data->presentasi3 }}</td>
      </tr>
      <tr style="line-height: 17px;">
        <td><span class="cls_005">Penguasaan Teori</td>
        <td style="text-align: center"><span class="cls_005">40%</td>
        <td style="text-align: center">{{ $data->teori3 }}</td>
      </tr>
      <tr style="line-height: 17px;">
        <td><span class="cls_005">Penguasaan Program</td>
        <td style="text-align: center"><span class="cls_005">40%</td>
        <td style="text-align: center">{{ $data->program3 }}</td>
      </tr>
      <tr style="line-height: 17px;">
        <td style="text-align: center" colspan="2"><span class="cls_005">JUMLAH</td>
        <td style="text-align: center">{{ $data->jumlah3 }}</td>
      </tr>
      <tr style="line-height: 17px;">
        <td style="text-align: center" colspan="2"><span class="cls_005">KETERANGAN</td>
        <td style="text-align: center" width="175">{{ $data->keterangan3 }}</td>
      </tr>
    </tbody>
  </table>
  </div>
  
  


{{-- Revisi 1 --}}
<div style="position:absolute;left:50%;margin-left:-306px;top:2060px;width:612px;height:1008px;overflow:hidden">
  <div style="position: absolute; left: 177px; top: 66px" class="cls_004"><span class="cls_004">LEMBAR REVISI SIDANG SKRIPSI</span></div>
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
        <td style="padding-top:6px; padding-left:6px; vertical-align: top; text-align: left;" width="192"><span class="cls_005"><b>KETUA PENGUJI</b></td>
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
        <td style="text-align: center" height="30"><span class="cls_005">Ketua Penguji</span></td>
      </tr>
      <tr>
        <td height="70" style="text-align: center"><img src="{{ url('ttd/'.$ketua->nidn.'/'.$ketua->ttd) }}" alt="" srcset="" height="80" width="auto"></td>
      </tr>
      <tr>
        <td style="text-align: center"><span class="cls_005"><b>(@if ($ketua -> depan == "Y")
                        {{ $ketua -> gelar3 }} {{ $ketua -> name }}, {{ $ketua -> gelar1 }}, {{ $ketua -> gelar2 }}
                    @else
                        {{ $ketua -> name }}, {{ $ketua -> gelar1 }}, {{ $ketua -> gelar2 }}, {{ $ketua -> gelar3 }}
                    @endif)</b></span></td>
      </tr>
    </tbody>
  </table>
  </div>


{{-- Revisi 2 --}}
<div style="position:absolute;left:50%;margin-left:-306px;top:3110px;width:612px;height:1008px;overflow:hidden">
  <div style="position: absolute; left: 177px; top: 66px" class="cls_004"><span class="cls_004">LEMBAR REVISI SIDANG SKRIPSI</span></div>
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
        <td style="padding-top:6px; padding-left:6px; vertical-align: top; text-align: left;" width="192"><span class="cls_005"><b>ANGGOTA PENGUJI 1</b></td>
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
        <td style="text-align: center" height="30"><span class="cls_005">Anggota Penguji 1</span></td>
      </tr>
      <tr>
        <td height="70" style="text-align: center"><img src="{{ url('ttd/'.$anggota1->nidn.'/'.$anggota1->ttd) }}" alt="" srcset="" height="80" width="auto"></td>
      </tr>
      <tr>
        <td style="text-align: center"><span class="cls_005"><b>(@if ($anggota1 -> depan == "Y")
                        {{ $anggota1 -> gelar3 }} {{ $anggota1 -> name }}, {{ $anggota1 -> gelar1 }}, {{ $anggota1 -> gelar2 }}
                    @else
                        {{ $anggota1 -> name }}, {{ $anggota1 -> gelar1 }}, {{ $anggota1 -> gelar2 }}, {{ $anggota1 -> gelar3 }}
                    @endif)</b></span></td>
      </tr>
    </tbody>
  </table>
  </div>

{{-- Revisi 3 --}}
<div style="position:absolute;left:50%;margin-left:-306px;top:4160px;width:612px;height:1008px;overflow:hidden">
  <div style="position: absolute; left: 177px; top: 66px" class="cls_004"><span class="cls_004">LEMBAR REVISI SIDANG SKRIPSI</span></div>
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
        <td style="padding-top:6px; padding-left:6px; vertical-align: top; text-align: left;" width="192"><span class="cls_005"><b>ANGGOTA PENGUJI 2</b></td>
        <td style="padding-top:6px; padding-left:6px; vertical-align: top; text-align: left; width="335">{{ $data->revisi3 }}</td>
      </tr>
    </tbody>
  </table>

  <table style="position: absolute; left: 110px; top: 773px; width: 388px; height: 200px; border-collapse: collapse;"200">
    <tbody>
      <tr>
        <td style="text-align: center" height="30"><span class="cls_005">Kudus, {{ tgl_indo($data->tanggal, false)}}</span></td>
      </tr>
      <tr>
        <td style="text-align: center" height="30"><span class="cls_005">Anggota Penguji 2</span></td>
      </tr>
      <tr>
        <td height="70" style="text-align: center"><img src="{{ url('ttd/'.$anggota2->nidn.'/'.$anggota2->ttd) }}" alt="" srcset="" height="80" width="auto"></td>
      </tr>
      <tr>
        <td style="text-align: center"><span class="cls_005"><b>(@if ($anggota2 -> depan == "Y")
                        {{ $anggota2 -> gelar3 }} {{ $anggota2 -> name }}, {{ $anggota2 -> gelar1 }}, {{ $anggota2 -> gelar2 }}
                    @else
                        {{ $anggota2 -> name }}, {{ $anggota2 -> gelar1 }}, {{ $anggota2 -> gelar2 }}, {{ $anggota2 -> gelar3 }}
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