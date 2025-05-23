<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Skripsi TI</title>

     <!-- Custom fonts for this template-->
     <link href="{{ url('sbadmin2/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
     <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
         rel="stylesheet">

     <!-- Custom styles for this template-->
     <link href="{{ url('sbadmin2/css/sb-admin-2.min.css') }}" rel="stylesheet">

     {{-- Datatables --}}
     <link href="{{  url('sbadmin2/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
                <div class="sidebar-brand-icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div class="sidebar-brand-text mx-3">SMS-TI</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item {{ Request::is('dosen') ? 'active' : ''}}">
                <a class="nav-link" href="{{ route('dosen') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <li class="nav-item {{ Request::is('dosen/mahasiswa') || Request::is('dosen/mahasiswa/*') ? 'active' : ''}}">
                <a class="nav-link" href="{{ route('datamhsbimbingan') }}">
                    <i class="fas fa-fw fa-user-circle"></i>
                    <span>Mahasiswa</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <li class="nav-item {{ Request::is('dosen/monitoring/proposal') || Request::is('dosen/monitoring/proposal/*') ? 'active' : ''}}">
                <a class="nav-link" href="{{ route('dataproposalmahasiswa') }}">
                    <i class="fas fa-fw fa-file"></i>
                    <span>Monitoring Proposal</span></a>
            </li>

            <li class="nav-item {{ Request::is('dosen/monitoring/skripsi') || Request::is('dosen/monitoring/skripsi/*') ? 'active' : ''}}">
                <a class="nav-link" href="{{ route('dataskripsimahasiswa') }}">
                    <i class="fas fa-fw fa-book"></i>
                    <span>Monitoring Skripsi</span></a>
            </li>

            <li class="nav-item {{ Request::is('dosen/monitoring/bimbingan') || Request::is('dosen/monitoring/bimbingan/*') ? 'active' : ''}}">
                <a class="nav-link"  href="{{ route('databimbinganmahasiswa') }}">
                    <i class="fas fa-fw fa-pen"></i>
                    <span>Monitoring Bimbingan</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <li class="nav-item {{ Request::is('dosen/sempro') || Request::is('dosen/sempro/*') ? 'active' : ''}}">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-file"></i>
                    <span>Seminar Proposal</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="{{ route('datajadwalsemprodosen') }}">Jadwal Seminar</a>
                        <a class="collapse-item" href="{{ route('datanilaisempro') }}">Nilai Seminar</a>
                        <a class="collapse-item" href="{{ route('datahasilsemprodosen') }}">Hasil Akhir Seminar</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item -->
            <li class="nav-item {{ Request::is('dosen/skripsi') || Request::is('dosen/skripsi/*') ? 'active' : ''}}">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-book"></i>
                    <span>Ujian Skripsi</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="{{  route('datajadwalujiandosen') }}">Jadwal Ujian</a>
                        <a class="collapse-item" href="{{ route('datanilaiujian') }}">Nilai Ujian</a>
                        <a class="collapse-item" href="{{  route('datahasilujiandosen') }}">Hasil Akhir Ujian</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>



        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <span class="ml-2 font-weight-bold text-uppercase">Sistem Monitoring Skripsi</span>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ $user -> name }}</span>
                                <img class="img-profile rounded-circle"
                                    src="{{ url('photo/'.$user->photo) }}">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="{{ route('formeditprofildosen') }}">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profil
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="/logout" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                @yield('content')
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Sistem Monitoring Skripsi TI UMK</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Yakin ingin keluar?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Pilih tombol "Logout" untuk mengakhiri sesi.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                    <a class="btn btn-primary" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                </div>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </div>


</body>

<!-- Bootstrap core JavaScript-->
<script src="{{ url('sbadmin2/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ url('sbadmin2/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- Core plugin JavaScript-->
<script src="{{ url('sbadmin2/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

<!-- Custom scripts for all pages-->
<script src="{{ url('sbadmin2/js/sb-admin-2.min.js') }}"></script>

<!-- Page level plugins -->
<script src="{{ url('sbadmin2/vendor/chart.js/Chart.min.js') }}"></script>

<!-- Page level custom scripts -->
<script src="{{ url('sbadmin2/js/demo/chart-area-demo.js') }}"></script>
<script src="{{ url('sbadmin2/js/demo/chart-pie-demo.js') }}"></script>

{{-- Datatables --}}
<script src="{{  url('sbadmin2/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{  url('sbadmin2/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
        'paging'      : true,
        'searching'   : true,
        'ordering'    : true,
        'autoWidth'   : true
        });
    });

    $(document).ready(function() {
        $('#dataTable2').DataTable({
        'paging'      : true,
        'searching'   : true,
        'ordering'    : true,
        'autoWidth'   : true
        });
    });

    $(document).ready(function(){
        $('#filterdosen').on('change', function(e){
            var id = e.target.value;
            $.get('{{ url('dosen/monitoring/proposal') }}/'+id, function(data){
                // console.log(id);
                // console.log(data);
                $('#datatabel').empty();
                $.each(data, function(index, element){
                    var myIndex = index+1;
                    var dosen = {!! json_encode($user->no_induk) !!};
                    // console.log(dosen);

                    // if(element.dosbing1 ==  dosen){
                    //     var komentar = `<td>${element.komentar1}</td>`
                    // }else{
                    //     var komentar = `<td>${element.komentar2}</td>`
                    // }

                    if(element.dosbing1 ==  dosen){
                        if(element.ket1 == 'Disetujui'){
                            var ket = `<td><p style="pointer-events: none;" class="btn btn-sm btn-success">${element.ket1}</td>`
                        }else if(element.ket1 == 'Ditolak'){
                            var ket = `<td><p style="pointer-events: none;" class="btn btn-sm btn-danger">${element.ket1}</td>`
                        }else if(element.ket1 == 'Menunggu ACC'){
                            var ket = `<td><p style="pointer-events: none;" class="btn btn-sm btn-secondary">${element.ket1}</td>`
                        }else{
                            var ket = `<td><p style="pointer-events: none;" class="btn btn-sm btn-warning">${element.ket1}</td>`
                        }
                    }else{
                        if(element.ket2 == 'Disetujui'){
                            var ket = `<td><p style="pointer-events: none;" class="btn btn-sm btn-success">${element.ket2}</td>`
                        }else if(element.ket2 == 'Ditolak'){
                            var ket = `<td><p style="pointer-events: none;" class="btn btn-sm btn-danger">${element.ket2}</td>`
                        }else if(element.ket2 == 'Menunggu ACC'){
                            var ket = `<td><p style="pointer-events: none;" class="btn btn-sm btn-secondary">${element.ket2}</td>`
                        }else{
                            var ket = `<td><p style="pointer-events: none;" class="btn btn-sm btn-warning">${element.ket2}</td>`
                        }
                    }

                    // if(element.ket1 != 'Menunggu ACC' || element.ket2 != 'Menunggu ACC'){
                    //     var disabled = `disabled`
                    // }

                    if(element.dosbing1 ==  dosen && element.ket1 != 'Menunggu ACC'){
                        var disabled = `disabled`
                    }else if(element.dosbing2 ==  dosen && element.ket2 != 'Menunggu ACC'){
                        var disabled = `disabled`
                    }

                    $('#datatabel').append(`
                        <tr>
                            <td>${myIndex}</td>
                            <td>${element.semester} ${element.tahun}</td>
                            <td>${element.nim}</td>
                            <td>${element.nama}</td>
                            <td>${element.judul}</td>
                            ${ket}
                            <td>
                                <a href="/dosen/monitoring/proposal/detail/${element.id}" class="btn btn-sm btn-primary">Lihat detail</a>
                            </td>
                        </tr>
                        `)

                });
            });
        });
    });

    $(document).ready(function(){
        $('#filterdosen2').on('change', function(e){
            var id = e.target.value;
            $.get('{{ url('dosen/monitoring/skripsi') }}/'+id, function(data){
                // console.log(id);
                // console.log(data);
                $('#datatabel').empty();
                $.each(data, function(index, element){
                    var myIndex = index+1;
                    var dosen = {!! json_encode($user->no_induk) !!};



                    if(element.status_skripsi == 'Sedang Dikerjakan'){
                        var skripsi = `<td><p style="pointer-events: none;" class="btn btn-sm btn-warning">${element.status_skripsi}</td>`
                    }else{
                        var skripsi = `<td><p style="pointer-events: none;" class="btn btn-sm btn-success">${element.status_skripsi}</td>`
                    }

                    if(element.status_ujian == 'Belum Ujian'){
                        var ujian = `<td><p style="pointer-events: none;" class="btn btn-sm btn-warning">${element.status_ujian}</td>`
                    }else if(element.status_ujian == 'Lulus'){
                        var ujian = `<td><p style="pointer-events: none;" class="btn btn-sm btn-success">${element.status_ujian}</td>`
                    }else{
                        var ujian = `<td><p style="pointer-events: none;" class="btn btn-sm btn-danger">${element.status_ujian}</td>`
                    }


                    $('#datatabel').append(`
                        <tr>
                            <td>${myIndex}</td>
                            <td>${element.semester} ${element.tahun}</td>
                            <td>${element.nim}</td>
                            <td>${element.nama}</td>
                            <td>${element.judul}</td>
                            ${skripsi}
                            ${ujian}
                        </tr>
                        `)

                });
            });
        });
    });

    $(document).ready(function(){
        $('#filterbimbingan').on('change', function(e){
            var id = e.target.value;
            $.get('{{ url('dosen/monitoring/bimbingan') }}/'+id, function(data){
                console.log(id);
                console.log(data);
                $('#datatabel').empty();
                $.each(data, function(index, element){
                    var myIndex = index+1;
                    var dosen = {!! json_encode($user->no_induk) !!};

                    if(element.depan1 ==  "Y"){
                        if(element.gelar31 == null){
                        var bimbingan_kepada = `${element.dosen}, ${element.gelar11}, ${element.gelar21}`
                        }else{
                            var bimbingan_kepada = `${element.gelar31} ${element.dosen}, ${element.gelar11}, ${element.gelar21}`
                        }
                    }else{
                        if(element.gelar31 == null){
                            var bimbingan_kepada = `${element.dosen}, ${element.gelar11}, ${element.gelar21}`
                        }else{
                        var bimbingan_kepada = `${element.dosen}, ${element.gelar11}, ${element.gelar21}, ${element.gelar31}`
                        }
                    }


                    if(element.bimbingan_kepada == dosen && element.dosbing1 == dosen){
                        if(element.ket1 == 'Ok'  || element.ket1 == 'Siap ujian'){
                            var status = `<p style="pointer-events: none;" class="btn btn-sm btn-success">${element.ket1}`
                        }else if(element.ket1 == 'Review' || element.ket1 == 'Lanjut ke bimbingan selanjutnya'){
                            var status = `<p style="pointer-events: none;" class="btn btn-sm btn-warning">${element.ket1}`
                        }
                    }else if(element.bimbingan_kepada != dosen && element.dosbing1 == dosen){
                        if(element.ket2 == 'Ok'  || element.ket2 == 'Siap ujian'){
                            var status = `<p style="pointer-events: none;" class="btn btn-sm btn-success">${element.ket2}`
                        }else if(element.ket2 == 'Review' || element.ket2 == 'Lanjut ke bimbingan selanjutnya'){
                            var status = `<p style="pointer-events: none;" class="btn btn-sm btn-warning">${element.ket2}`
                        }
                    }else if(element.bimbingan_kepada == dosen && element.dosbing2 == dosen){
                        if(element.ket2 == 'Ok'  || element.ket2 == 'Siap ujian'){
                            var status = `<p style="pointer-events: none;" class="btn btn-sm btn-success">${element.ket2}`
                        }else if(element.ket2 == 'Review' || element.ket2 == 'Lanjut ke bimbingan selanjutnya'){
                            var status = `<p style="pointer-events: none;" class="btn btn-sm btn-warning">${element.ket2}`
                        }
                    }else if(element.bimbingan_kepada != dosen && element.dosbing2 == dosen){
                        if(element.ket1 == 'Ok'  || element.ket1 == 'Siap ujian'){
                            var status = `<p style="pointer-events: none;" class="btn btn-sm btn-success">${element.ket1}`
                        }else if(element.ket1 == 'Review' || element.ket1 == 'Lanjut ke bimbingan selanjutnya'){
                            var status = `<p style="pointer-events: none;" class="btn btn-sm btn-warning">${element.ket1}`
                        }
                    }



                    $('#datatabel').append(`
                        <tr>
                            <td>${myIndex}</td>
                            <td>${element.semester} ${element.tahun}</td>
                            <td>${element.nim}</td>
                            <td>${element.nama}</td>
                            <td>${element.judul}</td>
                            <td>${element.bimbingan_ke}</td>
                            <td>${bimbingan_kepada}</td>
                            <td>${status}</td>
                            <td>
                                <a href="/dosen/monitoring/bimbingan/detail/${element.nim}/${element.id}" class="btn btn-sm btn-primary">Lihat detail</a>
                            </td>
                        </tr>
                        `)

                });
            });
        });
    });

    $(document).ready(function(){
        $('#filtermahasiswa').on('change', function(e){
            var id = e.target.value;
            $.get('{{ url('dosen/mahasiswa') }}/'+id, function(data){
                console.log(id);
                console.log(data);
                $('#datatabel').empty();
                $.each(data, function(index, element){
                    var myIndex = index+1;
                    var dosen = {!! json_encode($user->no_induk) !!};

                    // console.log(dosen);

                    if(element.status_proposal == 'Belum mengajukan proposal'){
                        var status_proposal = `<td class="text-danger"><strong>${element.status_proposal}</td>`
                    }else{
                        var status_proposal = `<td class="text-success"><strong>${element.status_proposal}</td>`
                    }

                    if(element.status_sempro == 'Belum seminar proposal'){
                        var status_sempro = `<td class="text-danger"><strong>${element.status_sempro}</td>`
                    }else{
                        var status_sempro = `<td class="text-success"><strong>${element.status_sempro}</td>`
                    }

                    if(element.status_bimbingan == 'Belum melakukan bimbingan'){
                        var status_bimbingan = `<td class="text-danger"><strong>${element.status_bimbingan}</td>`
                    }else{
                        var status_bimbingan = `<td class="text-success"><strong>${element.status_bimbingan}</td>`
                    }

                    if(element.status_skripsi == 'Belum mengerjakan'){
                        var status_skripsi = `<td class="text-danger"><strong>${element.status_skripsi}</td>`
                    }else if(element.status_skripsi == 'Sedang dikerjakan'){
                        var status_skripsi = `<td class="text-warning"><strong>${element.status_skripsi}</td>`
                    }else{
                        var status_skripsi = `<td class="text-success"><strong>${element.status_skripsi}</td>`
                    }

                    if(element.status_ujian == 'Lulus'){
                        var status_ujian = `<td class="text-success"><strong>${element.status_ujian}</td>`
                    }else{
                        var status_ujian = `<td class="text-danger"><strong>${element.status_ujian}</td>`
                    }

                    $('#datatabel').append(`
                        <tr>
                            <td>${myIndex}</td>
                            <td>${element.smt}</td>
                            <td>${element.nim}</td>
                            <td>${element.name}</td>
                            ${status_proposal}
                            ${status_sempro}
                            ${status_bimbingan}
                            ${status_skripsi}
                            ${status_ujian}
                            <td>
                                <a href="/dosen/mahasiswa/detail/${element.nim}" class="btn btn-sm btn-primary">Lihat detail</a>
                            </td>
                        </tr>
                        `)

                });
            });
        });
    });

    $(document).ready(function(){
        $('#filtersemesterhasilsempro').on('change', function(e){
            var id = e.target.value;
            $.get('{{ url('dosen/sempro/hasil/filter') }}/'+id, function(data){
                console.log(id);
                console.log(data);
                $('#datatabel').empty();
                $.each(data, function(index, element){
                    var myIndex = index+1;
                    // var dosen = {!! json_encode($user->no_induk) !!};

                    if(element.berita_acara ==  "Ditolak"){
                        var status = `<p style="pointer-events: none;" class="btn btn-sm btn-danger">Ditolak`
                    }else if(element.berita_acara ==  "Diterima"){
                        var status = `<p style="pointer-events: none;" class="btn btn-sm btn-success">Diterima`
                    }

                    $('#datatabel').append(`
                        <tr>
                            <td>${myIndex}</td>
                            <td>${element.semester} ${element.tahun}</td>
                            <td>${element.nim}</td>
                            <td>${element.nama}</td>
                            <td>${element.judul}</td>
                            <td>${status}</td>
                            <td>${element.nilai_akhir}</td>
                            <td>${element.grade_akhir}</td>
                            <td><a href="/sempro/hasil/cetak/${element.id}" target="_blank" class="btn btn-primary btn-sm">Cetak Dokumen</a></td>
                        </tr>
                        `)

                });
            });
        });
    });

    $(document).ready(function(){
        $('#filtersemesterhasilujian').on('change', function(e){
            var id = e.target.value;
            $.get('{{ url('dosen/skripsi/hasil/filter') }}/'+id, function(data){
                console.log(id);
                console.log(data);
                $('#datatabel').empty();
                $.each(data, function(index, element){
                    var myIndex = index+1;
                    // var dosen = {!! json_encode($user->no_induk) !!};

                    if(element.berita_acara ==  "Tidak Lulus"){
                        var status = `<p style="pointer-events: none;" class="btn btn-sm btn-danger">Tidak Lulus`
                    }else if(element.berita_acara ==  "Lulus"){
                        var status = `<p style="pointer-events: none;" class="btn btn-sm btn-success">Lulus`
                    }

                    $('#datatabel').append(`
                        <tr>
                            <td>${myIndex}</td>
                            <td>${element.semester} ${element.tahun}</td>
                            <td>${element.nim}</td>
                            <td>${element.nama}</td>
                            <td>${element.judul}</td>
                            <td>${status}</td>
                            <td>${element.nilai_akhir}</td>
                            <td>${element.grade_akhir}</td>
                            <td><a href="/ujian/hasil/cetak/${element.id}" target="_blank" class="btn btn-primary btn-sm">Cetak Dokumen</a></td>
                        </tr>
                        `)

                });
            });
        });
    });


    //sempro dosen 1 2
    function sempro1() {
		var semprosikap1 = document.getElementById('semprosikap1').value * 20 / 100;
		var sempropresentasi1 = document.getElementById('sempropresentasi1').value * 30 / 100;
		var sempropenguasaan1 = document.getElementById('sempropenguasaan1').value * 50 / 100;

		var semprojumlah1 = semprosikap1 + sempropresentasi1 + sempropenguasaan1;

		document.getElementById('semprojumlah1').value = semprojumlah1;
	}

    function sempro2() {
		var semprosikap2 = document.getElementById('semprosikap2').value * 20 / 100;
		var sempropresentasi2 = document.getElementById('sempropresentasi2').value * 30 / 100;
		var sempropenguasaan2 = document.getElementById('sempropenguasaan2').value * 50 / 100;

		var semprojumlah2 = parseInt(semprosikap2) + parseInt(sempropresentasi2) + parseInt(sempropenguasaan2);

		document.getElementById('semprojumlah2').value = semprojumlah2;
	}

    function ujian1() {
		var ujiansikap1 = document.getElementById('ujiansikap1').value * 10 / 100;
		var ujianpresentasi1 = document.getElementById('ujianpresentasi1').value * 10 / 100;
        var ujianteori1 = document.getElementById('ujianteori1').value * 40 / 100;
		var ujianprogram1 = document.getElementById('ujianprogram1').value * 40 / 100;

		var ujianjumlah1 = parseInt(ujiansikap1) + parseInt(ujianpresentasi1) + parseInt(ujianteori1) + parseInt(ujianprogram1);

		document.getElementById('ujianjumlah1').value = ujianjumlah1;
	}

    function ujian2() {
		var ujiansikap2 = document.getElementById('ujiansikap2').value * 10 / 100;
		var ujianpresentasi2 = document.getElementById('ujianpresentasi2').value * 10 / 100;
        var ujianteori2 = document.getElementById('ujianteori2').value * 40 / 100;
		var ujianprogram2 = document.getElementById('ujianprogram2').value * 40 / 100;

		var ujianjumlah2 = parseInt(ujiansikap2) + parseInt(ujianpresentasi2) + parseInt(ujianteori2) + parseInt(ujianprogram2);

		document.getElementById('ujianjumlah2').value = ujianjumlah2;
	}

    function ujian3() {
		var ujiansikap3 = document.getElementById('ujiansikap3').value * 10 / 100;
		var ujianpresentasi3 = document.getElementById('ujianpresentasi3').value * 10 / 100;
        var ujianteori3 = document.getElementById('ujianteori3').value * 40 / 100;
		var ujianprogram3 = document.getElementById('ujianprogram3').value * 40 / 100;

		var ujianjumlah3 = parseInt(ujiansikap3) + parseInt(ujianpresentasi3) + parseInt(ujianteori3) + parseInt(ujianprogram3);

		document.getElementById('ujianjumlah3').value = ujianjumlah3;
	}

    function ujian4() {
		var ujiansikap4 = document.getElementById('ujiansikap4').value * 10 / 100;
		var ujianpresentasi4 = document.getElementById('ujianpresentasi4').value * 10 / 100;
        var ujianteori4 = document.getElementById('ujianteori4').value * 40 / 100;
		var ujianprogram4 = document.getElementById('ujianprogram4').value * 40 / 100;

		var ujianjumlah4 = parseInt(ujiansikap4) + parseInt(ujianpresentasi4) + parseInt(ujianteori4) + parseInt(ujianprogram4);

		document.getElementById('ujianjumlah4').value = ujianjumlah4;
	}


</script>
{{-- <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
 --}}

 <script src="{{ asset('tinymce/tinymce.min.js') }}"></script>

{{-- <script>
    tinymce.init({
        selector:'textarea.deskripsi',
        width: 900,
        height: 300
    });
</script> --}}

<script>
    tinymce.init({
        selector: 'textarea.deskripsi',
        menubar: false,
        plugins: 'lists link image preview',
        toolbar: 'undo redo | bold italic underline | alignleft aligncenter alignright | bullist numlist outdent indent | removeformat',
        height: 300
    });
</script>


</html>
