

@extends('admins.layouts.app')

@section('content')    



  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1></h1>
          </div>
          
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
    <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">


          <div class="card">
              <div class="card-header">
                  <h5> Complete Information</h5>      
              </div>
              <div class="card-body">
              
              <form action="{{route('management.first-login')}}" method="post" enctype="multipart/form-data">
              @csrf
     
                
                <div class="row">  
                   
                <div class="form-group col-md-6">
                   <label for="exampleInputEmail1">Name<<span class="required">*</span>/label>
                    <input type="text" class="form-control" name="name" value="{{$vendor->name}}" required>
                 </div>
                 <div class="form-group col-md-6">
                   <label for="exampleInputEmail1">User Name<span class="required">*</span></label>
                    <input type="text" class="form-control" name="userName" value="{{$vendor->userName}}" readonly>
                 </div>
              </div>

              <div class="row">  
                <div class="form-group col-md-6">
                   <label for="exampleInputEmail1">Email<span class="required">*</span></label>
                    <input type="email" class="form-control" name="email"  value="{{$vendor->email}}" required>
                 </div>
                 <div class="form-group col-md-6">
                   <label for="exampleInputEmail1">Birthdate<span class="required">*</span></label>
                    <input type="date" class="form-control" name="birthdate" required>
                 </div>
              </div>

              <div class="row">  
                   <div class="form-group col-md-6">
                      <label for="exampleInputEmail1">Password</label>
                       <input type="password" class="form-control" name="password" >
                    </div>
                    <div class="form-group col-md-6">
                      <label for="exampleInputEmail1">Confirm Password</label>
                       <input type="password" class="form-control" name="conPass" >
                    </div>
                 </div>

                
                 <input type="hidden" name="timezone" id="timezone">
         
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
              </div>
          </div>
      <!-- Default box -->
     
              <!-- /.card-body -->
            
            </div>
       <br>  <br>  <br>  <br>
      <!-- /.card -->
     
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->




@section('script')
<script type="text/javascript" src="{{asset('bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.js')}}" charset="UTF-8"></script>
<script type="text/javascript" src="{{asset('bootstrap-datetimepicker-master/js/locales/bootstrap-datetimepicker.fr.js')}}" charset="UTF-8"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.14/moment-timezone-with-data-2012-2022.min.js"></script>
<script>
        $( document ).ready(function() {
            $('#timezone').val(moment.tz.guess())
        });        
</script>

@endsection

@endsection

