
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
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('management.dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active">Create WO</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
        <div class="card card-success shadow-sm col-md-10">
              <div class="card-header">
                <h3 class="card-title">Profile Information </h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
                </div>
             
                <div class="card-body">
             <p class="data"> <Span class="head"> ID : </Span>{{$user->id}} </p>
              <p class="data"> <Span class="head">Name : </Span>{{$user->name}} </p>
              <p class="data"> <Span class="head"> User Name  : </Span>{{$user->userName}} </p>
              <p class="data"> <Span class="head"> Email	  : </Span>{{$user->email}} </p>
              <p class="data"> <Span class="head"> Timezone	  : </Span>{{$user->timezone}} </p>
              <p class="data"> <Span class="head"> Birth Date : </Span>  {{$user->birthdate}} </p>
              <p class="data"> <Span class="head"> Created at : </Span> 
             {{ UTC_To_LocalTime($user->created_at,$user->timezone)}}
                </p> 
                <p class="data"> <Span class="head">Password : </Span> 
               <span id="password">{{ decrypt($user->visible) }} </span>
               <span id="showPass" style="cursor:pointer; color:red;">  <i class="fas fa-eye"></i> </span>
                </p>
              </div>
            </div>    
        </div>
       
        <div class="card col-md-10">
              <div class="card-header">
                  <h5> Update Information</h5>      
              </div>
              <div class="card-body">
              <form action="{{route('management.update-profile',$user->id)}}" method="post" enctype="multipart/form-data">
              @csrf
     
                
                <div class="row">  
                   
                <div class="form-group col-md-6">
                   <label for="exampleInputEmail1">Name</label>
                    <input type="text" class="form-control" name="name" value="{{$user->name}}">
                 </div>
                 <div class="form-group col-md-6">
                   <label for="exampleInputEmail1">User Name</label>
                    <input type="text" class="form-control" name="userName" value="{{$user->userName}}" readonly>
                 </div>
              </div>

              <div class="row">  
                <div class="form-group col-md-6">
                   <label for="exampleInputEmail1">Email</label>
                    <input type="email" class="form-control" name="email"  value="{{$user->email}}">
                 </div>
                 <div class="form-group col-md-6">
                   <label for="exampleInputEmail1">Birthdate</label>
                    <input type="date" value="{{$user->birthdate}}" class="form-control" name="birthdate"  >
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

                 <div class="row">  
                  
                    <div class="form-group col-md-6">
                      <label for="exampleInputEmail1">Timezone</label>
                      <input type="text" value="{{$user->timezone}}" class="form-control" name="timezone" id="timezone" readonly>
                    </div>
                   
                 </div>
                 
         
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary" >Submit</button>
                </div>
              </form>
              </div>
          </div>
        </div>

      </div>  
      
      
      <!-- /.card -->
      
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- /.control-sidebar -->


@section('script')
<script>

$(function () {
  $('#password').fadeOut();
   // $('#modal').fadeOut()
 $('#showPass').click(function(){
   // $('#password').fadeIn();
    var x = document.getElementById("password");
    if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
 }); 
});
</script>
@endsection

@endsection
