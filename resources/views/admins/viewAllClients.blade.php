
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

          @if(Auth::user()->can('create-client'))
          <div class="card">
              <div class="card-header">
                  <h5> Add New client</h5>      
              </div>
              <div class="card-body">
              <form action="{{route('management.create-client')}}" method="post" enctype="multipart/form-data">
              @csrf
     
                
                <div class="row">  
                   
                <div class="form-group col-md-6">
                   <label for="exampleInputEmail1">Number</label>
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
     @endif     
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
                    
                      <th>Number</th>
                      <th>Name</th>
                      <th>Created on</th>
                      <th >Total Projects </th>
                      <th></th>
                     
                    </tr>
                  </thead>
                  <tbody id="clients">
                   @foreach($clients as $client)
                     <tr>
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

                     
                       <button id="{{$client->id}}" type="buton" class="btn btn-danger deleteClient"> Delete </button>
                            
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
 
 $("#client_type option[id="+type+"]").attr("selected", "selected");
*/
$('.deleteClient').click(function(){
  $clientId = $(this).attr('id');
 var url = "{{ route('management.delete-client','id' )}}";
 url = url.replace('id', $clientId);
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
        data: {clientId: $clientId},
        //  category_id: category_id,
        
        success:function(response) {
          if(response){
              //this.reset();
               //console.log(response) 
              swal("Done! Deleted Successfully", {
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