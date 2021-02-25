@extends('admins.layouts.app')

@section('content') 

@section('style')
<style>
td{
  white-space: normal;
  word-break: break-all;
}

#update_div,#update_div_stage{
  display : none;
}

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
              <li class="breadcrumb-item active">Project Details</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
     @php $deliveryId=0; @endphp
    
      <div class="row">
      <div class="col-md-10">
            <div class="card card-success shadow-sm">
              <div class="card-header">
                <h3 class="card-title">Project Details </h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
                </div>
             
                <div class="card-body">
             <p class="data"> <Span class="head"> ID : </Span>{{$project->id}} </p>
             <p class="data"> <Span class="head"> Name : </Span>{{$project->name}} </p>
             <p class="data" > <Span class="head"> Language  : </Span>{{$project->WO->from_language}} ▸ {{$project->WO->to_language}}</p>
              <p class="data"> <Span class="head"> Created At : </Span>  {{ UTC_To_LocalTime($project->created_at, Auth::user()->timezone) }} </p>
              <p class="data"> <Span class="head"> Deadline : </Span> {{UTC_To_LocalTime($project->delivery_deadline, Auth::user()->timezone) }}</p>

               <p class="data"> <Span class="head"> Deadline Time Left : </Span> {!! $deadline_difference !!}</p>
              
              <div class="col-sm-6 col-md-4">
                    <div class="form-group">
                    <br>
                        <h4> Working Documents </h4>
                        <br>
                        
                            @forelse($source_files as $file)                                
                                <li class="text-primary">
                                <a href="{{asset('storage/'.$file['file'])}}"
                                       download="{{$file['file']}}">
                                        {{$file['file_name']}}
                                    </a>
                                    <a href="{{route('management.delete-file',['id'=>$file['id'],
                                    'type'=>'source']) }}"
                                       class="btn btn-danger btn-sm ml-2">
                                            <span class="btn-inner--icon"><i
                                                    class="far fa-trash-alt"></i></span>
                                    </a>
                                   
                                </li>
                                <div class="clearfix mb-2"></div>
                            @empty
                                <li class="text-danger">No documents found</li>
                            @endforelse
                            <br>
                            <h4> Reference files </h4>
                           <br>
                            @forelse($reference_files as $file)                               
                                <li class="text-primary">
                                    <a href="{{asset('storage/'.$file['file'])}}"
                                       download="{{$file['name']}}">
                                        {{str_limit($file['file_name'],50)}}
                                    </a>
                                    <a href="{{route('management.delete-file',['id'=>$file['id'],
                                    'type'=>'ref']) }}"
                                       class="btn btn-danger btn-sm ml-2">
                                            <span class="btn-inner--icon"><i
                                                    class="far fa-trash-alt"></i></span>
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
                <p> 
                <button type="button" id="deleteProject" class="btn btn-danger">Delete Project</button>
                 <button  id="update" class="btn btn-primary">Update Project</button>
               </p> 
              </div>
              </div>
              </div>
  <!-- ****************update project**************************************** -->
  <div class="card card-primary" id="update_div">
              <div class="card-header">
                <h3 class="card-title">Update Project Details  </h3>
                <div class="card-tools">
                  
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form id="updateProject" action="{{route('management.update-project',$project->id)}}" method="post" enctype="multipart/form-data">
              @csrf
                <div class="card-body">
               
                <div class="row">
               
                <div class="form-group col-md-6">
                  <label for="exampleInputEmail1">Name</label>
                   <input type="text" class="form-control" name="project_name_edit" id="name" 
                   value="{{$project->name}}" placeholder="">
                 </div>
                </div>
          <!--
          <div class="row">          
          
            <div class="form-group col-md-6">
              <label> Instructions</label>
              <textarea class="form-control" name="instructions_edit" rows="3" 
              value="{{$project->instructions}}" placeholder="Enter ..."></textarea>
            </div>
           
          </div> 
          -->
         
          <div class="row">
                   
                   <div class="col-md-6">
                     <div class="form-group">
                       <label class="form-control-label"
                        for="source_document">Working Files <span class="required">*</span></label>
                    
                        <div class="file-loading col-md-2">  
                         <input id="source_files" name="source_files[]"
                          class="kv-explorer" type="file" multiple>  
                          </div>
                     </div>
                   </div> 
                      
                   
                   <div class="col-md-6">
                     <div class="form-group">
                       <label class="form-control-label"
                        for="source_document">Reference Files <span class="required"></span></label>
                    
                        <div class="file-loading">  
                         <input id="reference_files" name="reference_files[]"
                          class="kv-explorer " type="file" multiple>  
                        
                          </div>
                     </div>
                   </div>   
                    
                </div>
                
            <!-- /.card -->

            <div class="card-footer" id="submit_div">
                  <button type="submit" class="btn btn-primary">Update</button>
                </div>
              </form>
            </div>
        </div>  


  <!-- *********************** end update ************************* -->            
              <!-- /.card-header -->
              <div class="card col-md-12">
              <div class="card-body">
            
                          <div class="card-header">
                            <h5> Project Delivery  </h5>
                          </div>
                          <div class="card-body">
                          <div class="table-responsive">
                                 <table class="table table table-striped">
                                    <thead>
                                        <tr>
                                        
                                        <th width="35%">Working File</th>
                                        <th width="35%">{{$project->type}}</th>
                                        <th width="30%">Status / Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                   
                                    @forelse($delivery_files->project_sourceFile as $source_file)
                                      <tr>
                                       <td> 
                                       <a href="{{asset('storage/'.$source_file->file)}}"
                                       download="{{$source_file->file_name}}">
                                        {{str_limit($source_file->file_name,50)}}
                                    </a>
                                       </td> 
                                      
                                     @if(isset( $delivery_files->translator_delivery[$source_file->id]))
                                       
                                       <td> <p>
                                       <a href="{{asset('storage/'.$delivery_files->translator_delivery[$source_file->id][0]->file)}}"
                                       download="{{$delivery_files->translator_delivery[$source_file->id][0]->file_name}}">
                                        {{str_limit($delivery_files->translator_delivery[$source_file->id][0]->file_name,50)}}
                                    </a>
                                       </p>
                                       <p>  {{ UTC_To_LocalTime($delivery_files->translator_delivery[$source_file->id][0]->created_at,
                                             Auth::user()->timezone) }}  </p> <br>
                                             {!! $delivery_files->translator_delivery[$source_file->id][0]->deadline_difference !!}
                                       
                                       </td>
                                     
                                        @if($delivery_files->translator_delivery[$source_file->id][0]->status == 'pending')
                                        <td>
                                       <button class="btn btn-success" style="margin-bottom:10px;">
                                       <a href="{{route('management.acion-on-deliveryFile',
                                    ['deliveryId'=> $delivery_files->translator_delivery[$source_file->id][0]->id,
                                     'fileId'=>$source_file->id, 'action'=>'accepted'])}}">
                                     Accept </a>
                                          </button> 
                                          <br>
                                          <button onClick=" @php $deliveryId =$delivery_files->translator_delivery[$source_file->id][0]->id;
                                          @endphp "
                                           type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-default">
                                       Reject
                                        </button>
                                         </td> 
                                        
                                        @else 
                                        <td>
                                              <p>{{$delivery_files->translator_delivery[$source_file->id][0]->status}}</p>
                                              <p><b>Notes</b> :{{$delivery_files->translator_delivery[$source_file->id][0]->notes}}</p>  <br> 
                                              </td>
                                     @endif  
                                             
                                              
                                           
                                            
                                         
                                         
                                          @else
                                          <td style="color:red; font-size:21px;">
                                          NOT READY YET </td> <td></td>  
                                          
                                          @endif
                                          @empty
                                          <td style="color:red; font-size:21px;">
                                          NOT READY YET </td> <td></td><td></td>  
                                       
                                    

                                     
                                    

                                       </tr>
                                    @endforelse
                                    </tbody>
                                  </table>
                          </div>        
                                    
                          </div>
                        </div>  
                     
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
           
            <div class="card col-md-12">
              <div class="card-body">
            
                          <div class="card-header">
                            <h5> Project Editing & Finalization    </h5>
                          </div>
                          <div class="table-responsive">
                                 <table class="table table table-striped">
                                    <thead>
                                        <tr>
                                        
                                        <th width="33%">Working File</th>
                                        <th width="33%">Final Accepted Delivery</th>
                                        <th width="33%">Editing </th>
                                   
                                        </tr>
                                    </thead>
                                    <tbody>
                                   
                                    @foreach($deliveries_edited->project_sourceFile as $source_file)
                                      <tr>
                                       <td> 
                                       <a href="{{asset('storage/'.$source_file->file)}}"
                                       download="{{$source_file->file_name}}">
                                        {{str_limit($source_file->file_name,50)}}
                                    </a>
                                       </td> 
                                      
                                     @if(isset( $deliveries_edited->lastAccepted_delivery[$source_file->id]))
                                       
                                       <td> <p>
                                       <a href="{{asset('storage/'.$deliveries_edited->lastAccepted_delivery[$source_file->id][0]->file)}}"
                                       download="{{$deliveries_edited->lastAccepted_delivery[$source_file->id][0]->file_name}}">
                                        {{str_limit($deliveries_edited->lastAccepted_delivery[$source_file->id][0]->file_name,50)}}
                                    </a>
                                       </p>
                                       <p>{{ UTC_To_LocalTime($deliveries_edited->lastAccepted_delivery[$source_file->id][0]->created_at,
                                             Auth::user()->timezone) }}
                                        </p>
                                       </td>

                                       @if($source_file->editedFile )
                                       <td>
                                       <p>
                                       <a href="{{asset('storage/'.$source_file->editedFile->file)}}"
                                       download="{{$source_file->editedFile->file_name}}">
                                        {{str_limit($source_file->editedFile->file_name,50)}}
                                    </a>
                                    </p> 
                                    
                                    <p>
                                     <a method="post" href="{{route('management.delete-editedFile',$source_file->editedFile->id)}}">
                                          <button type="button" class="btn btn-danger" > 
                                          Delete File </button>
                                      </a>    
                                          
                                     </p>
                                   </td>
                                  
                                      @elseif(!$source_file->readyTo_finalize)
                                      <td>
                                      <p> 
                                      <form action="{{route('management.upload-editedFile',['project'=>$project->id, 'sourceFile'=>$source_file->id] )}}" method="post" enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-group">
                                                    <div class="file-loading">  
                                                    <input id="delivery_files" name="edited_file" required
                                                      class="kv-explorer " type="file">  
                                                      </div>
                                                </div>
                                          <button type="submit" class="btn btn-primary" > 
                                            Upload Edited File </button>
                                          </form>  
                                          </p>
                                          <a href="{{route('management.send-toFinalization',$source_file->id)}}">
                                          <button type="button" class="btn btn-primary" > 
                                            Send To Finalization </button>
                                            </a>
                                           </td> 
                                          @else 
                                          <td> SENT WITHOUT EDITING</td> 
                                         
                                      @endif
                                      
                                      

                                        
                                         @else 
                                         <td style="color:red; font-size:21px;"> NOT READY YET </td> <td> </td> <td></td>   
                                          
                                          @endif
                                         
                                    

                                     
                                    

                                       </tr>
                                    @endforeach
                                    </tbody>
                                  </table>
                          </div>        
                                    
                          </div></div>
                      
            
              <!-- /.card-body -->
          
             



            <div class="card col-md-12">
             <div class="card-header">
             <h4> Translation Stage </h4>
             
                <button style="float:right;" id="updateStage" class="btn btn-primary">Update Details</button>
               
             </div>
             <div class="card-body">
             <div class="row">
             @php $stage = App\projectStage::where('project_id', $project->id)
                                              ->first(); @endphp
                                              
                <p class="data col-md-4"> <Span class="head"> Deadline  : </Span>
               
                {{ UTC_To_LocalTime($project->delivery_deadline, Auth::user()->timezone) }}</p>
                <p class="data col-md-4"> <Span class="head">  Word Count  : </Span>
                  @if($stage->vendor_wordsCount)  {{$stage->vendor_wordsCount}}
                  @else   <span class="text-danger"> Target </span> 
                  @endif    
                </p>
                <p class="data col-md-4"> <Span class="head">  Quality Points  : </Span>
                  @if($stage->vendor_qualityPoints)  {{$stage->vendor_qualityPoints}}
                  @else   <span class="text-danger"> Target </span> 
                  @endif
                 </p>
                <p class="data col-md-4"> <Span class="head"> Unit : </Span>{{$stage->vendor_rateUnit}} </p>
                <p class="data col-md-4"> <Span class="head"> Translator Rate  : </Span>{{$stage->vendor_rate}} </p>

                <p class="data col-md-4"> <Span class="head">Translator : </Span> @if($project->translator_id) {{App\User::find($project->translator_id)->name}} 
                @else <span class="text-danger"> NOT ACCEPTED YET  @endif </span> </p>
                <p class="data col-md-4"> <Span class="head"> Number Of Files  : </Span>
               
               {{$stage->required_docs}} </p>
                <p class="data col-md-4"> <Span class="head"> Status  : </Span>
               
                  {{$stage->status}} </p>
                <p>
                @if($stage->status != 'completed')
                    <a method="post" href="{{route('management.complete-stage',['stage'=>$stage->id,'compelte'=>1] )}}">
                        <button type="button" class="btn btn-success" > 
                        Completed &check;&check; </button>
                    </a> 
                @else        
                <a method="post" href="{{route('management.complete-stage',['stage'=>$stage->id,'compelte'=>0] )}}">
                        <button type="button" class="btn btn-success" > 
                        RE-OPEN </button>
                    </a>
                 @endif       
                    </p>
              <p class="data col-md-12"> <Span class="head"> Instructions  : </Span>{{$stage->instructions}} </p>
     
                   
              </div>
               <!-- ****************update stage**************************************** -->
           <div class="card card-primary" id="update_div_stage">
              <div class="card-header">
                <h3 class="card-title">Update Stage Details  </h3>
                <div class="card-tools">
                 
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form id="updateStage" action="{{route('management.update-stage',$stage->id)}}" method="post" enctype="multipart/form-data">
              @csrf
                <div class="card-body">
               
                <div class="row">
                  <div class="form-group col-md-6">
                    <label class="form-control-label" for="words_count">Word Count<span
                        class="required">*</span></label>
                    <input type="number" min="0" step="1" class="form-control" name="words_count_{{$stage->id}}"
                     value="{{$stage->vendor_wordsCount}}" id="words_count" placeholder="Enter 0 if Target " required>

                  </div>
                  <div class="form-group col-md-6">
                        <label class="form-control-label" for="quality_points">Quality Points<span
                            class="required">*</span></label>
                        <input type="number" min="0" class="form-control" name="quality_points_{{$stage->id}}"
                        value="{{$stage->vendor_qualityPoints}}" id="quality_points" placeholder="Enter 0 if Target " required>

                  </div>
                </div>   
                <div class="row">          
  
                  <div class="form-group col-md-6">
                      <label class="form-control-label" for="vendor_rateUnit"> Unit
                      <span class="required">*</span>
                      </label>
                      <select class="form-control" name="rate_unit_{{$stage->id}}" id="rate_unit"
                        data-placeholder="select vendor Rate Unit" required>
                        <option disabled >Select</option>
                        <option value="Word Count" >Word Count  </option>
                        <option value="Hour" >Hour  </option>
                        <option value="Flat" >Flat  </option>
                      </select>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="exampleInputEmail1"> Rate <span class="required">*</span></label>
                    <input type="number" step="0.01" min="0.01" class="form-control" 
                    name="vendor_rate_{{$stage->id}}" id="vendor_rate" value="{{$stage->vendor_rate}}" required>
                  </div>
                </div>
                <div class="row">
               <div class="form-group-lg col-md-6" style="position:relative;top:-11px;">
                    <label for="exampleInputFile">Delivery Deadline <span class="required"> *</span> </label>
                    <div style="padding:10px;" class="input-append date form_datetime" data-date="2013-02-21T15:25:00Z">
                      <input name="vendor_deadline_{{$stage->id}}" style="width:90%; height:40px;" size="16"
                      class="form-control" value="{{UTC_To_LocalTime($stage->deadline, Auth::user()->timezone)}}" type="text" value="">
                      <span style="padding:8px 5px; height:40px;" class="add-on"><i class="icon-remove"></i></span>
                      <span style="padding:8px 5px; height:40px;" class="add-on"><i class="icon-calendar"></i></span>
                  </div>
                </div>
                <div class="form-group col-md-6">
                <label for="exampleInputEmail1"> Number Of Files <span class="required">*</span></label>
                <input type="number" step="1" min="1" class="form-control" name="required_docs_{{$stage->id}}" value="{{$stage->required_docs}}" required>
              </div>
                </div>
          
          <div class="row">        
                <div class="form-group col-md-12">
              <label> Instructions</label>
              <textarea class="form-control" name="instructions_{{$stage->id}}" rows="3" 
              value="">{{$stage->instructions}}</textarea>
            </div>
          </div> 
         
            
                  </div>
            <!-- /.card -->

            <div class="card-footer" id="submit_div">
                  <button type="submit" class="btn btn-primary">Update</button>
                </div>
              </form>
            </div>
     


  <!-- *********************** end update ************************* -->       
            <div class="card-warning">
              <div class="card-header">
                <h4 class="card-title" style="font-size:24px;"> Delivery History </h4>
               
              </div>
             <div class="card-body"> 
              @if(isset($deliveryHistory_files['translator_delivery'] ))
              @php $i=0; @endphp
              @foreach($deliveryHistory_files['translator_delivery'] as $delivery)
             @php $i++; @endphp
                             <div class="card" style="margin-bottom:15px;">
                                <div class="card-header">
                                <h5> Delivery #  {{$i}}  </h5>
                                </div>
                                <div class="card-body">
                                   <div class="row col-md-12">
                                        <div class="col-md-3">
                                        <p class="head"> Delivery date </p>
                                       
                                    
                                        <p class="data"> 
                                        {{ UTC_To_LocalTime($delivery->created_at, Auth::user()->timezone) }}
                                       
                                        </p>
                                        </div>
                                        <div class="col-md-3">
                                        <p class="head"> Working File </p>
                                         <p class="data"> 
                                         <a href="{{asset('storage/'.App\project_sourceFile::find($delivery->sourceFile_id)->file)}}"
                                       download="{{App\project_sourceFile::find($delivery->sourceFile_id)->file_name}}">
                                        {{str_limit(App\project_sourceFile::find($delivery->sourceFile_id)->file_name,50)}}
                                    </a>
                                         </p>
                                        </div>
                                       
                                        <div class="col-md-3">
                                        <p class="head"> #Delivered File </p>
                                        <p class="data">  
                                        <a href="{{asset('storage/'.$delivery->file)}}"
                                       download="{{$delivery->file_name}}">
                                        {{str_limit($delivery->file_name,50)}}
                                    </a>
                                        </p>
                                        </div>
                                        <div class="col-md-3">
                                        <p class="head"> Delivery Status </p>
                                        <p class="data">   {{$delivery->status}} </p>
                                        </div>
                                   </div>
                                 </div> 
                                 </div> 

                               @endforeach 
                         @endif  
             </div>
            </div>

             
          <!--/.col (left) -->
          <!-- right column -->
        
          <!--/.col (right) -->
        </div>
<!-- /.modal -->
<div class="modal fade in" id="modal-default" style=" overflow-y:hidden; border:none; box-shadow:none; background-color:transparent;padding:auto;">
      <center>
          <div class="modal-dialog center">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Rejection Notes</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
              <form action="{{route('management.acion-on-deliveryFile',
               ['deliveryId'=> $deliveryId,'action'=>'rejected'])}}" method="get" enctype="multipart/form-data">
                    @csrf
                <input name="notes" type="text" class="form-control" required> 
              
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success"> save
                </button> 
                </form>
              </div>
            </div>
            </center>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->

        <!-- /.row -->
      </div><!-- /.container-fluid -->
     
    </section>
    <!-- /.content -->
  </div>
 
@section('script')

<script>
$(function () {
  bsCustomFileInput.init();
   //Initialize Select2 Elements
   $('.select2').select2();

//Initialize Select2 Elements
$('.select2bs4').select2({
  theme: 'bootstrap4'
})

$(".form_datetime").datetimepicker({
        format: "dd-M-yy H:i:s",
        autoclose: true,
        todayBtn: true,
       // startDate: 
        minuteStep: 15
    });
  var type = "{{$project->type}}"
  $("#project_type option[value='"+type+"']").attr("selected", "selected");
  var unit = "{{$stage->vendor_rateUnit}}"
  $("#rate_unit option[value='"+unit+"']").attr("selected", "selected");
 /// update project 
$('#update').click(function(){
  $('#update_div').fadeIn();
  document.getElementById('update_div').scrollIntoView({behavior: "smooth", block: "start", inline: "nearest"});
//window.scrollBy(0, 200); 
});
/// update stage
$('#updateStage').click(function(){
  $('#update_div_stage').fadeIn();
  document.getElementById('update_div_stage').scrollIntoView({behavior: "smooth", block: "start", inline: "nearest"});
});
$('#deleteProject').click(function(){
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
        url:" {{route('management.delete-project', $project->id) }}",
        type: 'POST',
        dataType: 'text',
        data: {
          woId: {{ $project->id}}
        //  category_id: category_id,
        },
        success:function(response) {
           // tasks on reponse
          /* swal("Done! Your data has been deleted", {
              icon: "success",
            }); */
            window.location.href = '{{route('management.view-allProjects', 'all' )}}';
        }
      })           
          } else {
            swal("Your data is safe!");
          }
        });
}); 
})

</script>
@include('layouts.partials._file_input_plugin_script')
@endsection
@endsection