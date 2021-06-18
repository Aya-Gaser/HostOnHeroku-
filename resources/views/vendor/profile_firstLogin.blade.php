

@extends('vendor.layouts.app_firstLogin')

@section('content')



  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    

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
              <form id="firstLogin" action="{{route('vendor.first-login')}}" method="post" enctype="multipart/form-data">
              @csrf
     
                
                <div class="row">  
                   
                <div class="form-group col-md-6">
                   <label for="exampleInputEmail1">Name<span class="required">*</span></label>
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
                   <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{$vendor->email}}" required autocomplete="email">

@error('email')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
@enderror                 </div>
                 <div class="form-group col-md-6">
                   <label for="exampleInputEmail1">Birthdate<span class="required">*</span></label>
                    <input type="date" class="form-control" name="birthdate" required >
                 </div>
              </div>

             

                 <div class="row">  
                   <div class="form-group col-md-6">
                      <label for="exampleInputEmail1">Native Language<span class="required">*</span></label>
                      <select class="selectpicker form-control" data-live-search="true" name="native_language" id="client_number" required>
                   <option disabled>Select / Insert Language</option>
                   <option
                        value="Arabic" > Arabic
                    </option>
                    <option
                        value="English" > English
                    </option>
                    <option
                        value="Farsi" > Farsi
                    </option>
                    </select>
                    </div>
                   
                 <div class="form-group col-md-6">
                      <label for="exampleInputEmail1">Timezone</label>
                      <input type="text" name="timezone" id="timezone" class="form-control"  readonly>
                    </div>
                 </div>
                 <div class="row">  
                   <div class="form-group col-md-6">
                      <label for="exampleInputEmail1">Password <span class="required">*</span></label>
                      <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror 
                    </div>
                    <div class="form-group col-md-6">
                      <label for="exampleInputEmail1">Confirm Password <span class="required">*</span></label>
                      <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                    </div>
                 </div>
         
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

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.14/moment-timezone-with-data-2012-2022.min.js"></script>
<script>
        $( document ).ready(function() {
            $('#timezone').val(moment.tz.guess())
        }); 
        $('#firstLogin').submit(function(e) {
           document.body.style.cursor='wait';           

        });          
</script>
@endsection

@endsection
