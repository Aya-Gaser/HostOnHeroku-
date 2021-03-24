
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
.vendor{
  background-color:#d96c3d;
}
.editing{
  background-color:#ca3d54;
}
.proof{
  background-color:#3c6e65;
}
.table{
  padding:0;
}
.no-padding{
  padding:0px;
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
      
          @foreach($wos as $wo)
          <div class="card ">
            <div class="card-header no-padding"  style="padding:10px 0px 0px 10px; background-color: #549c36; color:white;">
             
                <div class="row" style="font-size:18px;">
                  <p class="col-md-1"> ID :  {{$wo->id}} </p>
                  <p class="col-md-2"> Client ID : {{$wo->client_id}} </p>
                  <p class="col-md-3"> Deadline :
                  {{ UTC_To_LocalTime($wo->deadline, Auth::user()->timezone)}} </p>
                  <p class="col-md-2">  {{$wo->from_language}} ▸ {{$wo->to_language}}  </p>
                  <p class="col-md-2"> Created By : {{App\User::find($wo->created_by)->userName}} </p>
                  <p class="col-md-2"> 
                   <a href=" {{route('management.view-wo',$wo->id)}}"> 
                     <button type="button" class="btn" style="background-color:#343a40;color:white;"> View WO Details </button>
                   </a>
                  </p>

                </div>
               </div> 
               <div class="card-body no-padding">
               @foreach($wo->woTasksNeeded as $task)
               
                <div class="card card-primary collapsed-card">
                <div class="card-header"  style="padding:8px 10px 0px 7px; color:white;">
                  <div class="card-tools">
                    <button type="button" style="color:white; font-size:20px;" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                      <i class="fas fa-plus"></i>
                    </button>
                    </div>
                    <div class="row">
                    <p class="col-md-1 text-dark font-weight-bold" > Task # {{$loop->iteration}}  </p>
                    <p class="col-md-2"> Type :  {{$task->type}} </p>
                  <p class="col-md-2"> Word Count : {{$task->client_wordsCount}} </p>
                  <p class="col-md-2"> Unit : {{$task->client_rateUnit}}
                  <p class="col-md-2"> Finalzed Files : {{count($task->proofed_clientFile)}} of {{count($wo->woSourceFiles)}}   </p>
                  <p class="col-md-2"> Status : {{$task->status}}

                 </div>
                 <div class="row">
                 <p class="col-md-2"> Jobs in Task : {{count($task->project)}}   </p>
                 @foreach($task->project as $project)
                 <p class="col-md-3"> Job #{{$loop->iteration}} Status : {{$project->status}}   </p>
                 @endforeach
                 </div>
                </div>   
                <div class="card-body "> 
                <div class="row">  
                @foreach($task->project as $project)
                
                   @foreach($project->projectStage as $stage)
                  
                     <table class="table table-bordered col-md-2 stage " width="100%">
                     <tr>
                      <td colspan="3" style="text-align:center;color:white;" class="vendor">  {{$stage->type}}  </td>
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
                        <td>{{$stage->accepted_docs}} of {{$stage->required_docs}}  </td>
                       
                      </tr>
                      </table>
                      
                      @endforeach
                  @if($task->has_proofAndFinalize && $project->type != 'Dtp')   
                   <!-- *********** PROJECT MANAGER EDITING ************-->
                   <table class="table table-bordered col-md-2 " style=" height:170px;">
                     <tr>
                      <td colspan="2" style="text-align:center; height:37px; color:white" class="editing">  Editing (Projects Manager)  </td>
                      </tr> 
                     
                      <tr> 
                        <th width="100%"> Edited Files </th> 
                       
                      </tr>
                      <tr> 
                         <td>{{count($project->project_sourceFile_readyToProof)}} of {{count($project->project_sourceFile)}} </td> 
                      </tr>
                    
                      </table>
                  @elseif($task->has_proofAndFinalize)   
                    <!-- *********** PROOFING ************-->
                    <table class="table table-bordered col-md-2 " style="height:170px;">
                      <tr>
                      <td colspan="2" style="text-align:center; height:37px; color:white" class="proof">  Proofing  </td>
                      </tr> 
                     
                      <tr> 
                        <th width="100%"> Proofed Files </th> 
                       
                      </tr>
                      <tr> 
                         <td>{{count($project->project_sourceFile_readyTofilnalize)}} of {{count($project->project_sourceFile)}} </td> 
                      </tr>
                    
                      </table>
                 @endif

                  @endforeach
                      </div>
                </div>  
                @endforeach
          </div>
              
           
             
            </div>
          
           </div>  
           @endforeach 
            
           
        
          
        
        
        <!-- /.card-body -->
        </div> 
      <!-- /.card -->
      
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

 
@endsection
