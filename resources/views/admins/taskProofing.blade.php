@extends('admins.layouts.app')

@section('content') 


@include('layouts.partials._file_input_plugin_style')
@section('style')
<style>


td{
  white-space: normal;
  word-break: break-all;
}

#modal-proof .modal-content{
  overflow-y: scroll;
  height: 450px;
}
#modal-sendToVendor .modal-content{
  height:300px;

}
#completeReview-div{
  display:none;
}
.card-body.p-0 .table tbody>tr>td:first-of-type{
  padding-left:10px;
}
.card-noPadding{
  padding:0px;
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
              <li class="breadcrumb-item active">Proofing Task</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
     @php $sourceFile=0; @endphp
    
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
             <p class="data"> <Span class="head"> WO ID: </Span>{{$task->wo_id}} </p>
             <p class="data" > <Span class="head"> Language: </Span>{{$task->WO->from_language}} ▸ {{$task->WO->to_language}}</p>
              <p class="data"> <Span class="head"> Created on: </Span>  {{ UTC_To_LocalTime($task->WO->created_at, Auth::user()->timezone) }} </p>
              <p class="data text-danger"> <Span class="head"> Deadline: </Span> {{UTC_To_LocalTime($task->WO->deadline, Auth::user()->timezone) }}</p>
              <p class="data"> <Span class="head"> Client Instructions: </Span> {{$task->WO->client_instructions }}</p>
              <p class="data"> <Span class="head"> General Instructions: </Span> {{$task->WO->general_instructions }}</p>

           
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
                  <td> {{$project->id}} </td>
                  <td>
                   <ul>
                   @forelse($project->project_sourceFile as $file)                                
                                <li class="text-primary">
                                <a href="{{asset('storage/'.$file['file'])}}"
                                       download="{{$file['file_name']}}">
                                        {{str_limit($file['file_name'],40)}}
                                    </a>
                                   
                                   
                                </li>
                                <div class="clearfix mb-2"></div>
                            @empty
                                <li class="text-danger">None</li>
                     @endforelse
                     </ul>
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
                              <h5> Files Editing & Proofing 
                                </h5>
              </div>
              <div class="card-body">
            
                          
                          <div class="table-responsive p-0">
                                 <table class="table table table-striped ">
                                    <thead>
                                        <tr>
                                        
                                        <th>Target File</th>
                                        <th >Edited File </th>
                                        <th>Vendor File </th>
                                      
                                        <th>Client File </th>
                                        <th > </th>
                                       
                                       
                                   
                                        </tr>
                              </thead>
                              <tbody>
                                @foreach($deliveries_edited as $jobFiles) 
                                <tr class="bg-dark"> 
                                   <td colspan="4">Job #{{$jobFiles->id}} Files</td>
                                   <td> 
                                   @if($jobFiles->status != 'reviewed')
                                    <button type="button" class="sendToVendor btn center" data-toggle="modal" data-target="#modal-sendToVendor"
                                     id="{{$jobFiles->id}}" style=" background-color:#eb6434; color:white;"> Send Files To Vendor </button>
                                   @else 
                                     <span class="text-success"> Files Sent To Vendor &check;&check; </span> 
                                   @endif
                                   </td>
                                </tr>  
                                    @foreach($jobFiles->project_sourceFile_readyToProof as $source_file)
                                      <tr>
                                                                              
                                       <td> <p>
                                       <a href="{{asset('storage/'.$jobFiles->lastAccepted_delivery[$source_file->id][0]->file)}}"
                                       download="{{$jobFiles->lastAccepted_delivery[$source_file->id][0]->file_name}}">
                                        {{str_limit($jobFiles->lastAccepted_delivery[$source_file->id][0]->file_name,50)}}
                                    </a>
                                       </p>
                                       <p>{{ UTC_To_LocalTime($jobFiles->lastAccepted_delivery[$source_file->id][0]->created_at,
                                             Auth::user()->timezone) }}
                                        </p>
                                       </td>

                                       <td>
                                       @if($source_file->editedFile )
                                       
                                       <p>
                                       <a href="{{asset('storage/'.$source_file->editedFile->file)}}"
                                       download="{{$source_file->editedFile->file_name}}">
                                        {{str_limit($source_file->editedFile->file_name,50)}}
                                    </a>
                                    </p> 
                                    
                                    @else 
                                          <p class="pending"> <b> SENT WITHOUT EDITING</b> </p> 
                                         
                                      @endif
                                   </td>
                                  
                                     @if(!$source_file->isReadyToFinalize) 
                                     <td></td> <td></td>  
                                      <td> 
                                      <button id="{{$source_file->id }}"
                                           type="button" class="proof btn btn-success" data-toggle="modal" data-target="#modal-proof">
                                       Proof
                                        </button>
                                       </td> 
                                        
                                        @else 
                                    <td>
                                     @foreach($source_file->proofed_vendorFile as $vendorFile)
                                      <p>
                                        <a href="{{asset('storage/'.$vendorFile->file)}}"
                                        download="{{$vendorFile->file_name}}">
                                          {{str_limit($vendorFile->file_name,50)}}
                                      </a>
                                      </p> 
                                      <p> <span class="text-success">Notes: </span>  {{$vendorFile->note}} </p>
                                     @endforeach
                                    </td>
                                    <td>
                                    @if($source_file->proofed_clientFile)
                                      @foreach($source_file->proofed_clientFile as $clientFile)
                                      <li>
                                        <a href="{{asset('storage/'.$clientFile->file)}}"
                                        download="{{$clientFile->file_name}}">
                                          {{str_limit($clientFile->file_name,50)}}
                                      </a>
                                      </li> 
                                      <p> <span class="text-success">Notes: </span>  {{$clientFile->note}} </p>
                                     @endforeach 
                                    @else 
                                    <p class="text-danger"> NONE </p>
                                    @endif
                                    </td>
                                   <td></td>
                                    @endif    
                                    
                                         
                                                                         
                                       </tr>
                                    @endforeach
                                @endforeach
                                   
                                    </tbody>
                                  </table>

   <!-- **************** send to vendor **************************************** -->
   

  <!-- *********************** end send to vendor ************************* -->  

                          </div>        
                                    
                          </div></div>
                      
            
              <!-- /.card-body -->
          
             

             
          <!--/.col (left) -->
          <!-- right column -->
        
          <!--/.col (right) -->
        </div>
<!-- /.modal -->


<div class="row modal fade in" id="modal-proof" style=" overflow-y:hidden; border:none; box-shadow:none; background-color:transparent;padding:auto;">
     
          <div class="modal-dialog col-md-12 center" style="max-width:750px;">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Upload Prooing Files </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
              <form method="post" id="uploadProof-form" enctype="multipart/form-data">
                @csrf
                <input type="hidden" value="" name="sourceFileId" id="sourceFileId">
                 <div class="row">   
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="form-control-label"
                      for="source_document">Vendor File </label>
                  
                      <div class="file-loading col-md-2">  
                        <input id="vendor_file" name="vendor_file[]"
                        class="kv-explorer" type="file" multiple>  
                        </div>
                    </div>
                  </div> 
                  <div class="form-group col-md-6">
                  <label class="form-control-label" for="client_rateValue1"> Notes</label>
                   <input name="vendor_file_note" type="text" class="form-control" placeholder="Notes for vendor"> 
                  </div>
                </div>

                <div class="row">   
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="form-control-label"
                      for="source_document">Client File </label>
                  
                      <div class="file-loading col-md-2">  
                        <input id="client_file" name="client_file[]"
                        class="kv-explorer" type="file" multiple >  
                        </div>
                    </div>
                  </div> 
                  <div class="form-group col-md-6">
                  <label class="form-control-label" for="client_rateValue1">Notes</label>
                   <input name="client_file_note" type="text" class="form-control" placeholder="Notes for Client File "> 
                  </div>
                </div>

              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" id='save' class="btn btn-success"> save
                </button> 
              </form>
              </div>
            </div>
            
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>
  <div class="row modal fade in" id="modal-sendToVendor" style=" overflow-y:hidden; border:none; box-shadow:none; background-color:transparent;padding:auto;">
     
     <div class="modal-dialog col-md-12 center" style="max-width:750px;">
       <div class="modal-content">
         <div class="modal-header">
           <h4 class="modal-title">Send Full Review To Vendor </h4>
           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
           </button>
         </div>
         <div class="modal-body">
         <form id="completeReview-form" action="" method="post" enctype="multipart/form-data">
         @csrf
           <div class="card-body">
           <input type="hidden" value="" name="jobId" id="jobId">
           <div class="row">
             <div class="form-group col-md-6">
               <label class="form-control-label" for="words_count">Quality Points<span
                   class="required">*</span></label>
               <input type="number" min="0" step="1" class="form-control" name="quality_points"
                value="" id="quality_points" required>

             </div>
             <div class="form-group col-md-6">
                   <label class="form-control-label" for="quality_points">MAX Quality Points<span
                       class="required">*</span></label>
                   <input type="number" min="0" class="form-control" name="maxQuality_points"
                   value="" id="maxQuality_points" required>

             </div>
           </div>   

    
       
             </div>
       <!-- /.card -->

       <div class="card-footer" id="submit_div">
             <button type="submit" class="btn btn-primary">Send</button>
           </div>
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
  
$jobId = 0     
$sourceID = 0;
$('.proof').click(function(){
  $sourceID = $(this).attr('id');
  $('#sourceFileId').val($sourceID);
});
$('#uploadProof-form').submit(function(e) {
       e.preventDefault();
       let formData = new FormData(this);
       //this.reset();
        $.ajax({
        data: formData,
        url: "{{ route('management.store-proofingFiles') }}",
        type: 'POST',
        contentType: false,
           processData: false,
           success: (response) => {
             if (response) {
               this.reset();
               //console.log(response) 
              swal("Done! Uploaded Successfuly", {
              icon: "success"
            }).then((ok) =>{
              location.reload();
            }) 
           }
           },
           error: function(response){
              //console.log(response);
              //  $('#image-input-error').text(response.responseJSON.errors.file);
           }
      
      })           
          
}); 

$('.sendToVendor').click(function(){
  $jobId = $(this).attr('id');
  $('#jobId').val($jobId);
  $.ajax({
        data: { projectId : $jobId},
        url: "{{ route('management.helper_getStageQP') }}",
        type: 'POST',
        dataType: 'json',
          // processData: false,
           success: (response) => {
             if(response){
              response = JSON.parse(response.success);
              $('#maxQuality_points').val(response['maxQp']);
              $('#quality_points').val(response['qp']);
            //console.log(response);
             }
             
            },
            error: function(data) { 
            //console.log(data);
           }
  });
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
               //console.log(response) 
              swal("Done! Sent Successfuly", {
              icon: "success"
            }).then((ok) =>{
              location.reload();
            }) 
           }
           },
           error: function(response){
             // console.log(response);
              //  $('#image-input-error').text(response.responseJSON.errors.file);
           }
      
      })           
          
}); 
})

</script>
@include('layouts.partials._file_input_plugin_script')
@endsection
@endsection