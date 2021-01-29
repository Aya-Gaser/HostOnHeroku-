<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
    <meta name="author" content="">
    <title>Tarjamat</title>
    <!-- Favicon -->
    <link href="" rel="icon" type="image/png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
  <link href="{{asset('//bootstrap-datetimepicker-master/css/bootstrap.min.css')}}" rel="stylesheet" media="screen">

<!-- Latest compiled and minified JavaScript -->
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('//plugins/fontawesome-free/css/all.min.css')}}">
   <!-- Select2 -->

   <link rel="stylesheet" href="{{asset('//plugins/select2/css/select2.min.css')}}">
  <link rel="stylesheet" href="{{asset('//plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
  <!-- Theme style -->

    <link href="{{asset('//bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" media="screen">
    <link href="{{asset('//dist/css/adminlte.min.css')}}" rel="stylesheet">
       <!-- DataTables -->
   <link rel="stylesheet" href="{{asset('//plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('//plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('//plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
    <style>
.card-body{
    padding:8px;
}
.body{
    background-image:url("{{//asset('img/bg4.jpg')}}");
    background-size:cover;
    background-repeat:no-repeat;
    background-position: center;
    
}
.overlay{
    background-color: #000000a6;
    width:100%;
    height:100%;
    padding-right: 7.5px;
    padding-left: 7.5px;
  
    position: fixed;
}
.header{
    background-color: transparent;
}
footer {
  position: absolute;
  bottom: 0;
  width: 100%;
  height: 2.5rem;            /* Footer height */
}
</style>
    @yield('style')
    
 
</head>

<body class="hold-transition body">
  <div class="overlay main-content">
    <div class="header py-lg-5">
            <div class="container">
                <div class="header-body text-center mb-7">
                    <div class="row justify-content-center">
                        <div class="col-lg-5 col-md-6">
                            <h1 class="text-success" style="font-weight:bold;">Welcome To Tarjamt</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
    @yield('content')
  </div>  
    
<!-- Footer -->
<footer class="py-3" style="background-color:#202123;">
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
  

  
    <!-- Header -->
   
    


<!-- jQuery -->
<script src="{{asset('//plugins/jquery/jquery.min.js')}}"></script>
<script src="{{asset('//plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('//plugins/select2/js/select2.full.min.js')}}"></script>
<script src="{{asset('//plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- bs-custom-file-input -->
<script src="{{asset('//plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<!-- Bootstrap Switch -->
<script src="{{asset('//plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

<!-- (Optional) Latest compiled and minified JavaScript translation files -->

<script type="text/javascript" src="{{asset('//bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.js')}}" charset="UTF-8"></script>
<script type="text/javascript" src="{{asset('//bootstrap-datetimepicker-master/js/locales/bootstrap-datetimepicker.fr.js')}}" charset="UTF-8"></script>
<script src="{{asset('//dist/js/adminlte.min.js')}}"></script>



@yield('script')
</body>

</html>