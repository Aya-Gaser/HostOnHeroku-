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
              <li class="breadcrumb-item active">Task Proofing</li>
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
             <p class="data"> <Span class="head"> WO ID : </Span>{{$task->wo_id}} </p>
             <p class="data" > <Span class="head"> Language  : </Span>{{$task->WO->from_language}} ▸ {{$task->WO->to_language}}</p>
              <p class="data"> <Span class="head"> Created At : </Span>  {{ UTC_To_LocalTime($task->WO->created_at, Auth::user()->timezone) }} </p>
              <p class="data text-danger"> <Span class="head"> Deadline : </Span> {{UTC_To_LocalTime($task->WO->deadline, Auth::user()->timezone) }}</p>
              <p class="data"> <Span class="head"> Client Instructions : </Span> {{$task->WO->client_instruction }}</p>
              <p class="data"> <Span class="head"> General Instructions : </Span> {{$task->WO->general_instruction }}</p>

           
            <div class="row"> 
              <div class="col-sm-6 col-md-6">
                    <div class="form-group">
                    <br>
                        <h4> Source Documents </h4>
                        <br>
                        
                            @forelse($source_files as $file)                                
                                <li class="text-primary">
                                <a href="{{asset('storage/'.$file['file'])}}"
                                       download="{{$file['file']}}">
                                        {{str_limit($file['file_name'],47)}}
                                    </a>
                                   
                                   
                                </li>
                                <div class="clearfix mb-2"></div>
                            @empty
                                <li class="text-danger">No documents found</li>
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
                           Proofed Files 
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
                   @foreach($project->project_sourceFile as $file)                                
                 
                   <ul>
                   
                        <li class="text-primary">
                        <p>
                        <a href="{{asset('storage/'.$file['file'])}}"
                                download="{{$file['file']}}">
                                {{str_limit($file['file_name'],30)}}
                            </a>
                              
                   <span class="text-success">  ▸▸▸ </span>
                 
                    @if($file->proofed_vendorFile->first())
                       
                        <a href="{{asset('storage/'.$file->proofed_vendorFile->first()->file)}}"
                                download="{{$file->proofed_vendorFile->first()->file}}">
                                {{str_limit($file->proofed_vendorFile->first()->file_name,30)}}
                            </a>
                            
                    @else
                      <span class="text-danger"> NONE YET </span>   
                  
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
                              <h5> Files Editing & Proofing 
                                </h5>
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
                                download="{{$clientProofed->file}}">
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
                                download="{{$projectManagerFile->file}}">
                                {{str_limit($projectManagerFile->file_name,50)}}
                            </a>
                           
                            </li>
                           <div class="clearfix mb-2"></div>
                           </ul>
                         
                         @endforeach
                         </p> 
                           <p> 
                             <form id="projectManager_file" action="{{route('management.upload-finalizedFile',['taskId'=>$task->id, 'type'=>'projectManager'] )}}" method="post" enctype="multipart/form-data">
                                  @csrf
                                  <div class="form-group ">
                                      <div class="file-loading">  
                                      <input id="delivery_files" name="projectManager_file[]" 
                                        class="kv-explorer " type="file" multiple required>  
                                        </div>
                                  </div>
                                <button type="submit" class="btn btn-primary" > 
                                  Upload </button>
                              </form>  
                            </p>
                          </td>

                           <td>
                           <p>
                         @foreach($task->finalized_clientFile as $clientFile)                        
                         
                           <ul>
                           <li class="text-primary">
                            <a href="{{asset('storage/'.$clientFile->file)}}"
                                download="{{$clientFile->file}}">
                                {{str_limit($clientFile->file_name,40)}}
                            </a>
                           
                            </li>
                           <div class="clearfix mb-2"></div>
                           </ul>
                         
                         @endforeach
                         </p> 
                         <p> 
                            <form action="{{route('management.upload-finalizedFile',['taskId'=>$task->id, 'type'=>'client'] )}}" method="post" enctype="multipart/form-data">
                                  @csrf
                                  <div class="form-group ">
                                      <div class="file-loading">  
                                      <input id="delivery_files" name="client_file[]" 
                                        class="kv-explorer " type="file" multiple required>  
                                        </div>
                                  </div>
                                <button type="submit" class="btn btn-primary" > 
                                  Upload </button>
                            </form>  
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
                      for="source_document">Vendor File <span class="required">*</span></label>
                  
                      <div class="file-loading col-md-2">  
                        <input id="vendor_file" name="vendor_file"
                        class="kv-explorer" type="file" required>  
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
                        <input id="client_file" name="client_file"
                        class="kv-explorer" type="file" >  
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
               <label class="form-control-label" for="words_count">Word Count<span
                   class="required">*</span></label>
               <input type="number" min="0" step="1" class="form-control" name="words_count"
                value="" id="words_count" required>

             </div>
             <div class="form-group col-md-6">
                   <label class="form-control-label" for="quality_points">Quality Points<span
                       class="required">*</span></label>
                   <input type="number" min="0" class="form-control" name="quality_points"
                   value="" id="quality_points" required>

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
              swal("Done! Uploaded Successfuly", {
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
              swal("Done! Sent Successfuly", {
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

</script>
@include('layouts.partials._file_input_plugin_script')
@endsection
@endsection