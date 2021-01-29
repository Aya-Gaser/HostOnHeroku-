
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
     @php $deliveryId=0; @endphp
    
      <div class="row">
      <div class="col-md-10">
            <div class="card card-success shadow-sm">
              <div class="card-header">
                <h3 class="card-title">client Information </h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
                </div>
             
                <div class="card-body">
             <p class="data"> <Span class="head"> ID : </Span>{{$client->id}} </p>
              <p class="data"> <Span class="head">Name : </Span>{{$client->name}} </p>
             
              <p class="data"> <Span class="head"> Created at : </Span> 
             {{ UTC_To_LocalTime($client->created_at, Auth::user()->timezone)}}
                </p>
               <p>
               <a href="{{route('management.delete-client',$client->id)}}"> 
                       <button type="buton" class="btn btn-danger"> Delete </button>
                       </a>   
                 </p>      
              
              </div>
              </div>
              <!-- /.card-header -->
              <div class="card col-md-12">
              <div class="card-body">
            
                          <div class="card-header">
                            <h5> client Projects  </h5>
                          </div>
                          <div class="card-body">
                          <div class="table-responsive">
                                 <table class="table table table-striped" id="myTable">
                                    <thead>
                                        <tr>
                                        
                                        <th width="10%">ID</th>
                                        <th width="15%">Name</th>
                                        <th width="20%">Created at</th>
                                        <th width="15%">Type</th>
                                        <th width="13%">Status</th>
                                        <th width="15%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                   
                                    @foreach($client->Wo as $project)
                                     <tr>
                                       <td> {{$project->id}} </td>
                                       <td> {{$project->name}} </td>
                                       <td> 
                                       {{ UTC_To_LocalTime($project->created_at, Auth::user()->timezone) }} 
                                       </td>
                                       <td> {{App\projects::find($project->project_id)->type}} </td>
                                       <td> {{$project->type}} </td>
                                       <td> {{$project->status}} </td>
                                       <td> 
                                        <a href="{{route('management.view-project',$project->id)}}"> 
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
<script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="../../plugins/jszip/jszip.min.js"></script>
<script src="../../plugins/pdfmake/pdfmake.min.js"></script>
<script src="../../plugins/pdfmake/vfs_fonts.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>


<script>
$(function () {
   // $('#modal').fadeOut()
   $("#myTable").DataTable({
      "responsive": true, "lengthChange": true, "autoWidth": true,"paging": true, "searching": true,
      "ordering": false,"info": true,
    });
  
 
});



</script>

@endsection     

@endsection