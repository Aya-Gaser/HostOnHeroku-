
@extends('admins.layouts.app')

@section('content')  
@section('style')
<link href="{{asset('bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" media="screen">
<style>

</style>
@include('layouts.partials._file_input_plugin_style')
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
              <li class="breadcrumb-item active">All Vendors Invoices</li>
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
          <div class="card " style="padding:15px;">
                    
            <div class="card-body">
              <form id="filterInvoices-form" action="{{route('management.view-filterd-vendorInvoices') }}" method="post" enctype="multipart/form-data">
                @csrf
              <div class="row"> 
              <div class="form-group col-md-4">
                    <label class="form-control-label" for="project_type">Vendor</label>
                    <select class="select2 form-control" data-live-search="true" name="vendor" id="vendor">
                    <option value="" {{selectInputVal(null,isset($vendor) ? $vendor : null,null)}}>Select</option>
                    @foreach($vendors as $vendor2)
                    <option value="{{$vendor2->id}}" {{selectInputVal(null,isset($vendor) ? $vendor : null,$vendor2->id)}}>
                    {{$vendor2->name != null ? $vendor2->name : $vendor2->username}}
                     </option>
                    @endforeach
                    </select>
                  </div>
                  <div class="form-group col-md-4" style="">
                    <label for="exampleInputFile">From  </label>
                    <input type="date" name="fromDate" class="form-control" 
                    value="{{isset($fromDate) ? $fromDate :old('fromDate')}}" size="16" >
                 </div>
                 <div class="form-group col-md-4" style="">
                    <label for="exampleInputFile">To </label>
                    <input type="date" name="toDate" class="form-control" 
                    value="{{isset($toDate) ? $toDate :old('toDate')}}" size="16" >
                 </div>
            </div> 
            
               <div class="card-footer" style="text-align:right;">
                  <button type="submit" class="btn btn-primary">Search</button>
                </div>
        </form>
            </div> 
         </div>      
            <!-- Default box -->
            <div class="card card-success" style="padding:15px;">
                    
            <div class="card-header">
      
                <div class="card-tools form-group float-right row" style="">
               
                 </div> 
                 <h5> All Vendor Invoices </h5>            
                 </div>  
           <br>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" id="myTable-wraper">
                <table class="table table-hover" id="myTable">
                  <thead>
                    <tr>
                    
                      <th>ID</th>
                      <th>Created on</th>
                      <th>Vendor</th>
                      <th>Total</th>
                      <th>Status</th>
                      <th ></th>
                     
                    </tr>
                  </thead>
                  <tbody id="vendors">
                   @foreach($vendorInvoices as $invoice)
                     <tr>
                     <td> {{$invoice['id']}} </td>                    
                     <td> 
                      {{ UTC_To_LocalTime($invoice['created_at'], Auth::user()->timezone) }}
                    </td>
                    <td> 
                      {{App\User::find($invoice['vendor_id'])->name }}
                    </td>
                   
                    <td> {{$invoice['total']}} </td>

                    <td> {{$invoice['status']}} </td>
                    <td> 
                      <a href="{{route('management.view-invoice', $invoice['id'])}}"> 
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
      "ordering": true,"info": true,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#myTable_wrapper .col-md-6:eq(0)');
  
    //Initialize Select2 Elements
    $('.select2').select2()

//Initialize Select2 Elements
$('.select2bs4').select2({
  theme: 'bootstrap4'
})

  bsCustomFileInput.init();
  $('select').selectpicker();

$(".date").datetimepicker({
        format: "dd-M-yy",
        autoclose: true,
        todayBtn: true,
        todayHighlight:true,
        minuteStep: 15,
   
    });
 /*  // filter status  
 url = window.location.href;
 splitURL = url.split('/');
 type = splitURL[splitURL.length - 1];
 
 $("#vendor_type option[id="+type+"]").attr("selected", "selected");
*/



});

</script>
@endsection     
@endsection    
