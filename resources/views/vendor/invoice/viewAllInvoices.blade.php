@extends('vendor.layouts.app')

@section('content')


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>My Projects</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item'}}"><a href="{{route('vendor.dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active">my projects</li>
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
          <h3 class="card-title" style="font-weight:bold;"> Invoices
          </h3>

          <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                  <div class="card-tools form-group float-right" style="">
                  <select onchange="window.location.href=this.value;" class="browser-default custom-select" id="filter" style="width:150px;">
                   <option id="bb" value="{{ route('vendor.view-myProjects', 'Not delivered') }} "> Not Delivered </option>
                   <option value="{{ route('vendor.view-myProjects', 'pending') }} "> Pending </option> 
                   <option value="{{ route('vendor.view-myProjects', 'accepted') }} "> Completed </option>
                   <option value="{{ route('vendor.view-myProjects', 'all') }}"> ALL </option>
                  </select>
                 </div>  

                  
                  </div>
                </div>
        </div>
        <br>
        <div class="card-body p-0">
        
          <div class="card-body table-responsive p-0" id="myTable-wraper">
            <table class="table table-hover text-nowrap" id="myTable">
                  <thead>
                    <tr>
                      <th> ID </th>
                      <th>Date</th>
                      <th>Total</th>
                      <th>Status</th>
                     
                      <th> </th>

                    </tr>
                  </thead>
                  <tbody>
                  @foreach($invoices as $invoice)
                   <tr>
                    <td> {{ $invoice['id']}} </td>
                    <td> {{ $invoice['created_at']}} </td>
                    <td> {{ $invoice['total']}} </td>
                    <td> {{ $invoice['status']}} </td>
                    <td> <button type="button" class="btn btn-success">
                     <a href="{{route('vendor.view-vendorInvoice', $invoice['id'])}}" style="color:white;"> view </a>
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
var x = {'undelivered':0,'pending':1,'accepted' :2, 'all' :3};
</script>

@endsection

@endsection

