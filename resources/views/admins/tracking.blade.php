
@extends('admins.layouts.app')

@section('content')

@section('style')
<style>
.table td, .table th{
  padding:5px;
 
  
}
td{
  white-space: normal;
 /* word-break: break-all; */
}

table{
  height:170px;
}
th{
  height:70px;
}
.deadline{
  word-break:keep-all;
}
.translation{
  background-color:#d96c3d;
}
.dtp{
  background-color:#ca3d54;
}
.editing{
  background-color:#3c6e65;
}
.table{
  padding:0;
}
</style>
@endsection

@section('content')  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Projects Tracking</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('management.dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active"> Projects Tracking  </li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
    
      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title"> Ordered By Clients Deadline </h3>
        </div>
        <div class="card-body ">
          @foreach($wos as $wo)
          <div class="card collapsed-card">
            <div class="card-header"  style="background-color: #549c36; color:white;">
              <div class="card-tools">
                <button type="button" style="color:white; font-size:20px;" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-plus"></i>
                </button>
              </div>
                <div class="row" style="font-size:18px;">
                  <p class="col-md-1"> ID :  {{$wo->id}} </p>
                  <p class="col-md-2"> Client ID : {{$wo->client_id}} </p>
                  <p class="col-md-3"> Deadline :
                  {{ UTC_To_LocalTime($wo->deadline, Auth::user()->timezone)}} </p>
                  <p class="col-md-2">  {{$wo->from_language}} ▸ {{$wo->to_language}}  </p>
                  <p class="col-md-2"> Created By : {{App\User::find($wo->created_by_id)->name}} </p>
                  <p class="col-md-2"> 
                   <a href=" {{route('management.view-wo',$wo->id)}}"> 
                     <button type="button" class="btn" style="background-color:#343a40;color:white;"> VIEW FULL WO </button>
                   </a>
                  </p>

                </div>
            
          </div>
            <div class="card-body ">
           
              
            <div class="row">  
                @foreach($wo->projects as $project)
                
                   @foreach($project->projectStage as $stage)
                  
                     <table class="table table-bordered col-md-2 stage" width="100%">
                     <tr>
                      <td colspan="3" style="text-align:center;color:white;" class="{{$stage->type}}">  {{$stage->type}}  </td>
                      </tr> 
                      <tr> 
                        <th width="33%"> vendor </th>  <th class="deadline" width="45%"> Deadline </th>
                          <th width="22%" > Accepted Delivery </th>
                      </tr>
                      <tr> 
                        <td>@if(App\User::find($stage->vendor_id)) {{App\User::find($stage->vendor_id)->name}}
                             @else  <span clas="text-danger">UNaccepted</span>
                             @endif 
                              </td>  
                        <td class="deadline"> {{date('d/m/Y H:i', strtotime($stage->deadline))}} </td>
                        <td>{{$stage->accepted_docs}} OF {{$stage->required_docs}}  </td>
                       
                      </tr>
                      </table>
                      
                      @endforeach
                      <table class="table table-bordered col-md-2" style="background-color: #ccc; height:170px;">
                     <tr>
                      <td colspan="2" style="text-align:center; height:37px;">  Proof/Finalization  </td>
                      </tr> 
                     
                      <tr> 
                        <th width="50%"> Finalizier </th> 
                         <th width="50%">  Finalized Files </th>
                      </tr>
                     
                      <tr> 
                        <td> </td> 
                       
                         <td > {{count($project->finalizedFile)}}  </td> 
                        
                      </tr>
                    
                      </table>

                  @endforeach
                      </div>
             
            </div>
          
           </div>  
           @endforeach 
            
           </div>
        
          
        
        
        <!-- /.card-body -->
        </div> 
      <!-- /.card -->
      
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

 
@endsection
