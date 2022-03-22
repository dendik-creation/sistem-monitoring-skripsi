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

    <nav class="navbar navbar-expand-md py-3 navbar-dark bg-primary mb-4">
        <div class="container-fluid">
          <a class="navbar-brand" href="/">Sistem Monitoring Skripsi</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
            <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="/login">Login</a>
                    </li>
                </ul>
            </div>
          </div>
        </div>
      </nav>

      
      
      <main class="col-md-10 mx-auto">
          <div class="mt-2 mb-5 text-center">
              <h1>Pengumuman</h1>
          </div>
        
          @foreach ($data as $item)
            <div class="row-md-12 bg-light p-4 rounded mb-5">
              
              <div class="row ml-4">
                <div class="col-md-9">
                  <div class="row align-items-center p-3 mb-4">
                    <img class="img-profile rounded-circle" src="{{ url('photo/undraw_profile.svg') }}" height="40" width="auto">
                    <span class="align-middle ml-4">Koordinator Skripsi . <?=tgl_indo(substr($item->created_at, 0, 10), false);?></span>
                </div>
                  <h4 class="mb-3 text-left">{{ $item->judul }}</h4>
                  @php
                      $tampil = substr($item->deskripsi,3, 400);
                  @endphp
                  <p class="text-left" style="-webkit-line-clamp: 3; display: -webkit-box; -webkit-box-orient: vertical; overflow: hidden;"><?=$tampil?></p>
                  <a class="btn btn-primary mb-4" href="/pengumuman/detail/{{ $item->id }}" role="button">Lihat detail</a>
                </div>
                <div class="col-md-3 float-right mx-auto text-center my-auto ">
                  <img src="{{ url('pengumuman/'.$item->gambar) }}" alt="" srcset="" height="auto" width="250">
                </div>
              </div>
            </div>
          @endforeach
      </main>
    
    
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
} );

$(document).ready(function() {
    $('#dataTable2').DataTable({
      'paging'      : true,
      'searching'   : true,
      'ordering'    : true,
      'autoWidth'   : true
    });
} );
</script>

</html>