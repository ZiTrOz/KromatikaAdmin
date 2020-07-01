<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>Kromatika Creativos</title>
  <!-- Favicon -->
  <link rel="icon" href="../../assets/img/brand/kromatica.jpg" type="image/jpg">
  <!-- Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
  <!-- Icons -->
  <link rel="stylesheet" href="../../assets/vendor/nucleo/css/nucleo.css" type="text/css">
  <link rel="stylesheet" href="../../assets/vendor/%40fortawesome/fontawesome-free/css/all.min.css" type="text/css">
  <!-- Page plugins -->
  <!-- Argon CSS -->
  <link rel="stylesheet" href="../../assets/vendor/datatables.net-bs4/dataTables.bootstrap4.css" type="text/css">
  <link rel="stylesheet" href="../../assets/css/argon.min.css" type="text/css">  

  
  {{-- <link rel="stylesheet" href="../../assets/vendor/select2/dist/css/select2.min.css" type="text/css"> --}}
  <style>
    .fas {
        cursor: pointer;
    }
</style>
</head>

<body>
  <!-- Sidenav -->
  <nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
      <!-- Brand -->
      <div class="sidenav-header  d-flex  align-items-center">
        <a class="navbar-brand" href="/" style="color: #5e72e4; font-weight: bold;">
          <img src="../../assets/img/brand/kromatica.jpg" class="navbar-brand-img" alt="...">
          Kromatika
        </a>
        <div class=" ml-auto ">
          <!-- Sidenav toggler -->
          <div class="sidenav-toggler d-none d-xl-block" data-action="sidenav-unpin" data-target="#sidenav-main">
            <div class="sidenav-toggler-inner">
              <i class="sidenav-toggler-line"></i>
              <i class="sidenav-toggler-line"></i>
              <i class="sidenav-toggler-line"></i>
            </div>
          </div>
        </div>
      </div>
      <div class="navbar-inner">
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
          <!-- Nav items -->
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" href="#navbar-dashboards" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-dashboards">
                <i class="fas fa-list-alt text-primary"></i>
                <span class="nav-link-text">Orden de Trabajo</span>
              </a>
              <div class="collapse" id="navbar-dashboards">
                <ul class="nav nav-sm flex-column">
                  <li class="nav-item">
                    <a href="/ordentrabajo" class="nav-link">
                      <span class="sidenav-mini-icon"> OT </span>
                      <span class="sidenav-normal"> Consultar </span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="/ordentrabajo/crear" class="nav-link">
                      <span class="sidenav-mini-icon"> N </span>
                      <span class="sidenav-normal"> Crear </span>
                    </a>
                  </li>
                </ul>
              </div>
            </li>    
            <li class="nav-item">
              <a class="nav-link" href="/usuarios" role="button">
                <i class="fas fa-user text-primary"></i>
                <span class="nav-link-text">Usuarios</span>
              </a>              
            </li>    
            <li class="nav-item">
              <a class="nav-link" href="#navbar-warehouse" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-warehouse">
                <i class="fas fa-cubes text-primary"></i>
                <span class="nav-link-text">Almacén</span>
              </a>
              <div class="collapse" id="navbar-warehouse">
                <ul class="nav nav-sm flex-column">
                  <li class="nav-item">
                    <a href="/almacen/inventario" class="nav-link">
                      <span class="sidenav-mini-icon"> INV </span>
                      <span class="sidenav-normal"> Inventario </span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="/almacen/ubicaciones" class="nav-link">
                      <span class="sidenav-mini-icon"> UBI </span>
                      <span class="sidenav-normal"> Ubicaciones </span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="/almacen/transacciones" class="nav-link">
                      <span class="sidenav-mini-icon"> TR </span>
                      <span class="sidenav-normal"> Transacciones </span>
                    </a>
                  </li>
                </ul>
              </div>
            </li>    
          </ul>
        </div>
      </div>
    </div>
  </nav>
  <!-- Main content -->
  <div class="main-content" id="panel">
    <!-- Topnav -->
    <nav class="navbar navbar-top navbar-expand navbar-dark bg-primary border-bottom">
      <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <!-- Navbar links -->
          <ul class="navbar-nav align-items-center  ml-md-auto ">
            <li class="nav-item d-xl-none">
              <!-- Sidenav toggler -->
              <div class="pr-3 sidenav-toggler sidenav-toggler-dark" data-action="sidenav-pin" data-target="#sidenav-main">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                </div>
              </div>
            </li>
          </ul>
          <ul class="navbar-nav align-items-center  ml-auto ml-md-0 ">
            <li class="nav-item dropdown">
              <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <div class="media align-items-center">
                  {{-- <span class="avatar avatar-sm rounded-circle">
                    <img alt="Image placeholder" src="../../assets/img/theme/team-4.jpg">
                  </span> --}}
                  <div class="media-body  ml-2  d-none d-lg-block">
                    <span class="mb-0 text-sm  font-weight-bold">Kromatika </span>
                  </div>
                </div>
              </a>
              <div class="dropdown-menu  dropdown-menu-right ">                
                <div class="dropdown-divider"></div>
                <a href="#!" class="dropdown-item">
                  <i class="ni ni-user-run"></i>
                  <span>Logout</span>
                </a>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <div id="app">
        <main-component component="{{ $component }}" title="{{ $title }}" id="{{ $id }}"></main-component>
    </div>
  </div>
  <!-- Argon Scripts -->
  <!-- Core -->
  <script src="../../assets/vendor/jquery/dist/jquery.min.js"></script>
  <script src="../../assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../../assets/vendor/js-cookie/js.cookie.js"></script>
  <script src="../../assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js"></script>
  <script src="../../assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js"></script>

  <script type="text/javascript" charset="utf8" src="../../assets/vendor/datatables.net/jquery.dataTables.js"></script>
  <script type="text/javascript" charset="utf8" src="../../assets/vendor/datatables.net-bs4/dataTables.bootstrap4.js"></script>
  
  <!-- Argon JS -->
  <script src="../../assets/js/argon.min.js?"></script>
  <script src="/js/app.js"></script>
  <script>
		$(document).ready(function(){
			$("input").attr("autocomplete", "off");
			$('span .vs__selected').attr("font-size", "875rem");
			// $('.vdp-datepicker .input-group input').attr('readonly', false);
			//$('select').select2();
		});
    </script>
</body>
</html>