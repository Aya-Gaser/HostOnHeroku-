@extends('admins.layouts.app')

@section('content')
@section('style')
<style>
.card{
  padding:15px;
}
.card-header{
  margin-bottom:10px;
}
.card-title{
  font-size:25px;
}

</style>
@endsection
</head>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Work Orders</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('management.dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active">All WO</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card card-danger">
        <div class="card-header">
          <h2 class="card-title">Pending WO</h2>
           


          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
           
          </div>
        </div>
        <div class="card-body p-0 table-responsive">
          <table class="table table-striped projects" id="pending">
              <thead>
                  <tr>
                      <th style="width: 1%">
                          #
                      </th>
                     
                      <th style="width: " >
                         Client Number
                      </th>
                      <th style="width: ">
                      Deadline
                      </th>
                      <th style="width: ">
                      Language
                      </th>
                      <th style="width:  " >
                        Created on
                      </th>
                      <th style="width:">
                     
                      </th>
                  </tr>
              </thead>
              <tbody id="pending_wo">
             @foreach ($allPending_wo as $Pending_wo )
              <tr>
                      <td>
                      {{str_pad($Pending_wo['id'], 4, "0", STR_PAD_LEFT )}}
                      </td>
                     
                      <td>
                      @if(App\client::find($Pending_wo['client_id']))
                      {{App\client::find($Pending_wo['client_id'])->code}}
                      @else 
                      {{$Pending_wo['client_id']}} - <span class="text-danger"> DELETED </span>
                      @endif
                      </td>
                      <td>
                      {{ UTC_To_LocalTime($Pending_wo['deadline'], Auth::user()->timezone)}}
                    
                      </td>
                      <td>
                         
                      {{$Pending_wo['from_language']}} ▸ {{$Pending_wo['to_language']}}
                      </td>
                      <td>
                      {{ UTC_To_LocalTime($Pending_wo['created_at'], Auth::user()->timezone)}}
                   
                         </td>
                   
                      <td class="project-actions text-right">
                   
                     <a class="btn btn-primary btn-sm" href=" {{route('management.view-wo',$Pending_wo['id'])}}">
                         <i class="fas fa-folder">
                         </i>
                       View
                     </a>
                                                
                      </td>
                      @endforeach
                  </tr>
        
              </tbody>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
      <br>  <br>  <br>  
      <!-- /.card -->
      <div class="card card-success">
        <div class="card-header">
          <h3 class="card-title">Handled WO</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
           
          </div>
        </div>
        <div class="card-body p-0 table-responsive">
          <table class="table table-striped projects" id="completed">
              <thead>
                  <tr>
                      <th style="width: 1%">
                          #
                      </th>
                     
                      
                      <th style="width: " >
                         Client Number
                      </th>
                      <th style="width: ">
                      Deadline
                      </th>
                      <th style="width: ">
                      Language
                      </th>
                      <th style="width: " >
                        Created on
                      </th>
                      <th style="width:">
                     
                      </th>
                  </tr>
              </thead>
              <tbody>
              @foreach ($allCompleted_wo as $completed_wo )
              <tr>
                      <td>
                    
                     {{str_pad($completed_wo['id'], 4, "0", STR_PAD_LEFT )}}
                      </td>
                    
                      <td>
                      @if(App\client::find($completed_wo['client_id']))
                      {{App\client::find($completed_wo['client_id'])->code}}
                      @else 
                      {{$completed_wo['client_id']}} - <span class="text-danger"> DELETED </span>
                      @endif
                      
                      </td>
                      <td>
                      {{ UTC_To_LocalTime($completed_wo['deadline'], Auth::user()->timezone)}}
                     
                      </td>
                      <td style="text-align:center;">
                         
                      {{$completed_wo['from_language']}} ▸ {{$completed_wo['to_language']}}
                      </td>
                      <td>
                      {{ UTC_To_LocalTime($completed_wo['created_at'], Auth::user()->timezone)}}   
                     
                         </td>
                         <td class="project-actions text-right">
                    
                          <a class="btn btn-primary btn-sm" href=" {{route('management.view-wo',$completed_wo['id'])}}">
                              <i class="fas fa-folder">
                              </i>
                            View
                          </a>
                      </td>
                      @endforeach
                 
                  
              </tbody>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
    </section>
    <!-- /.content -->


</div>
<!-- ./wrapper -->

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
  $("#pending").DataTable({
      "responsive": true, "lengthChange": true, "autoWidth": true,"paging": true, "searching": true,
      "ordering": true,"info": true,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#pending_wrapper .col-md-6:eq(0)');

    $("#completed").DataTable({
      "responsive": true, "lengthChange": true, "autoWidth": true,"paging": true, "searching": true,
      "ordering": true,"info": true,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#completed_wrapper .col-md-6:eq(0)');
  
});
 </script>   
@endsection

@endsection

