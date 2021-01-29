
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
              <li class="breadcrumb-item active">All Clients</li>
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


          <div class="card">
              <div class="card-header">
                  <h5> Add New client</h5>      
              </div>
              <div class="card-body">
              <form action="{{route('management.create-client')}}" method="post" enctype="multipart/form-data">
              @csrf
     
                
                <div class="row">  
                   
                <div class="form-group col-md-6">
                   <label for="exampleInputEmail1">code</label>
                    <input type="text" class="form-control" name="code"  placeholder="">
                 </div>
                 <div class="form-group col-md-6">
                   <label for="exampleInputEmail1">Name</label>
                    <input type="text" class="form-control" name="name" placeholder="">
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
      <div class="card" style="padding:15px;">
             
      <div class="card-header">
      
                <div class="card-tools form-group float-right row" style="">
               
                 </div> 
                 <h5> All clients </h5>            
                 </div>  
           <br>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" id="myTable-wraper">
                <table class="table table-hover" id="myTable">
                  <thead>
                    <tr>
                    
                      <th>ID</th>
                      <th>code</th>
                      <th>Name</th>
                      <th>Created at</th>
                      <th >Total Projects </th>
                     
                    </tr>
                  </thead>
                  <tbody id="clients">
                   @foreach($clients as $client)
                     <tr>
                     <td> {{$client['id']}} </td>
                     <td> {{$client['code']}} </td>
                     <td> {{$client['name']}} </td>
                     <td> 
                      {{ $client['created_at']}}
                    </td>
                    <td> 
                      {{count($client->Wo)}}
                    </td>
                   
                   
                   
                    <td> 
                      <a href="{{route('management.view-client',$client->id)}}"> 
                       <button type="buton" class="btn btn-success"> View </button>
                       </a>      

                        <a href="{{route('management.delete-client',$client->id)}}"> 
                       <button type="buton" class="btn btn-danger"> Delete </button>
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
  /// data table
  $("#myTable").DataTable({
      "responsive": true, "lengthChange": true, "autoWidth": true,"paging": true, "searching": true,
      "ordering": false,"info": true,
  });
  
 /*  // filter status  
 url = window.location.href;
 splitURL = url.split('/');
 type = splitURL[splitURL.length - 1];
 
 $("#client_type option[id="+type+"]").attr("selected", "selected");
*/
});

</script>
     
@endsection
@endsection