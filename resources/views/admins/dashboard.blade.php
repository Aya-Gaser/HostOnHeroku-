

@extends('admins.layouts.app')

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
              <div class="small-box bg-danger">
                <div class="inner">
                  <h3>{{$allWo}}</h3>

                  <p>WORK NEEDED</p>
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
                  <span class="info-box-text">{{$notRecievedWo}}</span>
                  <span class="info-box-number">UN-RECIEVED</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <div class="col-md-3 col-sm-6 col-12">
              <div class="info-box shadow">
                <span class="info-box-icon bg-danger"><i class="far fa-copy"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">{{$pendingWo}}</span>
                  <span class="info-box-number">PENDING</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <div class="col-md-3 col-sm-6 col-12">
              <div class="info-box shadow">
                <span class="info-box-icon bg-danger"><i class="far fa-copy"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">{{$CompletedWo}}</span>
                  <span class="info-box-number">COMPLETED</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
          </div>
      
        <div class="row">
            <div class="col-lg-3 col-6">
              <!-- small card -->
              <div class="small-box bg-warning">
                <div class="inner">
                  <h3>{{$linkedProjects_all}}</h3>

                  <p>LINKED PROJECT</p>
                </div>
                <div class="icon">
                  <i class="fas fa-shopping-cart"></i>
                </div>
               
              </div>
            </div>
            <div class="col-md-3 col-sm-6 col-12">
              <div class="info-box shadow">
                <span class="info-box-icon bg-warning"><i class="far fa-copy"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">{{$linkedProjects_pending}}</span>
                  <span class="info-box-number">PENDING</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <div class="col-md-3 col-sm-6 col-12">
              <div class="info-box shadow">
                <span class="info-box-icon bg-warning"><i class="far fa-copy"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">{{$linkedProjects_onProgress}}</span>
                  <span class="info-box-number">ON PROGRESS</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <div class="col-md-3 col-sm-6 col-12">
              <div class="info-box shadow">
                <span class="info-box-icon bg-warning"><i class="far fa-copy"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">{{$linkedProjects_completed}}</span>
                  <span class="info-box-number">COMPLETED</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
          </div>
          <div class="row">
            <div class="col-lg-3 col-6">
              <!-- small card -->
              <div class="small-box translation">
                <div class="inner">
                  <h3>{{$translationProjects_all}}</h3>

                  <p>TRANSLATION</p>
                </div>
                <div class="icon">
                  <i class="fas fa-shopping-cart"></i>
                </div>
               
              </div>
            </div>
            <div class="col-md-3 col-sm-6 col-12">
              <div class="info-box shadow">
                <span class="info-box-icon translation"><i class="far fa-copy"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">{{$translationProjects_pending}}</span>
                  <span class="info-box-number">PENDING</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <div class="col-md-3 col-sm-6 col-12">
              <div class="info-box shadow">
                <span class="info-box-icon translation"><i class="far fa-copy"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">{{$translationProjects_onProgress}}</span>
                  <span class="info-box-number">ON PROGRESS</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <div class="col-md-3 col-sm-6 col-12">
              <div class="info-box shadow">
                <span class="info-box-icon translation"><i class="far fa-copy"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">{{$translationProjects_completed}}</span>
                  <span class="info-box-number">COMPLETED</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
          </div>
          <div class="row">
            <div class="col-lg-3 col-6">
              <!-- small card -->
              <div class="small-box bg-info">
                <div class="inner">
                  <h3>{{$editingProjects_all}}</h3>

                  <p>EDITING</p>
                </div>
                <div class="icon">
                  <i class="fas fa-shopping-cart"></i>
                </div>
               
              </div>
            </div>
            <div class="col-md-3 col-sm-6 col-12">
              <div class="info-box shadow">
                <span class="info-box-icon bg-info"><i class="far fa-copy"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">{{$editingProjects_pending}}</span>
                  <span class="info-box-number">PENDING</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <div class="col-md-3 col-sm-6 col-12">
              <div class="info-box shadow">
                <span class="info-box-icon bg-info"><i class="far fa-copy"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">{{$editingProjects_onProgress}}</span>
                  <span class="info-box-number">ON PROGRESS</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <div class="col-md-3 col-sm-6 col-12">
              <div class="info-box shadow">
                <span class="info-box-icon bg-info"><i class="far fa-copy"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">{{$editingProjects_completed}}</span>
                  <span class="info-box-number">COMPLETED</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
          </div>
          <div class="row">
            <div class="col-lg-3 col-6">
              <!-- small card -->
              <div class="small-box dtp">
                <div class="inner">
                  <h3>{{$dtpProjects_all}}</h3>

                  <p>DTP</p>
                </div>
                <div class="icon">
                  <i class="fas fa-shopping-cart"></i>
                </div>
               
              </div>
            </div>
            <div class="col-md-3 col-sm-6 col-12">
              <div class="info-box shadow">
                <span class="info-box-icon dtp"><i class="far fa-copy"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">{{$dtpProjects_pending}}</span>
                  <span class="info-box-number">PENDING</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <div class="col-md-3 col-sm-6 col-12">
              <div class="info-box shadow">
                <span class="info-box-icon dtp"><i class="far fa-copy"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">{{$dtpProjects_onProgress}}</span>
                  <span class="info-box-number">ON PROGRESS</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <div class="col-md-3 col-sm-6 col-12">
              <div class="info-box shadow">
                <span class="info-box-icon dtp"><i class="far fa-copy"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">{{$dtpProjects_completed}}</span>
                  <span class="info-box-number">COMPLETED</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
          </div>
        
          <!-- /.col -->
        </div>
     
      <!-- /.card -->
      
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection
