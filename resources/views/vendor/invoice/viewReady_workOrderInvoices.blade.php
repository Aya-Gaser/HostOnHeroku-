@extends('vendor.layouts.app')

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
              <li class="breadcrumb-item'}}"><a href="{{route('vendor.dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active"> Completed Projects</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
     
      <!-- /.card -->
      <div class="card" style="padding:15px;">
        <div class="card-header">
          <h3 class="card-title" style="font-weight:bold;"> Completed Projects
          </h3>

         
        </div>
        <br>
        <div class="card-body p-0">
        
          <div class="card-body table-responsive p-0" id="myTable-wraper">
            <table class="table table-hover text-nowrap" id="myTable">
                  <thead>
                    <tr>
                      <th> ID </th>
                      <th>Task</th>
                      <th>Status</th>
                     
                      <th> </th>

                    </tr>
                  </thead>
                  <tbody>
                  @foreach($stages as $stage)
                   <tr>
                    <td> {{ $stage['wo_id']}} </td>
                    <td> {{ $stage['type']}} </td>
                    <td> {{ $stage['status']}} </td>
                    <td> <button type="button" class="btn btn-success">
                     <a href="{{route('vendor.create-workInvoice', $stage['id'])}}" style="color:white;"> view </a>
                     </button> </td>
                   </tr>
                   @endforeach
                  </tbody>
                </table>
              </div>
        </div>
        <!-- /.card-body -->
      </div>
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
});


//$('#filter').val($('#bb')); 
//var x = {'undelivered':0,'pending':1,'accepted' :2, 'all' :3};
</script>

@endsection

@endsection

