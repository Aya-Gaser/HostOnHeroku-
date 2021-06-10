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
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">All Projects</li>
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
      <!-- Default box -->
      <div class="card" style="padding:15px;">
             
      <div class="card-header">
      
                <div class="card-tools form-group float-right row" style="">
               

                  <select onchange="window.location.href=this.value;" class="browser-default custom-select" id="project_status" style="width:150px;">
                   <option id="pending" value="{{ route('management.view-allProjects', 'pending') }}">  Pending </option> 
                    <option id="progress" value="{{ route('management.view-allProjects', 'progress') }} "> In progress </option>
                   <option id="Completed" value="{{ route('management.view-allProjects', 'Completed') }} "> Completed </option>
                   <option id="all" value="{{ route('management.view-allProjects', 'all') }}"> ALL </option>
                  </select>
                 </div> 
      <h5 style="text-transform:capitalize;"> {{$type}} Projects </h5>            
                 </div>  
         <br>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" id="myTable-wraper">
                <table class="table table-hover" id="myTable">
                  <thead>
                    <tr>
                    
                      <th>ID</th>
                      <th>Name</th>
                      <th>Created on</th>
                      <th>Type</th>
                      <th>Status</th>
                      <th ></th>
                     
                    </tr>
                  </thead>
                  <tbody id="projects">
                   @foreach($projects as $project)
                     <tr>
                     <td> {{str_pad($project->id, 4, "0", STR_PAD_LEFT )}} </td>
                     <td> {{$project['name']}} </td>
                    
                     <td> 
                      {{ UTC_To_LocalTime($project['created_at'], Auth::user()->timezone) }}
                    </td>
                    <td> 
                      {{$project['type'] }}
                    </td>
                   
                   
                    <td> {{$project['status']}} </td>
                    <td> 
                      <a href="{{route('management.view-project', $project['id'])}}"> 
                       <button type="buton" class="btn btn-success"> View </button>
                       </a>       
                     </td>
                     </tr>
                   @endforeach
                  
                     
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            
            </div>
       <br>  <br> 
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

  /// data table
  $("#myTable").DataTable({
      "responsive": true, "lengthChange": true, "autoWidth": true,"paging": true, "searching": true,
      "ordering": false,"info": true,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#myTable_wrapper .col-md-6:eq(0)');
  
   // filter status  
 url = window.location.href;
 splitURL = url.split('/');
 status = splitURL[splitURL.length - 1];
 
 $("#project_status option[id="+status+"]").attr("selected", "selected");

</script>
@endsection     
</body>
</html>
@endsection
