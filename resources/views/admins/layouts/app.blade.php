<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
    <meta name="author" content="">
    <title>Tarjamat</title>
    <!-- Favicon --> 
    <link href="" rel="icon" type="image/png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

<!-- Latest compiled and minified JavaScript -->
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
 
   <!-- Select2 -->

   <link rel="stylesheet" href="{{asset('plugins/select2/css/select2.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
  <!-- Theme style -->

    <link href="{{asset('bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" media="screen">
       <!-- DataTables -->
   <link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
   <!-- Font Awesome -->
   <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
  <link href="{{asset('dist/css/adminlte.min.css')}}" rel="stylesheet">
  
    <style>
.elevation-4{
  box-shadow:none;
}
hr {
  border: 0;
  clear:both;
  display:block;
  width: 90%;               
  height: 1px;
}
.data,.head{
    font-size:18px;
    font-family:verdana; 
    color:green;
}
.head{
    color:#464040;
}
 button a, button a:hover{
    color:white;
    text-decoration:none;
}
tr{
  height:5px;
  margin-top:10px;
}
.activeNav{
    background-color: #007bff;
    color: #fff;
}
.language{
  text-transform: capitalize;
}
.required{
  color:red;
}
.pending{
  color:#eb6434;
}
</style>
    @yield('style')
    
 
</head>

<body class="hold-transition sidebar-mini">


<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{route('management.dashboard')}}" class="nav-link">Home</a>
      </li>
     
    </ul>

   

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('management.dashboard')}}" class="brand-link">
      <img src="{{asset('dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Tarjamat</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('dist/img/avatar2.png')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{Auth::user()->name}}</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        <li class="nav-item">
          <a href="{{route('management.projects-tracking')}}" 
          class="nav-link {{ isActive('management.projects-tracking')}}">
            <i class="far fa-eye nav-icon"></i>
            <p>Projects Tracking</p>
          </a>
        </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Work Needed
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('management.create-wo')}}" 
                class="nav-link {{ isActive('management.create-wo')}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Create WO</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('management.view-allWo')}}" 
                class="nav-link {{ isActive('management.view-allWo')}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>View All WO</p>
                </a>
              </li>
             
              
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Projects
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
             
              <li class="nav-item">
                <a href="{{route('management.view-allProjects', 'pending') }}" 
                class="nav-link {{ isActive('management.view-allProjects')}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>On Progress Projects</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('management.view-allProjects', 'completed') }}" 
                class="nav-link {{ isActive('management.view-allProjects')}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Completed Projects</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('management.view-allProjects', 'all') }}" 
                class="nav-link {{ isActive('management.view-allProjects')}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All Projects</p>
                </a>
              </li>
              
            </ul>
          </li>
         
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Vendors
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('management.view-allVendors')}}" 
                class="nav-link {{ isActive('management.view-allVendors')}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Create Vendor</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('management.view-allVendors')}}" 
                class="nav-link {{ isActive('management.view-allVendors')}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>View All Vendors</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
               Clients
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('management.view-allClients')}}" 
                class="nav-link {{ isActive('management.view-allClients')}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Create Client</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('management.view-allClients')}}" 
                class="nav-link {{ isActive('management.view-allClients')}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>View All Clients</p>
                </a>
              </li>
             
              </ul>
          </li>
          <br>
          <hr style="background-color:#ccc;">
          <li class="nav-item">
                <a href="{{route('management.admin-profile',Auth::user()->id)}}" 
                class="nav-link {{ isActive('management.admin-profile')}}">
                  <i class="far fa-user nav-icon"></i>
                  <p>My Profile</p>
                </a>
              </li>
        <li class="nav-item">   
         
         <a class="nav-link" href="{{ route('logout') }}"
             onclick="event.preventDefault();
                           document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt nav-icon"></i> 
            <p> {{ __('Logout') }} </p> 
         </a>

         <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
             @csrf
         </form>
    
      </li>    
          
        </ul>

</nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
    <!-- Header -->
   @yield('content')
    

<!-- Footer -->
<footer class="py-3 bg-dark">
    <div class="container">
        <div class="row align-items-center justify-content-xl-between">
            <div class="col-xl-12">
                <div class="copyright text-center text-xl-center text-light ">
                   All Copyrights reserved to Tarjamat &copy; 2021 | <a href="https://www.linkedin.com/in/ayagaber" class="font-weight-bold ml-1" target="_blank">Developer</a>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- jQuery -->
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<script src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- bs-custom-file-input -->
<script src="{{asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

<!-- (Optional) Latest compiled and minified JavaScript translation files -->

<script type="text/javascript" src="{{asset('bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.js')}}" charset="UTF-8"></script>
<script type="text/javascript" src="{{asset('bootstrap-datetimepicker-master/js/locales/bootstrap-datetimepicker.fr.js')}}" charset="UTF-8"></script>
<script src="{{asset('dist/js/adminlte.min.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('dist/js/demo.js')}}"></script>


{{--  SweetAlert  --}}
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@if (Session::has('sweet_alert.alert'))
    <script>
        swal({!! Session::get('sweet_alert.alert') !!});

    </script>
@endif

<!-- Include this after the sweet alert js file -->
@include('sweet::alert')

<script>
$(function () {

  $("a.activeNav").parents('ul.nav').siblings('a.nav-link').css({"background-color":"#007bff", 'color':"#fff"});

});
$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});
</script>
@yield('script')
</body>

</html>