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

@page { size: A4; margin-top:10mm }

</style>
<script type="text/javascript" src="a79abe0e-65bc-11eb-8b25-0cc47a792c0a_id_a79abe0e-65bc-11eb-8b25-0cc47a792c0a_files/wz_jsgraphics.js"></script>
</head>
<body>


  

{{-- LAMPIRAN --}}
<div style="position:absolute;left:50%;margin-left:-306px;top:0px;width:612px;height:auto">
  <div style="position: absolute; left: 30px; top: 60px" class="cls_004"><span class="cls_003">Daftar Penguji Skripsi Program Studi Teknik Informatika Universitas Muria Kudus Semester  
    @php
      $smt = DB::table('semester')->where('id', $idsmt)->first();
  @endphp
  <?= ucfirst(strtolower($smt->semester))?> {{ $smt->tahun }} :</span></div>
  
  <table style="position: absolute; left: 1px; top: 156px; width: 610px; border-collapse: collapse;"200" border="1"">
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
                    @if ($item -> depan ==null)
                    {{ $item -> name }}, {{ $item -> gelar1 }}, {{ $item -> gelar2 }}
                    @else
                        
                    {{ $item -> name }}, {{ $item -> gelar1 }}, {{ $item -> gelar2 }}, {{ $item -> gelar3 }}
                    @endif
                    @endif
                </span></td>
                <td><span class="cls_005">
                    @php
                        $jumlah1 = DB::table('jadwal_ujian')
                                            ->join('hasil_ujian', 'hasil_ujian.nim', '=', 'jadwal_ujian.nim')
                                            ->select('jadwal_ujian.*')
                                            ->where('jadwal_ujian.ketua_penguji', $item->nidn)
                                            ->where('hasil_ujian.id_semester', $idsmt)
                                            ->where('hasil_ujian.berita_acara', '!=', 'Menunggu hasil')
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
                        $dts = DB::table('jadwal_ujian')
                                            ->join('hasil_ujian', 'hasil_ujian.nim', '=', 'jadwal_ujian.nim')
                                            ->join('mahasiswa', 'jadwal_ujian.nim', '=', 'mahasiswa.nim')
                                            ->select('mahasiswa.*')
                                            ->where('jadwal_ujian.ketua_penguji', $item->nidn)
                                            ->where('hasil_ujian.id_semester', $idsmt)
                                            ->where('hasil_ujian.berita_acara', '!=', 'Menunggu hasil')
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
                        $jumlah2 = DB::table('jadwal_ujian')
                                            ->join('hasil_ujian', 'hasil_ujian.nim', '=', 'jadwal_ujian.nim')
                                            ->select('jadwal_ujian.*')
                                            ->where(function ($query) use ($item){
                                                $query ->where('jadwal_ujian.anggota_penguji_1', $item->nidn)
                                                        ->orWhere('jadwal_ujian.anggota_penguji_2', $item->nidn);
                                            })
                                            ->where('hasil_ujian.id_semester', $idsmt)
                                            ->where('hasil_ujian.berita_acara', '!=', 'Menunggu hasil')
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
                       $dts = DB::table('jadwal_ujian')
                                            ->join('hasil_ujian', 'hasil_ujian.nim', '=', 'jadwal_ujian.nim')
                                            ->join('mahasiswa', 'jadwal_ujian.nim', '=', 'mahasiswa.nim')
                                            ->select('mahasiswa.*')
                                            ->where(function ($query) use ($item){
                                                $query ->where('jadwal_ujian.anggota_penguji_1', $item->nidn)
                                                        ->orWhere('jadwal_ujian.anggota_penguji_2', $item->nidn);
                                            })
                                            ->where('hasil_ujian.id_semester', $idsmt)
                                            ->where('hasil_ujian.berita_acara', '!=', 'Menunggu hasil')
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