@extends('vendor.layouts.app')

@section('content')

@section('style')
<style>
.table td, .table th{
  padding:5px;
 
  
}
td{
  white-space: normal;
  word-break: break-all;
}

table{
  height:170px;
}
th{
  height:70px;
}
.deadline{
  word-break:keep-all;
}
.translation{
  background-color:#d96c3d;
  color:white;
}
.dtp{
  background-color:#ca3d54;
  color:white;
}
.editing{
  background-color:#3c6e65;
  color:white;
}
</style>

@endsection


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-6">
              <!-- small card -->
              <div class="small-box bg-info">
                <div class="inner">
                  <h3>{{$VendorProjects_all}}</h3>

                  <p>PROJECTS</p>
                </div>
                <div class="icon">
                  <i class="fas fa-shopping-cart"></i>
                </div>
               
              </div>
            </div>
            <div class="col-md-3 col-sm-6 col-12">
              <div class="info-box shadow">
                <span class="info-box-icon bg-danger"><i class="far fa-copy"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">{{$VendorProjects_undelivered}}</span>
                  <span class="info-box-number">UNDELIVERED</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <div class="col-md-3 col-sm-6 col-12">
              <div class="info-box shadow">
                <span class="info-box-icon bg-warning"><i class="far fa-copy"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">{{$VendorProjects_pending}}</span>
                  <span class="info-box-number">PENDING</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <div class="col-md-3 col-sm-6 col-12">
              <div class="info-box shadow">
                <span class="info-box-icon bg-success"><i class="far fa-copy"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">{{$VendorProjects_completed}}</span>
                  <span class="info-box-number">COMPELETED</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
           
          </div>
      
     
     
      <!-- /.card -->
      
    </section>
    <!-- /.content -->
  </div>
 @endsection