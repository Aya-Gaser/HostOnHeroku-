
@extends('admins.layouts.app')

@section('content')  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
           
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('management.dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active">All Vendors</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
    <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">

          @if(Auth::user()->can('create-vendor'))
          <div class="card">
              <div class="card-header">
                  <h5> Add New Vendor</h5>      
              </div>
              <div class="card-body">
              <form action="{{route('management.create-vendor' )}}" method="post" enctype="multipart/form-data">
              @csrf
     
                
                <div class="row">  
                   
                <div class="form-group col-md-6">
                   <label for="exampleInputEmail1">Name</label>
                    <input type="text" class="form-control" name="name"  placeholder="">
                 </div>
                 <div class="form-group col-md-6">
                   <label for="exampleInputEmail1">User Name</label>
                    <input type="text" class="form-control" name="userName" placeholder="">
                 </div>
              </div>
              <div class="row">  
                   
                <div class="form-group col-md-6">
                   <label for="exampleInputEmail1">Email</label>
                    <input type="email" class="form-control" name="email"  placeholder="">
                 </div>
                 <div class="form-group col-md-6">
                   <label for="exampleInputEmail1">Created on</label>
                    <input type="date" class="form-control" name="created_at"  placeholder="">
                 </div>
                 
              </div>
         
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
              </div>
          </div>
       @endif   
      <!-- Default box -->
      <div class="card" style="padding:15px;">
             
      <div class="card-header">
      
                <div class="card-tools form-group float-right row" style="">
               
                 </div> 
                 <h5> All Vendors </h5>            
                 </div>  
           <br>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" id="myTable-wraper">
                <table class="table table-hover" id="myTable">
                  <thead>
                    <tr>
                    
                      <th>ID</th>
                      <th>Name</th>
                      <th>User Name</th>
                      <th>Native Language</th>
                      <th>Email</th>
                      <th ></th>
                     
                    </tr>
                  </thead>
                  <tbody id="vendors">
                   @foreach($vendors as $vendor)
                     <tr>
                     <td> {{$vendor['id']}} </td>
                     <td> {{$vendor['name']}} </td>
                     <td> {{$vendor['userName']}} </td>
                     <td> 
                      {{ $vendor['native_language']}}
                    </td>
                    <td> 
                      {{$vendor['email'] }}
                    </td>
                   
                   
                   
                    <td> 
                      <a href="{{route('management.view-vendor',$vendor['id'])}}"> 
                       <button type="buton" class="btn btn-success"> View </button>
                       </a>  
                      
                       <button id="{{$vendor['id']}}" type="buton" class="btn btn-danger deleteVendor"> Delete </button>
                       </a>       
                     </td>
                     </tr>
                   @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            
            </div>
       <br>  <br>  <br>  <br>
      <!-- /.card -->
     
    </section>
    <!-- /.content -->
  </div>

@section('script')

<!-- DataTables  & Plugins -->
<script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/jszip/jszip.min.js')}}"></script>
<script src="{{asset('plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{asset('plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>




<script>
$(function () {
  /// data table
  $("#myTable").DataTable({
      "responsive": true, "lengthChange": true, "autoWidth": true,"paging": true, "searching": true,
      "ordering": false,"info": true,
  });
  
 /*  // filter status  
 url = window.location.href;
 splitURL = url.split('/');
 type = splitURL[splitURL.length - 1];
 
 $("#vendor_type option[id="+type+"]").attr("selected", "selected");
*/
$('.deleteVendor').click(function(){
  $vendorId = $(this).attr('id');
 var url = "{{ route('management.delete-vendor','id' )}}";
 url = url.replace('id', $vendorId);
  swal({
        title: "Are you sure?",
        text: "You will not be able to recover this data!",
        type: "warning",
        
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
          if (willDelete) {
            $.ajax({
        url:url,
        type: 'POST',
        dataType: 'json',
        contentType: false,
        processData: false,
        data: {vendorId: $vendorId},
        //  category_id: category_id,
        
        success:function(response) {
          if(response){
              //this.reset();
               //console.log(response) 
              swal("Done! Deleted Successfuly", {
              icon: "success"
            }).then((ok) =>{
             location.reload();
            }) 
           }
        },
        error: function(data) { 
            console.log(data);
           }
      })           
          } else {
            swal("Your data is safe!");
          }
        });
}); 


});

</script>
@endsection     
@endsection    
