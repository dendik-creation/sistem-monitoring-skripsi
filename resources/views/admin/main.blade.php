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

    {{-- Date Picker --}}
    <link href="{{  url('sbadmin2/vendor/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">

    {{-- Time Picker --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">

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
            <li class="nav-item {{ Request::is('admin') ? 'active' : ''}}">
                <a class="nav-link" href="/admin">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <li class="nav-item {{  Request::is('admin/semester') ? 'active' : ''}}">
                <a class="nav-link" href="{{ route('datasemester') }}">
                    <i class="fas fa-fw fa-graduation-cap"></i>
                    <span>Semester</span></a>
            </li>

            <li class="nav-item {{ Request::is('admin/dosen') || Request::is('admin/dosen/*') ? 'active' : ''}}">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOne"
                    aria-expanded="true" aria-controls="collapseOne">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Dosen</span>
                </a>
                <div id="collapseOne" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="{{ route('datadosen') }}">Data Dosen</a>
                        <a class="collapse-item" href="{{ route('datas1') }}">Gelar S1</a>
                        <a class="collapse-item" href="{{ route('datas2') }}">Gelar S2</a>
                        <a class="collapse-item" href="{{ route('datas3') }}">Gelar S3</a>
                        <a class="collapse-item" href="{{ route('databidang') }}">Data Bidang</a>
                    </div>
                </div>
            </li>

            <li class="nav-item {{ Request::is('admin/mahasiswa') ||  Request::is('admin/mahasiswa/*') ? 'active' : ''}}">
                <a class="nav-link" href="{{ route('datamahasiswa') }}">
                    <i class="fas fa-fw fa-user-circle"></i>
                    <span>Mahasiswa</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <li class="nav-item {{ Request::is('admin/proposal/*') ? 'active' : ''}}">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-file"></i>
                    <span>Proposal</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="{{ route('dataproposalplotting') }}">Plot Dosen Pembimbing</a>
                        <a class="collapse-item" href="{{ route('dataproposalmonitoring') }}">Monitoring</a>
                        <a class="collapse-item" href="{{ route('dataproposalpendaftar') }}">Pendaftar Seminar</a>
                        <a class="collapse-item" href="{{ route('dataproposalpenjadwalan') }}">Jadwal Seminar</a>
                        <a class="collapse-item" href="{{ route('datahasilsemproadmin') }}">Hasil Seminar</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item -->
            <li class="nav-item {{ Request::is('admin/skripsi/*') ? 'active' : ''}}">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-book"></i>
                    <span>Skripsi</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="{{ route('datapengujiplotting') }}">Plot Dosen Penguji</a>
                        <a class="collapse-item" href="{{ route('dataskripsimonitoring') }}">Monitoring</a>
                        <a class="collapse-item" href="{{ route('dataskripsipendaftar') }}">Pendaftar Ujian</a>
                        <a class="collapse-item" href="{{ route('dataskripsipenjadwalan') }}">Jadwal Ujian</a>
                        <a class="collapse-item" href="{{ route('datahasilujianadmin') }}">Hasil Ujian</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <li class="nav-item {{ Request::is('admin/rekap') || Request::is('admin/rekap/*') ? 'active' : ''}}">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseThree"
                    aria-expanded="true" aria-controls="collapseThree">
                    <i class="fas fa-fw fa-print"></i>
                    <span>Rekap</span>
                </a>
                <div id="collapseThree" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="{{ route('datapembimbingseminar') }}">Pembimbing Seminar</a>
                        <a class="collapse-item" href="{{ route('datapembimbingskripsi') }}">Pembimbing Skripsi</a>
                        <a class="collapse-item" href="{{ route('datapengujiskripsi') }}">Penguji Skripsi</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <li class="nav-item {{ Request::is('admin/pengumuman') || Request::is('admin/pengumuman/*') ? 'active' : ''}}">
                <a class="nav-link" href="{{ route('datapengumuman') }}">
                    <i class="fas fa-fw fa-bullhorn"></i>
                    <span>Pengumuman</span></a>
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
                                    src="{{ url('sbadmin2/img/undraw_profile.svg') }}">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                {{-- <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profil
                                </a> --}}
                                {{-- <div class="dropdown-divider"></div> --}}
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

{{-- Date Picker --}}
<script src="{{  url('sbadmin2/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

{{-- Time Picker --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js"></script>

<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
        'paging'      : true,
        'searching'   : true,
        'ordering'    : true,
        'autoWidth'   : true
        });
    });

    $('#datepicker').datepicker({
      autoclose: true,
      format: 'yyyy-mm-dd',
      todayHighlight: true,
    });


    $(document).ready(function(){
        $('#filterjadwal').on('change', function(e){
            var id = e.target.value;
            $.get('{{ url('admin/proposal/penjadwalan') }}/'+id, function(data){
                console.log(id);
                console.log(data);
                $('#datatabel').empty();
                $.each(data, function(index, element){
                    var myIndex = index+1;
                    // var dosen = {!! json_encode($user->no_induk) !!};

                    if(element.status ==  "Berkas OK"){
                        var status = `<p style="pointer-events: none;" class="btn btn-sm btn-warning">Belum dijadwalkan`
                    }else if(element.status ==  "Terjadwal"){
                        var status = `<p style="pointer-events: none;" class="btn btn-sm btn-success">Sudah dijadwalkan`
                    }

                    if(element.status ==  "Berkas OK"){
                        var opsi = `<a href="/admin/proposal/pendaftar/detail/${element.id}" class="btn btn-sm btn-primary">Jadwalkan manual`
                    }else if(element.status ==  "Terjadwal"){
                        var opsi = `<a href="/admin/proposal/penjadwalan/detail/${element.id}" class="btn btn-sm btn-primary">Lihat detail`
                    }

                    $('#datatabel').append(`
                        <tr>
                            <td>${myIndex}</td>
                            <td>${element.semester} ${element.tahun}</td>
                            <td>${element.nim}</td>
                            <td>${element.nama}</td>
                            <td>${element.judul}</td>
                            <td>${status}</td>
                            <td>${opsi}</td>
                        </tr>
                        `)

                });
            });
        });
    });

    $(document).ready(function(){
        $('#filterjadwalujian').on('change', function(e){
            var id = e.target.value;
            $.get('{{ url('admin/skripsi/penjadwalan') }}/'+id, function(data){
                console.log(id);
                console.log(data);
                $('#datatabel').empty();
                $.each(data, function(index, element){
                    var myIndex = index+1;
                    // var dosen = {!! json_encode($user->no_induk) !!};

                    if(element.status ==  "Berkas OK"){
                        var status = `<p style="pointer-events: none;" class="btn btn-sm btn-warning">Belum dijadwalkan`
                    }else if(element.status ==  "Terjadwal"){
                        var status = `<p style="pointer-events: none;" class="btn btn-sm btn-success">Sudah dijadwalkan`
                    }

                    if(element.status ==  "Berkas OK"){
                        var opsi = `<a href="/admin/skripsi/pendaftar/detail/${element.id}" class="btn btn-sm btn-primary">Jadwalkan manual`
                    }else if(element.status ==  "Terjadwal"){
                        var opsi = `<a href="/admin/skripsi/penjadwalan/detail/${element.id}" class="btn btn-sm btn-primary">Lihat detail`
                    }

                    $('#datatabel').append(`
                        <tr>
                            <td>${myIndex}</td>
                            <td>${element.semester} ${element.tahun}</td>
                            <td>${element.nim}</td>
                            <td>${element.nama}</td>
                            <td>${element.judul}</td>
                            <td>${status}</td>
                            <td>${opsi}</td>
                        </tr>
                        `)

                });
            });
        });
    });

    $(document).ready(function(){
        $('#filtersemesterhasilsempro').on('change', function(e){
            var id = e.target.value;
            $.get('{{ url('admin/proposal/hasil/filter') }}/'+id, function(data){
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
            $.get('{{ url('admin/skripsi/hasil/filter') }}/'+id, function(data){
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

</script>
{{-- <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script> --}}
<script src="{{ asset('tinymce/tinymce.min.js') }}"></script>
{{--
<script>
    tinymce.init({
        selector:'textarea.deskripsi',
        plugins: 'link',
        width: 900,
        height: 300
    });

    tinymce.init({
        selector:'textarea.keterangan',
        width: 610,
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
    }); tinymce.init({
        selector: 'textarea.keterangan',
        menubar: false,
        plugins: 'lists link image preview',
        toolbar: 'undo redo | bold italic underline | alignleft aligncenter alignright | bullist numlist outdent indent | removeformat',
        height: 300
    });
</script>


</html>
