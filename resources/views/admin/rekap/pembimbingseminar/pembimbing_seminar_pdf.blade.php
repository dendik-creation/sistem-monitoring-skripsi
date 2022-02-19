<!DOCTYPE html>
<html>
<head><meta http-equiv=Content-Type content="text/html; charset=UTF-8">
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

</style>
<script type="text/javascript" src="a79abe0e-65bc-11eb-8b25-0cc47a792c0a_id_a79abe0e-65bc-11eb-8b25-0cc47a792c0a_files/wz_jsgraphics.js"></script>
</head>
<body>


  <div style="position:absolute;left:50%;margin-left:-306px;top:0px;width:612px;height:1008px;overflow:hidden">
    <div style="position: absolute; left: 15px; top: 27px">
        <img src="{{  url('logo2.jpg') }}" width=110 height=100>
        </div>
      <div style="position: absolute; left: 253px; top: 33px;" class="cls_003"><span class="cls_003">Program Studi Teknik Informatika</span></div>
      <div style="position: absolute; left: 258px; top: 44px; letter-spacing:0.1em;" class="cls_004"><span class="cls_004"><b>FAKULTAS TEKNIK</b></span></div>
      <div style="position: absolute; left: 212px; top: 77px; letter-spacing:0.1em;" class="cls_005"><span class="cls_004"><b>UNIVERSITAS MURIA KUDUS</b></span></div>
      <div style="position: absolute; left: 133px; top: 90px; width: 475px;" class="cls_005">
          <table cellspacing="0" cellpadding="0" hspace="0" vspace="0" align="center">
            <tr>
              <td style="line-height: 150%" valign="top" align="left"><p align="center">Kampus UMK Gondang Manis PO.BOX 53-Bae, Telp. (0291) 443844 Fax (0291) 4250860 <br>http://www.umk.ac.id- email:teknikinformatika.umk@gmail.com</p></td>
            </tr>
        </table>
      </div>
    <hr class="new4" style="margin-top:145px">
  <div style="position: absolute; left: 25px; top: 168px" class="cls_005">Nomor</div>
  <div style="position: absolute; left: 84px; top: 170px; color:red" class="cls_005">: {{ $nomor }}</div>
  <div style="position: absolute; left: 460px; top: 168px" class="cls_005">Kudus, <?=tgl_indo(date('Y-m-d'), false);?></div>
    <div style="position: absolute; left: 25px; top: 198px" class="cls_005"><span class="cls_005">Lamp</span></div>
    <div style="position: absolute; left: 84px; top: 200px" class="cls_005"><span class="cls_005">: 1 Bendel</span></div>
  <div style="position: absolute; left: 25px; top: 228px" class="cls_005"><span class="cls_005">Hal</span></div>
  <div style="position: absolute; left: 84px; top: 230px" class="cls_005"><span class="cls_005"><b>: Permohonan SK Penguji Seminar Porposal</b></span></div>
  <div style="position: absolute; left: 92px; top: 260px" class="cls_005"><span class="cls_005"><b>
    @php
        $smt = DB::table('semester')->where('id', $idsmt)->first();
    @endphp
    <?= ucfirst(strtolower($smt->semester))?> {{ $smt->tahun }}
  </b></span></div>
    
  <div style="position: absolute; left: 86px; top: 317px;" class="cls_005"><span class="cls_005">Kepada Yth.</span></div>
	<div style="position: absolute; left: 86px; top: 347px; width: 151px;" class="cls_005"><span class="cls_005"><b>Dekan Fakultas Teknik</b></span></div>
  <div style="position: absolute; left: 85px; top: 375px; width: 191px;" class="cls_005"><span class="cls_005"><b>Universitas Muria Kudus</b></span></div>
	
	<div style="position: absolute; left: 86px; top: 430px; line-height: 160%;" class="cls_005"><span class="cls_005">Sehubungan dengan dilaksanakannya Kegiatan Seminar Proposal Periode <?= ucfirst(strtolower($smt->semester))?> {{ $smt->tahun }} di Program Studi Teknik Informatika, bersama surat ini kami mengajukan permohonan agar dapat dibuatkan SK untuk Dosen Penguji Seminar Proposal. Adapun daftar nama dosen dan nama mahasiswa terlampir.</span></div> 
  <div style="position: absolute; left: 86px; top: 525px;" class="cls_005"><span class="cls_005">Demikian permohonan ini kami sampaikan, diucapkan terimakasih.</span></div> 

  <table style="position: absolute; left: 356px; top: 564px; width: 269px; height: 100px; border-collapse: collapse;"200" border="0">
    <tbody>
      <tr>
		    <td style="text-align: left; border-bottom:none;" height="40" width="225"><span class="cls_005">Kaprogdi Teknik Informatika</span></td>
      </tr>
      <tr>
        
	      <td style="text-align: left; border-bottom:none; border-top:none;" height="50">
          {{-- <img src="{{ url('ttd/'.$dosen2->nidn.'/'.$dosen2->ttd) }}" alt="" srcset="" height="90" width="auto"> --}}
        </td>
      </tr>
      <tr>
        
		    <td style="text-align: left; border-top:none;"><span class="cls_005"><b>
        @php
            $ketua = DB::table('dosen')
        ->join('s1', 'dosen.gelar1', '=', 's1.id')
        ->leftJoin('s2', 'dosen.gelar2', '=', 's2.id')
        ->leftJoin('s3', 'dosen.gelar3', '=', 's3.id')
        ->join('bidang', 'dosen.id_bidang', '=', 'bidang.id')
        ->select('dosen.id as id', 'dosen.nidn as nidn', 'dosen.name as name', 's1.gelar as gelar1', 's2.gelar as gelar2', 's3.gelar as gelar3', 's3.depan as depan',
        'dosen.jabatan_fungsional as jabatan', 'bidang.nama_bidang as bidang', 'dosen.email as email')
        ->where('nidn', $kaprodi)
        ->get();
        // dd($ketua);
        @endphp
        @foreach($ketua as $kta)
        @if ($kta->depan == "Y")
            {{ $kta->gelar3 }} {{ $kta->name }}, {{ $kta->gelar1 }}, {{ $kta->gelar2 }}
        @else
            {{ $kta->name }}, {{ $kta->gelar1 }}, {{ $kta->gelar2 }}, {{ $kta->gelar3 }} 
        @endif
      @endforeach
    </b></span></td>
      </tr>
    </tbody>
  </table>
</div>

{{-- LAMPIRAN --}}
<div style="position:absolute;left:50%;margin-left:-306px;top:1020px;width:612px;height:1008px;overflow:hidden">
  <div style="position: absolute; left: 30px; top: 60px" class="cls_004"><span class="cls_003">LAMPIRAN :</span></div>
  
  <table style="position: absolute; left: 1px; top: 110px; width: 610px; border-collapse: collapse;"200" border="1"">
    <thead>
        <tr>
            <th>No.</th>
            <th>Nama Dosen</th>
            <th>Pembimbing Utama</th>
            <th>Pembimbing Pembantu</th>
            <th>Nama Mahasiswa</th>
        </tr>
    </thead>
    <tbody id="datatabel">
        <?php $no=1?>
          @foreach($data as $item)
            <tr>
                <td rowspan="2">{{ $no++ }}.</td>
                <td rowspan="2"><span class="cls_005">
                    @if ($item -> depan == "Y")
                        {{ $item -> gelar3 }} {{ $item -> name }}, {{ $item -> gelar1 }}, {{ $item -> gelar2 }}
                    @else
                        {{ $item -> name }}, {{ $item -> gelar1 }}, {{ $item -> gelar2 }}, {{ $item -> gelar3 }}
                    @endif
                </span></td>
                <td><span class="cls_005">
                    @php
                        $jumlah1 = DB::table('plot_dosbing')
                        ->join('hasil_sempro', 'hasil_sempro.nim', '=', 'plot_dosbing.nim')
                        ->select('plot_dosbing.*')
                        ->where('plot_dosbing.dosbing1', $item->nidn)
                        ->where('hasil_sempro.id_semester', $idsmt)
                        ->where('hasil_sempro.berita_acara', '!=', 'Menunggu hasil')
                        ->count();
    
                        if($jumlah1==0){
                            echo "-";
                        }else{
                            echo $jumlah1;
                        }
                    @endphp
                </span></td>
                <td><span class="cls_005">
                    -
                </span></td>
                <td><span class="cls_014">
                    @php
                        $dts = DB::table('plot_dosbing')
                        ->join('hasil_sempro', 'hasil_sempro.nim', '=', 'plot_dosbing.nim')
                        ->select('plot_dosbing.*')
                        ->where('plot_dosbing.dosbing1', $item->nidn)
                        ->where('hasil_sempro.id_semester', $idsmt)
                        ->where('hasil_sempro.berita_acara', '!=', 'Menunggu hasil')
                        ->get();
                    @endphp
                    @foreach($dts as $dts)
                        {{ $dts->nim }} - {{ $dts->name }} <br>
                    @endforeach
                </span></td>
            </tr>
            <tr>
                <td><span class="cls_005">
                    {{-- @php
                        $jumlah2 = DB::table('plot_dosbing')
                        ->join('hasil_sempro', 'hasil_sempro.nim', '=', 'plot_dosbing.nim')
                        ->select('plot_dosbing.*')
                        ->where('plot_dosbing.dosbing2', $item->nidn)
                        ->where('hasil_sempro.id_semester', $idsmt)
                        ->count();
    
                        if($jumlah2==0){
                            echo "-";
                        }else{
                            echo $jumlah2;
                        }
                    @endphp --}}
                    -
                </span></td>
                <td><span class="cls_005">
                    @php
                        $jumlah2 = DB::table('plot_dosbing')
                        ->join('hasil_sempro', 'hasil_sempro.nim', '=', 'plot_dosbing.nim')
                        ->select('plot_dosbing.*')
                        ->where('plot_dosbing.dosbing2', $item->nidn)
                        ->where('hasil_sempro.id_semester', $idsmt)
                        ->where('hasil_sempro.berita_acara', '!=', 'Menunggu hasil')
                        ->count();
    
                        if($jumlah2==0){
                            echo "-";
                        }else{
                            echo $jumlah2;
                        }
                    @endphp
                </span></td>
                <td><span class="cls_014">
                    @php
                        $dts = DB::table('plot_dosbing')
                        ->join('hasil_sempro', 'hasil_sempro.nim', '=', 'plot_dosbing.nim')
                        ->select('plot_dosbing.*')
                        ->where('plot_dosbing.dosbing2', $item->nidn)
                        ->where('hasil_sempro.id_semester', $idsmt)
                        ->where('hasil_sempro.berita_acara', '!=', 'Menunggu hasil')
                        ->get();
                    @endphp
                    @foreach($dts as $dts)
                        {{ $dts->nim }} - {{ $dts->name }} <br>
                    @endforeach
                </span></td>
            </tr>
       @endforeach
    </tbody>
</table>
  </div>


<script>
	window.print()	
</script>
</body>
</html>