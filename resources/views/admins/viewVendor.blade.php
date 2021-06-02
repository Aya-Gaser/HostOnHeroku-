@extends('admins.layouts.app')

@section('content') 

@section('style')
<style>
td{
  white-space: normal;
  word-break: break-all;
}

</style>
@endsection

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
              <li class="breadcrumb-item active">Vendor Information</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
     @php $deliveryId=0; @endphp
    
      <div class="row">
      <div class="col-md-10">
            <div class="card card-success shadow-sm">
              <div class="card-header">
                <h3 class="card-title">Vendor Information </h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
                </div>
             
                <div class="card-body">
             <p class="data"> <Span class="head"> ID: </Span>{{str_pad($vendor->id, 4, "0", STR_PAD_LEFT )}} </p>
              <p class="data"> <Span class="head">Name: </Span>{{$vendor->name}} </p>
              <p class="data"> <Span class="head"> User Name: </Span>{{$vendor->userName}} </p>
              <p class="data"> <Span class="head"> Native Language: </Span>{{$vendor->native_language}} </p>
              <p class="data"> <Span class="head"> Email: </Span>{{$vendor->email}} </p>
              <p class="data"> <Span class="head"> Timezone: </Span>{{$vendor->timezone}} </p>
              <p class="data"> <Span class="head"> Birth Date: </Span>  {{$vendor->birthdate}} </p>
              <p class="data"> <Span class="head"> Created on: </Span> 
             {{ UTC_To_LocalTime($vendor->created_at, Auth::user()->timezone)}}
                </p> 
                <p class="data"> <Span class="head">Password: </Span> 
               <span id="password">{{ decrypt($vendor->visible) }} </span>
               <span id="showPass" style="cursor:pointer; color:red;">  <i class="fas fa-eye"></i> </span>
                </p>
              <p>
               
                       <button id="deleteVendor" type="buton" class="btn btn-danger"> Delete </button>
                     
                 </p> 
              
              </div>
              </div>
              <!-- /.card-header -->
              <div class="card col-md-12">
              <div class="card-body">
            
                          <div class="card-header">
                            <h5> Vendor Projects  </h5>
                          </div>
                          <div class="card-body">
                          <div class="table-responsive">
                                 <table class="table table table-striped" id="myTable">
                                    <thead>
                                        <tr>
                                        
                                        <th width="10%">ID</th>
                                        <th width="15%">Name</th>
                                        <th width="20%">Created on</th>
                                        <th width="15%">Type</th>
                                        <th width="15%">Role</th>
                                        <th width="13%">Status</th>
                                        <th width="15%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                   
                                    @foreach($vendorStages as $stage)
                                     <tr> 
                                       <td>{{str_pad($stage->project_id, 4, "0", STR_PAD_LEFT )}}  </td>
                                       <td> {{App\projects::find($stage->project_id)->name}} </td>
                                       <td> 
                                       {{ UTC_To_LocalTime($stage->created_at, Auth::user()->timezone) }} 
                                       </td>
                                       <td> {{App\projects::find($stage->project_id)->type}} </td>
                                       <td> {{$stage->type}} </td>
                                       <td> {{$stage->status}} </td>
                                       <td> 
                                        <a href="{{route('management.view-project', $stage->project_id )}}"> 
                                          <button type="buton" class="btn btn-success"> View </button>
                                        </a>  
                                       </td>
                                     </tr>
                                     @endforeach
                                    </tbody>
                                  </table>
                          </div>        
                                    
                          </div>
                        </div>  
                     
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
           
                      
            
              <!-- /.card-body -->
          
             

             
          <!--/.col (left) -->
          <!-- right column -->
        
          <!--/.col (right) -->
        </div>

        <!-- /.row -->
      </div><!-- /.container-fluid -->
     
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
  $('#password').fadeOut();
   // $('#modal').fadeOut()
   $("#myTable").DataTable({
      "responsive": true, "lengthChange": true, "autoWidth": true,"paging": true, "searching": true,
      "ordering": false,"info": true,
    });
 
 $('#showPass').click(function(){
   // $('#password').fadeIn();
    var x = document.getElementById("password");
    if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
 });

 $('#deleteVendor').click(function(){
 
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
        url: "{{ route('management.delete-vendor', $vendor->id)}}",
        type: 'POST',
        dataType: 'json',
        contentType: false,
        processData: false,
       
        //  category_id: category_id,
        
        success:function(response) {
          if(response){
              //this.reset();
               //console.log(response) 
              swal("Done! Deleted Successfully", {
              icon: "success"
            }).then((ok) =>{ 
              window.location.href = "{{route('management.view-allVendors' )}}";
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

