

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
.item{
  padding:10px;
}
.inner a{
  color:#fff;
}
.inner p,.info-box-text a {
  text-decoration: underline;
  color:#fff;
}
</style>
@endsection


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4 col-6">
              <!-- small card -->
              <div class="small-box bg-danger">
                <div class="inner">
                  <h3>{{$allWo}}</h3>
                  <a href="{{route('management.view-allWo')}}" >
                  <p>All WORK NEEDED</p>
                </a>
               
                </div>
                <div class="icon">
                  <i class="fas fa-dollar"></i>
                </div>
                <div class="row item" style="">
                <div class="info-box-content col-md-4">
                  <span class="info-box-number">{{$notRecievedWo}}</span>
                  <span class="info-box-text">
                    <a href="{{route('management.view-allProjects', 'all') }}" >
                      <p>UN-RECIEVED</p>
                    </a>
                  </span>
                </div>
                
                <div class="info-box-content col-md-4">
                  <span class="info-box-number">{{$pendingWo}}</span>
                  <span class="info-box-text">
                    <a href="{{route('management.view-allProjects', 'all') }}" >
                      <p>PENDING</p>
                    </a>
                  </span>                </div>
                <div class="info-box-content col-md-4">
                  <span class="info-box-number">{{$CompletedWo}}</span>
                  <span class="info-box-text">
                    <a href="{{route('management.view-allProjects', 'all') }}" >
                      <p>COMPLETED</p>
                    </a>
                  </span>                </div>
                </div>
              </div>
            </div>
           <!-- /************prjects ****************/ -->
           <div class="col-lg-4 col-6">
              <!-- small card -->
              <div class="small-box bg-info">
                <div class="inner">
                  <h3>{{$allProjects}}</h3>
                  <a href="{{route('management.view-allProjects', 'all') }}" >
                  <p>All Projects</p>
                </a>
               
                </div>
                <div class="icon">
                  <i class="fas fa-dollar"></i>
                </div>
                <div class="row item" style="">
                <div class="info-box-content col-md-4">
                  <span class="info-box-number">{{$allProjects_pending}}</span>
                  <span class="info-box-text">
                    <a href="{{route('management.view-allProjects', 'pending') }}" >
                      <p>PENDING</p>
                    </a>
                  </span>
                </div>
                
                <div class="info-box-content col-md-4">
                <span class="info-box-number">{{$allProjects_progress}}</span>
                  <span class="info-box-text">
                    <a href="{{route('management.view-allProjects', 'progress') }}" >
                      <p>IN PROGRESS</p>
                    </a>
                  </span>
                </div>
                <div class="info-box-content col-md-4">
                <span class="info-box-number">{{$allProjects_completed}}</span>
                  <span class="info-box-text">
                    <a href="{{route('management.view-allProjects', 'Completed') }}" >
                      <p>COMPLETED</p>
                    </a>
                  </span>
                </div>
                </div>
              </div>
            </div>
           <!-- /************invoice ****************/ -->

            <div class="col-lg-4 col-6">
              <!-- small card -->
              <div class="small-box bg-success">
                <div class="inner">
                  <h3>{{$allInvoices}}</h3>
                  <a href="{{route('management.view-allInvoices', 'All') }}" >
                  <p>All Vendors Invoices</p>
                </a>
               
                </div>
                <div class="icon">
                  <i class="fas fa-dollar"></i>
                </div>
                <div class="row item" style="">
                <div class="info-box-content col-md-4">
                  <span class="info-box-number">{{$vendorInvoice_pending}}</span>
                  <span class="info-box-text">
                    <a href="{{route('management.view-allInvoices', 'Pending') }}" >
                      <p>PENDING</p>
                    </a>
                  </span>
                </div>
                
                <div class="info-box-content col-md-4">
                <span class="info-box-number">{{$vendorInvoice_approved}}</span>
                  <span class="info-box-text">
                    <a href="{{route('management.view-allReadyToPayInvoices', 'Approved') }}" >
                      <p>APPROVED</p>
                    </a>
                  </span>
                </div>
                <div class="info-box-content col-md-4">
                <span class="info-box-number">{{$vendorInvoice_paid}}</span>
                  <span class="info-box-text">
                    <a href="{{route('management.view-allReadyToPayInvoices', 'Paid') }}" >
                      <p>PAID</p>
                    </a>
                  </span>
                </div>
                </div>
              </div>
            </div>
            </div>
           
           <!-- ///////// translation  -->
      <div class="row">
        <div class="col-lg-4 col-6">
              <!-- small card -->
              <div class="small-box translation">
                <div class="inner">
                  <h3>{{$translationProjects_all}}</h3>
                  <a href="{{route('management.view-allProjects_type',['type'=>'translation','status'=>'all']) }}" >

                  <p>TRANSLATION</p>
                  </a>
                </div>
                <div class="icon">
                  <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="row item">
                <div class="info-box-content col-md-4">
                  <span class="info-box-text">{{$translationProjects_pending}}</span>
                  <span class="info-box-text">
                    <a href="{{route('management.view-allProjects_type',['type'=>'translation','status'=>'pending']) }}" >
                      <p>PENDING</p>
                    </a>
                  </span>
                </div>
                <div class="info-box-content col-md-4">
                  <span class="info-box-text">{{$translationProjects_onProgress}}</span>
                  <span class="info-box-text">
                  <a href="{{route('management.view-allProjects_type',['type'=>'translation','status'=>'progress']) }}" >
                      <p>IN PROGRESS</p>
                    </a>
                  </span>
                </div>
                <div class="info-box-content col-md-4">
                  <span class="info-box-text">{{$translationProjects_completed}}</span>
                  <span class="info-box-text">
                  <a href="{{route('management.view-allProjects_type',['type'=>'translation','status'=>'Completed']) }}" >
                      <p>COMPLETED</p>
                    </a>
                  </span>                
                  </div>
               
        
               
                <!-- /.info-box-content -->
              </div>
              </div>
              <!-- /.info-box -->
            </div>

  <!-- ///////// editing  -->
      
        <div class="col-lg-4 col-6">
              <!-- small card -->
              <div class="small-box editing">
                <div class="inner">
                  <h3>{{$editingProjects_all}}</h3>
                  <a href="{{route('management.view-allProjects_type',['type'=>'editing','status'=>'all']) }}" >
                  
                  <p>EDITING</p>
                  </a>
                </div>
                <div class="icon">
                  <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="row item">
                <div class="info-box-content col-md-4">
                  <span class="info-box-text">{{$editingProjects_pending}}</span>
                  <span class="info-box-text">
                  <a href="{{route('management.view-allProjects_type',['type'=>'editing','status'=>'pending']) }}" >
                      <p>PENDING</p>
                    </a>
                  </span>
                </div>
                <div class="info-box-content col-md-4">
                  <span class="info-box-text">{{$editingProjects_onProgress}}</span>
                  <span class="info-box-text">
                  <a href="{{route('management.view-allProjects_type',['type'=>'editing','status'=>'progress']) }}" >
                      <p>IN PROGRESS</p>
                    </a>
                  </span>
                </div>
                <div class="info-box-content col-md-4">
                  <span class="info-box-text">{{$editingProjects_completed}}</span>
                  <span class="info-box-text">
                  <a href="{{route('management.view-allProjects_type',['type'=>'editing','status'=>'Completed']) }}" >
                      <p>COMPLETED</p>
                    </a>
                  </span>                
                  </div>
               
        
               
                <!-- /.info-box-content -->
              </div>
              </div>
              <!-- /.info-box -->
            </div>
  <!-- ///////// DTP  -->
      
        <div class="col-lg-4 col-6">
              <!-- small card -->
              <div class="small-box dtp">
                <div class="inner">
                
                  <h3>{{$dtpProjects_all}}</h3>
                  <a href="{{route('management.view-allProjects_type',['type'=>'dtp','status'=>'all']) }}" >

                  <p>DTP</p>
                  </a>
                </div>
                <div class="icon">
                  <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="row item">
                <div class="info-box-content col-md-4">
                  <span class="info-box-text">{{$dtpProjects_pending}}</span>
                  <span class="info-box-text">
                  <a href="{{route('management.view-allProjects_type',['type'=>'dtp','status'=>'pending']) }}" >
                      <p>PENDING</p>
                    </a>
                  </span>
                </div>
                <div class="info-box-content col-md-4">
                  <span class="info-box-text">{{$dtpProjects_onProgress}}</span>
                  <span class="info-box-text">
                  <a href="{{route('management.view-allProjects_type',['type'=>'dtp','status'=>'progress']) }}" >
                      <p>IN PROGRESS</p>
                    </a>
                  </span>
                </div>
                <div class="info-box-content col-md-4">
                  <span class="info-box-text">{{$dtpProjects_completed}}</span>
                  <span class="info-box-text">
                  <a href="{{route('management.view-allProjects_type',['type'=>'dtp','status'=>'Completed']) }}" >
                      <p>COMPLETED</p>
                    </a>
                  </span>                
                  </div>
               
        
               
                <!-- /.info-box-content -->
              </div>
              </div>
              <!-- /.info-box -->
            </div>

            </div>

  <!-- ///////// linked  -->
      
  <div class="row">
        <div class="col-lg-4 col-6">
              <!-- small card -->
              <div class="small-box bg-dark">
                <div class="inner">
                  <h3>{{$linkedProjects_all}}</h3>
                  <a href="{{route('management.view-allProjects_type',['type'=>'linked','status'=>'all']) }}" >

                  <p>LINKED</p>
                  </a>
                </div>
                <div class="icon">
                  <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="row item">
                <div class="info-box-content col-md-4">
                  <span class="info-box-text">{{$linkedProjects_pending}}</span>
                  <span class="info-box-text">
                  <a href="{{route('management.view-allProjects_type',['type'=>'linked','status'=>'pending']) }}" >
                      <p>PENDING</p>
                    </a>
                  </span>
                </div>
                <div class="info-box-content col-md-4">
                  <span class="info-box-text">{{$linkedProjects_onProgress}}</span>
                  <span class="info-box-text">
                  <a href="{{route('management.view-allProjects_type',['type'=>'linked','status'=>'progress']) }}" >
                      <p>IN PROGRESS</p>
                    </a>
                  </span>
                </div>
                <div class="info-box-content col-md-4">
                  <span class="info-box-text">{{$linkedProjects_completed}}</span>
                  <span class="info-box-text">
                  <a href="{{route('management.view-allProjects_type',['type'=>'linked','status'=>'Completed']) }}" >
                      <p>COMPLETED</p>
                    </a>
                  </span>                
                  </div>
               
        
               
                <!-- /.info-box-content -->
              </div>
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
