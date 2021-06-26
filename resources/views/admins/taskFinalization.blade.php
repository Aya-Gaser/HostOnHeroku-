@extends('admins.layouts.app')

@section('content') 


@include('layouts.partials._file_input_plugin_style')
@section('style')
<style>


td{
  white-space: normal;
  word-break: break-all;
}

#modal-uploadFinalization .modal-content{
  overflow-y: scroll;
  height: 350px;
}

.card-body.p-0 .table tbody>tr>td:first-of-type{
  padding-left:10px;
}
.card-noPadding{
  padding:0px;
}
ul{
  padding-left:22px;
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
              <li class="breadcrumb-item active">Finalization Task</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
          <input type="hidden" value="" name="taskId" id="taskId">
          <input type="hidden" value="" id="complete" name="complete">

    
      <div class="row">
      <div class="col-md-10">
            <div class="card card-primary shadow-sm">
              <div class="card-header">
                <h3 class="card-title">Task Details </h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
                </div>
               
            <div class="card-body">
              <div class="row">
             <p class="data col-md-6"> <Span class="head"> WO ID: </Span>{{str_pad($task->wo_id, 4, "0", STR_PAD_LEFT )}} </p>
             <p class="data col-md-6"> <Span class="head"> Type: </Span>{{$task->type}} </p>

             <p class="data col-md-6"> <Span class="head"> Client: </Span>
             @if(App\client::find($task->WO['client_id']))
                {{App\client::find($task->WO->client_id)->code}} - {{App\client::find($task->WO->client_id)->name}}
                @else 
                {{$task->WO['client_id']}} - <span class="text-danger"> DELETED </span>
                @endif
             </p>   
             
             <p class="data col-md-6" > <Span class="head"> Language: </Span>{{$task->WO->from_language}} ▸ {{$task->WO->to_language}}</p>
              <p class="data col-md-6"> <Span class="head"> Created on: </Span>  {{ UTC_To_LocalTime($task->WO->created_at, Auth::user()->timezone) }} </p>
              <p class="data col-md-6 text-danger"> <Span class="head"> Deadline: </Span> {{UTC_To_LocalTime($task->WO->deadline, Auth::user()->timezone) }}</p>
              <p class="data col-md-6"> <Span class="head"> Client Instructions: </Span> {{$task->WO->client_instructions }}</p>
              <p class="data col-md-6"> <Span class="head"> General Instructions: </Span> {{$task->WO->general_instructions }}</p>
              <p class="data col-md-6"> <Span class="head"> Status: </Span>{{$task->status}} </p>
              <div class="col-md-6">
                @if($task->status != 'Completed')
                    
                    <button @if(!$allowComplete) disabled @endif type="button" id="{{$task->id}}" class="btn btn-success completeTask complete" > 
                            Finalization Completed &check;&check; </button>
                        </a> 
                    @else        
                        <button type="button" id="{{$task->id}}" class="btn btn-success completeStage reopen" > 
                            RE-OPEN Task</button>
                      
                      @endif  
                 </div>     
           </div>
            <div class="row"> 
              <div class="col-sm-6 col-md-6">
                    <div class="form-group">
                    <br>
                        <h4> Source Document(s) </h4>
                        <br>
                        
                            @forelse($source_files as $file)                                
                                <li class="text-primary">
                                <a href="{{asset('storage/'.$file['file'])}}"
                                       download="{{$file['file_name']}}">
                                        {{str_limit($file['file_name'],47)}}
                                    </a>
                                   
                                   
                                </li>
                                <div class="clearfix mb-2"></div>
                            @empty
                                <li class="text-danger">None</li>
                            @endforelse
                            <br>
                            
                           
                        </ul>
                    </div>
                </div>
              </div>
              <div class="row">
                <div class="card card-noPadding card-dark col-12">
                  <div class="card-header">
                    <h5 class="card-title"> Jobs In Task </h5>
                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                      </button>
                     
                    </div>
                  </div>  
                  <div class="card-body p-0 table-responsive">
                <table class="table table-striped table-sm table-bordered" 
                style="padding-left:5px;">
                 <thead>
                  <tr>
                  <th style="width: " >
                        #
                      </th>
                      <th style="width: " >
                         Working Files
                         <span class="text-success">  ▸▸▸ </span>
                           Proofed Document(s)  
                        </th>
                      <th style="width: ">
                       Instuctions
                      </th>
                      <th style="width: ">
                       Vendor
                      </th>
                      
                  </tr>
              </thead>
              <tbody>
             
             @foreach ($taskJobs as $project)
             
                <tr>
                  <td> {{str_pad($project->id, 4, "0", STR_PAD_LEFT )}} </td>
                  <td>
                   @foreach($project->project_sourceFile as $file)                                
                 
                   <ul>
                   
                        <li class="text-primary">
                        <p>
                        <a href="{{asset('storage/'.$file['file'])}}"
                                download="{{$file['file_name']}}">
                                {{str_limit($file['file_name'],30)}}
                            </a>
                              
                   <span class="text-success">  ▸▸▸ </span>
                 
                    @if($file->proofed_vendorFile->first())
                       
                        <a href="{{asset('storage/'.$file->proofed_vendorFile->first()->file)}}"
                                download="{{$file->proofed_vendorFile->first()->file_name}}">
                                {{str_limit($file->proofed_vendorFile->first()->file_name,30)}}
                            </a>
                            
                    @else
                      <span class="text-danger"> NONE </span>   
                  
                    @endif
                      </p>    
                     </li>
                     <div class="clearfix mb-2"></div>
                   </ul>
               
                  
                     @endforeach
                     </td>
                  <td>
                    <ul>
                      @foreach($project->projectStage as $stage)
                      <li>
                        {{$stage->instructions}}
                      </li>
                      @endforeach
                    </ul>  
                  </td>
                  <td>
                   @if($project->translator) 
                    {{$project->translator->name}}
                   @else
                    <span class="text-danger"> None Yet </span>
                   @endif
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
            <!-- /.card -->
           
            <div class="card card-success col-md-12">
              <div class="card-header">
                  <h5> Document(s) Finalization</h5>
               <div class="card-tools">
               <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-uploadFinalization">
                Upload Files
              </button>   
              </div>
              </div>
              <div class="card-body">
            
                          
                  <div class="table-responsive p-0">
                      <table class="table table table-striped ">
                        <thead>
                            <tr>

                            
                            <th width="33%">Proofed Client File </th>
                            <th width="33%">Projects Manager File</th>
                            <th width="33%" >Final Client File </th>
                            
                        
                            </tr>
                        </thead>
                        
                        <tbody>
                        <tr>
                          <td>
                          <ul>
                         @foreach($task->proofed_clientFile as $clientProofed)                        
                           
                           <li class="text-primary">
                            <a href="{{asset('storage/'.$clientProofed->file)}}"
                                download="{{$clientProofed->file_name}}">
                                {{str_limit($clientProofed->file_name,40)}}
                            </a>
                           
                            </li>
                          <div class="clearfix mb-2"></div>
                        
                         @endforeach
                           </ul>
                           </td>

                           <td>
                           <p>
                         @foreach($task->finalized_projectManagerFile as $projectManagerFile)                        
                         
                           <ul>
                           <li class="text-primary">
                            <a href="{{asset('storage/'.$projectManagerFile->file)}}"
                                download="{{$projectManagerFile->file_name}}">
                                {{str_limit($projectManagerFile->file_name,50)}}
                            </a>
                           
                            </li>
                           <div class="clearfix mb-2"></div>
                           </ul>
                         
                         @endforeach
                         </p> 
                           <p> 
                            
                            </p>
                          </td>

                           <td>
                           <p>
                         @foreach($task->finalized_clientFile as $clientFile)                        
                         
                           <ul>
                           <li class="text-primary">
                            <a href="{{asset('storage/'.$clientFile->file)}}"
                                download="{{$clientFile->file_name}}">
                                {{str_limit($clientFile->file_name,40)}}
                            </a>
                           
                            </li>
                           <div class="clearfix mb-2"></div>
                           </ul>
                         
                         @endforeach
                         </p> 
                        
                          </td>
                         
                         </tr>
                        </tbody>
                      </table>

   <!-- **************** send to vendor **************************************** -->
   

  <!-- *********************** end send to vendor ************************* -->  

                  </div>        
                                    
              </div>
          </div>
                      
            
              <!-- /.card-body -->
          
             

             
          <!--/.col (left) -->
          <!-- right column -->
        
          <!--/.col (right) -->
        </div>
<!-- /.modal -->


  <div class="row modal fade in" id="modal-uploadFinalization" style=" overflow-y:hidden; border:none; box-shadow:none; background-color:transparent;padding:auto;">
     
     <div class="modal-dialog col-md-12 center" style="max-width:750px;">
       <div class="modal-content">
         <div class="modal-header">
           <h4 class="modal-title">Upload Finalized Document(s) </h4>
           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
           </button>
         </div>
         <div class="modal-body">
         <form id="finalization-form" action="{{route('management.upload-finalizedFile', $task->id)}}" method="post" enctype="multipart/form-data">
              @csrf
              <div class="form-group ">
              <label class="form-control-label" for="project_type">project Manager File(s)
                    <span class="required">*</span>
                    </label>
                  <div class="file-loading">  
                  <input id="delivery_files" name="projectManager_file[]" 
                    class="kv-explorer " type="file" multiple required>  
                    </div>
              </div>
           
              <div class="form-group ">
              <label class="form-control-label" for="project_type">Client File(s)
                    <span class="required">*</span>
                    </label>
                  <div class="file-loading">  
                  <input id="delivery_files" name="client_file[]" 
                    class="kv-explorer " type="file" multiple required>  
                    </div>
              </div>
            <button id="submitFiles" type="submit" class="btn btn-primary" > 
              Upload </button>
        </form>  
         </div>
       </div>
       
       <!-- /.modal-content -->
     </div>
     <!-- /.modal-dialog -->

<!-- /.modal -->
        <!-- /.row -->
      </div><!-- /.container-fluid -->
     
    </section>
    <!-- /.content -->
  </div>
 
@section('script')

<script>
$(function () {
  bsCustomFileInput.init();
  
  $('#finalization-form').submit(function(e) {
    document.body.style.cursor='wait';  
  $('#submitFiles').attr('disabled', true)

  });
 /* 
$jobId = 0     
$sourceID = 0;
$('.proof').click(function(){
  $sourceID = $(this).attr('id');
  $('#sourceFileId').val($sourceID);
});
$('#uploadProof-form').submit(function(e) {
       e.preventDefault();
       let formData = new FormData(this);
 
        $.ajax({
        data: formData,
        url: "{{ route('management.store-proofingFiles') }}",
        type: 'POST',
        contentType: false,
           processData: false,
           success: (response) => {
             if (response) {
               this.reset();
               console.log(response) 
              swal("Done! Uploaded Successfully", {
              icon: "success"
            }).then((ok) =>{
              location.reload();
            }) 
           }
           },
           error: function(response){
              console.log(response);
              //  $('#image-input-error').text(response.responseJSON.errors.file);
           }
      
      })           
          
}); 
$('.sendToVendor').click(function(){
  $jobId = $(this).attr('id');
  $('#jobId').val($jobId);
});
$('#completeReview-form').submit(function(e) {
       e.preventDefault();
       let formData = new FormData(this);
 
        $.ajax({
        data: formData,
        url: "{{ route('management.send-reviewToVendor') }}",
        type: 'POST',
        contentType: false,
           processData: false,
           success: (response) => {
             if (response) {
               this.reset();
               console.log(response) 
              swal("Done! Sent Successfully", {
              icon: "success"
            }).then((ok) =>{
              location.reload();
            }) 
           }
           },
           error: function(response){
              console.log(response);
              //  $('#image-input-error').text(response.responseJSON.errors.file);
           }
      
      })           
          
}); 
*/
})

$('.complete').click(function(){
  $('#complete').val(1);
}); 

$('.completeTask').click(function(){
  document.body.style.cursor='wait';           

  $taskId = "{{$task->id}}";
  console.log($taskId)
  $('#taskId').val($taskId);
  //console.log($stageId);
  $.ajax({
        data: { taskId : $taskId,
          complete: 1},
        url: "{{ route('management.complete_reopen_task') }}",
        type: 'POST',
        dataType: 'json',
        //contentType: false,
        //   processData: false,
           success: (response) => {
              if(response){
              //this.reset();
               //console.log(response) 
              swal("Done Successfully", {
              icon: "success"
            }).then((ok) =>{
              location.reload();
            }) 
           }
             
            },
            error: function(data) { 
            console.log(data);
           }
  });
  
});
 
$('.reopen').click(function(){
  document.body.style.cursor='wait';           

  $.ajax({
        data: {taskId : "{{$task->id}}",
              complete : 0 },
        url: "{{route('management.complete_reopen_task') }}",
        type: 'POST',
        //contentType: false,
           //processData: false,
           success: (response) => {
             if(response){
              //this.reset();
               //console.log(response) 
              swal("Done Successfully", {
              icon: "success"
            }).then((ok) =>{
              location.reload();
            }) 
           }
             
            },
            error: function(data) { 
            console.log(data);
           }
  });
}); 

</script>
@include('layouts.partials._file_input_plugin_script')
@endsection
@endsection