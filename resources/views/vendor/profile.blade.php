@extends('vendor.layouts.app')

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
              <li class="breadcrumb-item"><a href="{{route('vendor.dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active">Update Profile</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
    <div class="container-fluid">
        <div class="row">
          <div class="col-md-10">


          <div class="card">
              <div class="card-header">
                  <h5> Profile Information</h5>      
              </div>
              <div class="card-body">
              <p class="data"> <Span class="head"> ID : </Span>{{$user->id}} </p>
              <p class="data"> <Span class="head">Name : </Span>{{$user->name}} </p>
              <p class="data"> <Span class="head"> User Name  : </Span>{{$user->Name}} </p>
              <p class="data"> <Span class="head"> Email	  : </Span>{{$user->email}} </p>
              <p class="data"> <Span class="head"> Native Language  : </Span>{{$user->native_language}} </p>
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
      <!-- Default box -->
     
        <div class="card col-md-10">
              <div class="card-header">
                  <h5> Update Information</h5>      
              </div>
              <div class="card-body">
              <form action="{{route('vendor.update-profile',$user->id)}}" method="post" enctype="multipart/form-data">
              @csrf
     
                
                <div class="row">  
                   
                <div class="form-group col-md-6">
                   <label for="exampleInputEmail1">Name</label>
                    <input type="text" class="form-control" name="name" value="{{$user->name}}" >
                 </div>
                 <div class="form-group col-md-6">
                   <label for="exampleInputEmail1">User Name</label>
                    <input type="text" class="form-control" name="userName" value="{{$user->userName}}" readonly >
                 </div>
              </div>

              <div class="row">  
                <div class="form-group col-md-6">
                   <label for="exampleInputEmail1">Email</label>
                    <input type="email" class="form-control" name="email"  value="{{$user->email}}" >
                 </div>
                 <div class="form-group col-md-6">
                   <label for="exampleInputEmail1">Birthdate</label>
                    <input type="date" value="{{$user->birthdate}}" class="form-control" name="Birthdate"  >
                 </div>
              </div>

              <div class="row">  
                   <div class="form-group col-md-6">
                      <label for="exampleInputEmail1">Password</label>
                       <input type="password" class="form-control" name="email" >
                    </div>
                    <div class="form-group col-md-6">
                      <label for="exampleInputEmail1">Confirm Password</label>
                       <input type="password" class="form-control" name="email" >
                    </div>
                 </div>

                 <div class="row">  
                   <div class="form-group col-md-6">
                      <label for="exampleInputEmail1">Native Language</label>
                      <select default="arabic" class="selectpicker form-control" data-live-search="true" name="native_language" id="client_number">
                   <option disabled selected >Select / Insert Language</option>
                   <option
                        value="arabic" > arabic
                    </option>
                    </select>
                    </div>
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
              <!-- /.card-body -->
            
            </div>
     
      <!-- /.card -->
     
    </section>
    <!-- /.content -->
  </div>

@section('script')

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.14/moment-timezone-with-data-2012-2022.min.js"></script>
<script>
$( document ).ready(function() {
    $('#timezone').val(moment.tz.guess())
}); 
        
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
