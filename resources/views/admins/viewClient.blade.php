
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
              <li class="breadcrumb-item active">client Information</li>
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
            <div class="card card-success shadow-sm">
              <div class="card-header">
                <h3 class="card-title">Client Information </h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
                </div>
             
                <div class="card-body">
             <p class="data"> <Span class="head"> ID: </Span>{{$client->id}} </p>
              <p class="data"> <Span class="head">Name: </Span>{{$client->name}} </p>
              <p class="data"> <Span class="head">Number: </Span>{{$client->code}} </p>

              <p class="data"> <Span class="head"> Created on: </Span> 
             {{ UTC_To_LocalTime($client->created_at, Auth::user()->timezone)}}
                </p>
               <p>
              
                  <button id="deleteClient" type="buton" class="btn btn-danger"> Delete </button>
                      
                 </p>      
              
              </div>
              </div>
              <!-- /.card-header -->
              <div class="card col-md-12">
              <div class="card-body">
            
                          <div class="card-header">
                            <h5> Client WOs  </h5>
                          </div>
                          <div class="card-body">
                          <div class="table-responsive">
                                 <table class="table table table-striped" id="myTable">
                                    <thead>
                                        <tr>
                                        
                                        <th width="10%">ID</th>
                                        <th width="20%">Created on</th>
                                        <th width="20%">Deadline</th>
                                        <th width="13%">Status</th>
                                        <th width="15%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                   
                                    @foreach($client->Wo as $wo)
                                     <tr>
                                       <td> {{$wo->id}} </td>
                                       <td> 
                                       {{ UTC_To_LocalTime($wo->created_at, Auth::user()->timezone) }} 
                                       </td>
                                       <td> 
                                       {{ UTC_To_LocalTime($wo->deadline, Auth::user()->timezone) }} 
                                        </td>
                                       <td> {{$wo->status}} </td>
                                       <td> 
                                        <a href="{{route('management.view-wo',$wo->id)}}"> 
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
   // $('#modal').fadeOut()
   $("#myTable").DataTable({
      "responsive": true, "lengthChange": true, "autoWidth": true,"paging": true, "searching": true,
      "ordering": false,"info": true,
    });
  
$('#deleteClient').click(function(){
 
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
       url: "{{ route('management.delete-client', $client->id)}}",
       type: 'POST',
       dataType: 'json',
       contentType: false,
       processData: false,
      
       //  category_id: category_id,
       
       success:function(response) {
         if(response){
             //this.reset();
              //console.log(response) 
             swal("Done! Deleted Successfuly", {
             icon: "success"
           }).then((ok) =>{ 
             window.location.href = "{{route('management.view-allClients' )}}";
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