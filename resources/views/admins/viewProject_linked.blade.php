
@extends('admins.layouts.app')

@section('content') 

@section('style')
<style>
td{
  white-space: normal;
  word-break: break-all;
}
#update_div,#update_div_translation,#update_div_editing{
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
                <div class="row">
                <p class="data col-md-6"> <Span class="head"> Client-WO-Project: </Span> @if($project->WO->client) {{$project->WO->client->code}} - @endif{{str_pad($project->WO->id, 4, "0", STR_PAD_LEFT )}} - {{$project->id}} </p>
             <p class="data col-md-6"> <Span class="head"> Name: </Span>{{$project->name}} </p>
             <p class="data col-md-6" > <Span class="head"> Language: </Span>{{$project->WO->from_language}} ▸ {{$project->WO->to_language}}</p>
              <p class="data col-md-6"> <Span class="head"> Created on: </Span>  {{ UTC_To_LocalTime($project->created_at, Auth::user()->timezone) }} </p>
              <p class="data col-md-6"> <Span class="head"> Time until Deadline: </Span> {!! $deadline_difference !!}</p>

              <p class="data col-md-6 text-danger"> <Span class="head"> Deadline: </Span> {{UTC_To_LocalTime($project->delivery_deadline, Auth::user()->timezone) }}</p>

             </div> 
             <br>
             <div class="row">
              <div class="col-sm-6 col-md-6">
                        <h4> Working Documents </h4>
                        <br>
                        
                            @forelse($source_files as $file)                                
                                <li class="text-primary">
                                <a href="{{asset('storage/'.$file['file'])}}"
                                       download="{{$file['file_name']}}">
                                       {{str_limit($file['file_name'],40)}}
                                    </a>
                                    <input type="hidden" value="{{$file['id']}}" id="fileIdsource">
                                    <button id="source"
                                       class="btn btn-danger btn-sm ml-2 deleteProjectFile">
                                            <span class="btn-inner--icon"><i
                                                    class="far fa-trash-alt"></i></span>
                                    </button>
                                </li>
                                <div class="clearfix mb-2"></div>
                            @empty
                                <li class="text-danger">None</li>
                            @endforelse
                         </div>
                         <div class="col-sm-6 col-md-6">
                   
              
                        <h4> Source Document(s) </h4>
                        <br>
                        
                            @foreach($vendorSource_files as $file)                                
                                <li class="text-primary">
                                <a href="{{asset('storage/'.$file['file'])}}"
                                       download="{{$file['file_name']}}">
                                       {{str_limit($file['file_name'],40)}}
                                    </a>
                                    <input type="hidden" value="{{$file['id']}}" id="fileIdsource">
                                    <button id="ref"
                                       class="btn btn-danger btn-sm ml-2 deleteProjectFile">
                                            <span class="btn-inner--icon"><i
                                                    class="far fa-trash-alt"></i></span>
                                    </button>
                                   
                                </li>
                                <div class="clearfix mb-2"></div>
                           
                            @endforeach
                            @forelse($WO_vendorSource_files as $file_toProject) 
                              @php $file = App\woFiles::find($file_toProject->woSourceFile_id) @endphp
                                                          
                                <li class="text-primary">
                                <a href="{{asset('storage/'.$file['file'])}}"
                                       download="{{$file['file_name']}}">
                                       {{str_limit($file['file_name'],40)}}
                                    </a>
                                   
                                    <button id="{{$file_toProject->id}}"
                                       class="btn btn-danger btn-sm ml-2 deleteProjectFile_woSource">
                                            <span class="btn-inner--icon"><i
                                                    class="far fa-trash-alt"></i></span>
                                    </button>
                                </li>
                                <div class="clearfix mb-2"></div>
                            @empty
                                <li class="text-danger">None</li>
                            @endforelse
                            <br>
                           </div> 
                            <div class="col-sm-6 col-md-6">
                            <h4> Reference files </h4>
                           <br>
                            @forelse($reference_files as $file)                               
                                <li class="text-primary">
                                    <a href="{{asset('storage/'.$file['file'])}}"
                                       download="{{$file['file_name']}}">
                                        {{str_limit($file['file_name'],50)}}
                                    </a>
                                    <input type="hidden" value="{{$file['id']}}" id="fileIdref">
                                    <button id="ref"
                                       class="btn btn-danger btn-sm ml-2 deleteProjectFile">
                                            <span class="btn-inner--icon"><i
                                                    class="far fa-trash-alt"></i></span>
                                    </button>
                                    
                                </li>
                                <div class="clearfix mb-2"></div>
                            @empty
                                <li class="text-danger">None</li>
                            @endforelse
                            <br>
                           
                            
                        </ul>
                    </div>
                </div>
                <br>
                <p> 
                <button type="button" id="deleteProject" class="btn btn-danger">Delete Project</button>
                 <button id="update" class="btn btn-primary">Update Project</button>
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
                   
                   <div class="col-md-4">
                     <div class="form-group">
                       <label class="form-control-label"
                        for="source_document">Working Files <span class="required">*</span></label>
                    
                        <div class="file-loading col-md-2">  
                         <input id="source_files" name="source_files[]"
                          class="kv-explorer" type="file" multiple>  
                          </div>
                     </div>
                   </div> 
                      
                   
                   <div class="col-md-4">
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
  <!--************** TRANSLATION STAGE INFO AND UPDATE ************************-->
      
  <div class="card col-md-10">
             <div class="card-header">
             <h4> Translation Stage </h4>
             <button style="float:right;" id="updateTranslation" class="btn btn-primary">Update Details</button>
               
             </div>
             <div class="card-body">
             <div class="row">
             @php $transStage = App\projectStage::where('project_id', $project->id)
                                  ->where('type','translation')->first(); @endphp
                <p class="data col-md-5"> <Span class="head"> Deadline: </Span>
                {{ UTC_To_LocalTime($transStage->deadline, Auth::user()->timezone) }}</p>
                <p class="data col-md-4"> <Span class="head">  Word Count: </Span>
                 @if($transStage->vendor_unitCount)  {{$transStage->vendor_unitCount}}
                  @else   <span class="text-danger"> Target </span> 
                  @endif 
                  </p>
                <p class="data col-md-4"> <Span class="head"> MAX Quality Points: </Span>
                  @if($transStage->vendor_maxQualityPoints)  {{$transStage->vendor_maxQualityPoints}}
                  @else   <span class="text-danger"> Target </span> 
                  @endif
                 </p>
                <p class="data col-md-4"> <Span class="head"> Unit: </Span>{{$transStage->vendor_rateUnit}} </p>
               
                <p class="data col-md-3"> <Span class="head"> Translator Rate: </Span>{{$transStage->vendor_rate}} </p>
                <p class="data col-md-4"> <Span class="head">Translator: </Span> @if($project->translator_id) {{App\User::find($project->translator_id)->name}} 
                @else <span  class="text-danger"> NOT ACCEPTED YET  @endif </span> </p>
                <p class="data col-md-4"> <Span class="head"> Number of File: </Span>
               
               {{$transStage->required_docs}} </p>
                <p class="data col-md-4"> <Span class="head"> Status: </Span>
               
                  {{$transStage->status}} </p>
                <p>
                @if($transStage->status != 'completed')
                    <a method="post" href="{{route('management.complete-stage',['stage'=>$transStage->id,'compelte'=>1] )}}">
                        <button @if(!$allowComplete) disabled @endif type="button" class="btn btn-success" > 
                        Completed &check;&check; </button>
                    </a> 
                @else        
                <a method="post" href="{{route('management.complete-stage',['stage'=>$transStage->id,'compelte'=>0] )}}">
                        <button type="button" class="btn btn-success" > 
                        RE-OPEN </button>
                    </a>
                 @endif       
                    </p>
                <p class="data col-md-12"> <Span class="head"> Instructions: </Span>{{$transStage->instructions}} </p>

              </div>
                <!-- ****************update stage**************************************** -->
           <div class="card card-primary" id="update_div_translation">
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
              <form id="updateStage" action="{{route('management.update-stage',$transStage->id)}}" method="post" enctype="multipart/form-data">
              @csrf
                <div class="card-body">
               
                <div class="row">
                  <div class="form-group col-md-6">
                    <label class="form-control-label" for="unit_count">Word Count<span
                        class="required">*</span></label>
                    <input type="number" min="0" step="1" class="form-control" name="unit_count_{{$transStage->id}}"
                     value="{{$transStage->vendor_unitCount}}" id="unit_count" placeholder="Enter 0 if Target " required>

                  </div>
                  <div class="form-group col-md-6">
                        <label class="form-control-label" for="quality_points">MAX Quality Points<span
                            class="required">*</span></label>
                        <input type="number" min="0" class="form-control" name="maxQuality_points_{{$transStage->id}}"
                        value="{{$transStage->vendor_maxQualityPoints}}" id="quality_points" placeholder="Enter 0 if Target " required>

                  </div>
                </div>   
                <div class="row">          
  
                  <div class="form-group col-md-6">
                      <label class="form-control-label" for="vendor_rateUnit"> Unit
                      <span class="required">*</span>
                      </label>
                      <select class="form-control" name="rate_unit_{{$transStage->id}}" id="rate_unit_translation"
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
                    name="vendor_rate_{{$transStage->id}}" id="vendor_rate" value="{{$transStage->vendor_rate}}" required>
                  </div>
                </div>
                <div class="row">
               <div class="form-group-lg col-md-6" style="position:relative;top:-11px;">
                    <label for="exampleInputFile">Delivery Deadline <span class="required"> *</span> </label>
                    <div style="padding:10px;" class="input-append date form_datetime" data-date="2013-02-21T15:25:00Z">
                      <input name="vendor_deadline_{{$transStage->id}}" style="width:90%; height:40px;" size="16"
                      class="form-control" value="{{UTC_To_LocalTime($transStage->deadline, Auth::user()->timezone)}}" type="text" value="">
                      <span style="padding:8px 5px; height:40px;" class="add-on"><i class="icon-remove"></i></span>
                      <span style="padding:8px 5px; height:40px;" class="add-on"><i class="icon-calendar"></i></span>
                  </div>
                </div>
                <div class="form-group col-md-6">
                <label for="exampleInputEmail1"> Number of Files <span class="required">*</span></label>
                <input type="number" step="1" min="1" class="form-control" name="required_docs_{{$transStage->id}}" value="{{$transStage->required_docs}}" required>
              </div>
                </div>
          
          <div class="row">       
                <div class="form-group col-md-6">
              <label> Instructions</label>
              <textarea class="form-control" name="instructions_{{$transStage->id}}" rows="3" 
              value="" >{{$transStage->instructions}}</textarea>
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
  <br>  
    <!--************** EDITING STAGE INFO AND UPDATE ************************-->
    <div class="card col-md-10">
             <div class="card-header">
             <h4> Editing Stage </h4>
             <button style="float:right;" id="updateEditing" class="btn btn-primary">Update Details</button>

             </div>
             <div class="card-body">
             <div class="row">
             @php $editStage = App\projectStage::where('project_id', $project->id)
                                  ->where('type','editing')->first(); @endphp
                <p class="data col-md-5"> <Span class="head"> Deadline: </Span>
                {{ UTC_To_LocalTime($editStage->deadline, Auth::user()->timezone) }}
                </p>
                <p class="data col-md-4"> <Span class="head">  Word Count: </Span>
                 @if($editStage->vendor_unitCount)  {{$editStage->vendor_unitCount}}
                  @else   <span class="text-danger"> Target </span> 
                  @endif 
                </p>
                <p class="data col-md-4"> <Span class="head">MAX Quality Points: </Span>
                 @if($editStage->vendor_maxQualityPoints)  {{$editStage->vendor_maxQualityPoints}}
                  @else   <span class="text-danger"> Target </span> 
                  @endif
                  </p>
                <p class="data col-md-4"> <Span class="head"> Unit: </Span>{{$editStage->vendor_rateUnit}} </p>
             
                <p class="data col-md-3"> <Span class="head"> Editor Rate: </Span>{{$editStage->vendor_rate}} </p>
                <p class="data col-md-4"> <Span class="head">Editor: </Span>  @if($project->editor_id) {{App\User::find($project->editor_id)->name}} 
                @else <span style="color:red;"> NOT ACCEPTED YET  @endif </span> </p>
                <p class="data col-md-4"> <Span class="head"> Number of File(s): </Span>
               
               {{$editStage->required_docs}} </p>
                <p class="data col-md-4"> <Span class="head"> Status: </Span>
                
                  {{$editStage->status}} </p>
                <p>
                @if($editStage->status != 'completed')
                    <a method="post" href="{{route('management.complete-stage',['stage'=>$editStage->id,'compelte'=>1] )}}">
                        <button type="button" class="btn btn-success" > 
                        Completed &check;&check; </button>
                    </a> 
                @else        
                <a method="post" href="{{route('management.complete-stage',['stage'=>$editStage->id,'compelte'=>0] )}}">
                        <button type="button" class="btn btn-success" > 
                        RE-OPEN  </button>
                    </a>
                 @endif       
                    </p> 
              <p class="data col-md-12"> <Span class="head"> Instructions: </Span>{{$editStage->instructions}} </p>

              </div>
                     <!-- ****************update stage**************************************** -->
                     <div class="card card-primary" id="update_div_editing">
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
              <form id="updateStage_edit" action="{{route('management.update-stage',$editStage->id)}}" method="post" enctype="multipart/form-data">
              @csrf
                <div class="card-body">
               
                <div class="row">
                  <div class="form-group col-md-6">
                    <label class="form-control-label" for="unit_count">Word Count<span
                        class="required">*</span></label>
                    <input type="number" min="0" step="1" class="form-control" name="unit_count_{{$editStage->id}}"
                     value="{{$editStage->vendor_unitCount}}" id="unit_count" placeholder="Enter 0 if Target " required>

                  </div>
                  <div class="form-group col-md-6">
                        <label class="form-control-label" for="quality_points">MAX Quality Points<span
                            class="required">*</span></label>
                        <input type="number" min="0" class="form-control" name="maxQuality_points_{{$editStage->id}}"
                        value="{{$editStage->vendor_maxQualityPoints}}" id="quality_points" placeholder="Enter 0 if Target " required>

                  </div>
                </div>   
                <div class="row">          
  
                  <div class="form-group col-md-6">
                      <label class="form-control-label" for="vendor_rateUnit"> Unit
                      <span class="required">*</span>
                      </label>
                      <select class="form-control" name="rate_unit_{{$editStage->id}}" id="rate_unit_editing"
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
                    name="vendor_rate_{{$editStage->id}}" id="vendor_rate" value="{{$editStage->vendor_rate}}" required>
                  </div>
                </div>
                <div class="row">
               <div class="form-group-lg col-md-6" style="position:relative;top:-11px;">
                    <label for="exampleInputFile">Delivery Deadline <span class="required"> *</span> </label>
                    <div style="padding:10px;" class="input-append date form_datetime" data-date="2013-02-21T15:25:00Z">
                      <input name="vendor_deadline_{{$editStage->id}}" style="width:90%; height:40px;" size="16"
                      class="form-control" value="{{UTC_To_LocalTime($editStage->deadline, Auth::user()->timezone)}}" type="text" value="">
                      <span style="padding:8px 5px; height:40px;" class="add-on"><i class="icon-remove"></i></span>
                      <span style="padding:8px 5px; height:40px;" class="add-on"><i class="icon-calendar"></i></span>
                  </div>
                </div>
                <div class="form-group col-md-6">
                <label for="exampleInputEmail1"> Number of Files <span class="required">*</span></label>
                <input type="number" step="1" min="1" class="form-control" name="required_docs_{{$editStage->id}}" value="{{$editStage->required_docs}}" required>
              </div>
                </div>
          
            <div class="row">   
                <div class="form-group col-md-6">
              <label> Instructions</label>
              <textarea class="form-control" name="instructions_{{$editStage->id}}" rows="3" 
              value="" >{{$editStage->instructions}}</textarea>
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
  <br>
   <!-- ******************PROJECT DELIVERY *************-->
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
                                        
                                        <th width="25%">Working File(s)</th>
                                        <th width="25%">Translated</th>
                                        <th width="13%">Status / Actions</th>
                                        <th width="25%">Edited</th>
                                        <th width="12%">Status / Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                   
                                    @foreach($delivery_files->project_sourceFile as $source_file)
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
                                       <p>{{ UTC_To_LocalTime($delivery_files->translator_delivery[$source_file->id][0]->created_at,
                                        Auth::user()->timezone) }} <br>
                                        {!! $delivery_files->translator_delivery[$source_file->id][0]->deadline_difference !!}
                                      </p>
                                       </td>
                                     
                                        @if($delivery_files->translator_delivery[$source_file->id][0]->status == 'pending')
                                        <td>
                                        <button type="button" class="btn btn-success action accept" id="{{$delivery_files->translator_delivery[$source_file->id][0]->id}}"
                                        data-toggle="modal" data-target="#modal-actionNote">
                                           Accept
                                          </button>
                                          <br><br>
                                        @if($has_proofAndFinalize)
                                        <button type="button" class="btn btn-danger action reject" id="{{$delivery_files->translator_delivery[$source_file->id][0]->id}}"
                                        data-toggle="modal" data-target="#modal-actionNote">
                                           Reject
                                          </button>
                                        @else
                                        <button type="button" class="btn btn-danger improve" id="{{$delivery_files->translator_delivery[$source_file->id][0]->id}}"
                                         data-toggle="modal" data-target="#modal-improvedFile">
                                           Ask Improvements
                                          </button>
                                         @endif 
                                         </td> 
                                        
                                        @else 
                                        <td>
                                              {{$delivery_files->translator_delivery[$source_file->id][0]->status}}
                                              <p>Notes: {{$delivery_files->translator_delivery[$source_file->id][0]->notes}}</p> 
                                              @if($delivery_files->translator_delivery[$source_file->id][0]->improvedFiles)
                                                <ul>
                                                @foreach($delivery_files->translator_delivery[$source_file->id][0]->improvedFiles as $improvedFile)   
                                                <li class="text-primary">
                                                  <a href="{{asset('storage/'.$improvedFile['file'])}}"
                                                    download="{{$improvedFile['file_name']}}">
                                                      {{str_limit($improvedFile['file_name'],40)}}
                                                  </a>
                                                </li>
                                                @endforeach
                                                </ul>
                                              @endif
                                              </td>
                                     @endif  
                                             
                                              
                                              @if(isset( $delivery_files->editor_delivery[$source_file->id]))
                                              <td> 
                                              <p>
                                              <a href="{{asset('storage/'.$delivery_files->editor_delivery[$source_file->id][0]->file)}}"
                                       download="{{$delivery_files->editor_delivery[$source_file->id][0]->file_name}}">
                                        {{str_limit($delivery_files->editor_delivery[$source_file->id][0]->file_name,50)}}
                                    </a>
                                              
                                              </p>
                                              <p>{{UTC_To_LocalTime($delivery_files->editor_delivery[$source_file->id][0]->created_at,
                                        Auth::user()->timezone) }}
                                        {{$delivery_files->editor_delivery[$source_file->id][0]->deadline_difference}}
                                             
                                              </p>
                                              @if($delivery_files->editor_delivery[$source_file->id][0]->status == 'pending')
                                              <td>
                                              <button type="button" class="btn btn-success action accept" id="{{$delivery_files->editor_delivery[$source_file->id][0]->id}}"
                                              data-toggle="modal" data-target="#modal-actionNote">
                                                Accept
                                                </button>
                                                <br><br>
                                              @if($has_proofAndFinalize)
                                              <button type="button" class="btn btn-danger action reject" id="{{$delivery_files->editor_delivery[$source_file->id][0]->id}}"
                                              data-toggle="modal" data-target="#modal-actionNote">
                                                Reject
                                                </button>
                                              @else
                                              <button type="button" class="btn btn-danger improve" id="{{$delivery_files->translator_delivery[$source_file->id][0]->id}}"
                                              data-toggle="modal" data-target="#modal-improvedFile">
                                                Ask Improvements
                                                </button>
                                              @endif 
                                         </td> 
                                         <td></td>
                                         @else
                                              <td>
                                              {{ $delivery_files->editor_delivery[$source_file->id][0]->status }}
                                              <p><b>Notes</b>: {{$delivery_files->editor_delivery[$source_file->id][0]->notes}}</p>
                                              @if($delivery_files->editor_delivery[$source_file->id][0]->improvedFiles)
                                                <ul>
                                                @foreach($delivery_files->editor_delivery[$source_file->id][0]->improvedFiles as $improvedFile)   
                                                <li class="text-primary">
                                                  <a href="{{asset('storage/'.$improvedFile['file'])}}"
                                                    download="{{$improvedFile['file_name']}}">
                                                      {{str_limit($improvedFile['file_name'],40)}}
                                                  </a>
                                                </li>
                                                @endforeach
                                                </ul>
                                              @endif
                                              </td>
                                             
                                              @endif
                                        @else 

                                              <td style="color:red; font-size:21px;">
                                              Not delivered </td> <td></td> 
                                          @endif
                                             
                                           
                                            
                                         
                                         
                                          @else
                                          <td style="color:red; font-size:21px;">
                                          Not delivered </td> <td></td>  <td> </td> <td></td> 
                                          
                                          @endif
                                       
                                    

                                     
                                    

                                       </tr>
                                    @endforeach
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
          @if($has_proofAndFinalize)    
            <div class="card col-md-12">
              <div class="card-body">
            
                          <div class="card-header">
                            <h5> Stage Editing & Finalization    </h5>
                          </div>
                          <div class="table-responsive">
                                 <table class="table table table-striped">
                                    <thead>
                                        <tr>
                                        
                                        <th width="33%">Source Document(s)</th>
                                        <th width="33%">Final Accepted Delivery</th>
                                        <th width="33%">Processed File(s) </th>
                                      
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
                                       <p>{{UTC_To_LocalTime($deliveries_edited->lastAccepted_delivery[$source_file->id][0]->created_at,
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
                                    @if(!$source_file->editedFile->isRecieved)
                                     <a method="post" href=" {{route('management.delete-editedFile',$source_file->editedFile->id)}}">
                                          <button type="button" class="btn btn-danger" > 
                                          Delete File </button>
                                      </a>
                                      @endif    
                                          
                                     </p>
                                   </td>
                                  
                                      @elseif(!$source_file->readyTo_finalize)
                                      <td>
                                      <p> 
                                      <form action="{{route('management.upload-editedFile',['project'=>$project->id, 'sourceFile'=>$source_file->id]  )}}" method="post" enctype="multipart/form-data">
                                                @csrf
                                              <div class="custom-file"  style="margin-bottom:10px;">
                                            <input type="file" class="custom-file-input" name="edited_file" required>
                                            <label class="custom-file-label" for="exampleInputFile" style="width:170;">Choose file</label>
                                          </div>
                                          <button type="submit" class="btn btn-primary" > 
                                          Submit Processed to Finalization </button>
                                          </form>  
                                          </p> 
                                          <a href="{{route('management.send-toFinalization',$source_file->id)}}">
                                          <button type="button" class="btn btn-primary" > 
                                          Send Without Processing To Finalization </button>
                                            </a>
                                           </td> 
                                          @else 
                                          <td> SENT WITHOUT PROCESSING</td> 
                                         
                                      @endif
                                      
                                      
                                              
                                         @else 
                                         <td  style="color:red; font-size:21px;"> Not delivered </td> <td> </td> <td></td>   
                                          
                                          @endif
                                         
                                    

                                     
                                    

                                       </tr>
                                    @endforeach
                                    </tbody>
                                  </table>
                          </div>        
                                    
                          </div></div>
                      
            @endif
              <!-- /.card-body -->
   <!-- **************** TRANSLATION DELIVERY HISTORY ********************-->       
         <br>
           <div class="card-warning">
              <div class="card-header">
                <h4 class="card-title" style="font-size:24px;">Translation Delivery History </h4>
               
              </div>
              <br>
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
                                        <p class="data">  {{ UTC_To_LocalTime($delivery->created_at, Auth::user()->timezone) }} </p>
                                        </div>
                                        <div class="col-md-3">
                                        <p class="head"> Source Document </p>
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
         </div>  
         </div>  
<!--************************ EDITING STAGE DELIVERY HISTORY *****************-->
          <br>
           <div class="card-warning">
              <div class="card-header">
                <h4 class="card-title" style="font-size:24px;">Editing Delivery History </h4>
               
              </div>
              <br>
             <div class="card-body"> 
              @if(isset($deliveryHistory_files['editor_delivery']))  
              @php $i=0; @endphp
              @foreach($deliveryHistory_files['editor_delivery'] as $delivery)
             @php $i++; @endphp
                      <div class="card" style="margin-bottom:15px;">
                        <div class="card-header">
                        <h5> Delivery #  {{$i}}  </h5>
                        </div>
                        <div class="card-body">
                            <div class="row col-md-12">
                                <div class="col-md-3">
                                <p class="head"> Delivery date </p>
                                <p class="data">  {{ UTC_To_LocalTime($delivery->created_at, Auth::user()->timezone) }}
                                  </p>
                                </div>
                                <div class="col-md-3">
                                <p class="head"> Source Document </p>
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
        
            </div>
         </div>  
         </div>  
          <!--/.col (left) -->
          <!-- right column -->
        
          <!--/.col (right) -->
        </div>
<!-- /.modal -->
<div class="modal fade in" id="modal-actionNote" style=" overflow-y:hidden; border:none; box-shadow:none; background-color:transparent;padding:auto;">
     
          <div class="modal-dialog center">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Add Notes</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
              <form id="reject-form" enctype="multipart/form-data">
                    @csrf
                <input name="notes" id="notes" type="text" class="form-control" placeholder="None .."> 
               <input type="hidden" id="deliveryId" name="deliveryId">
               <input type="hidden" id="action" name="action">
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success"> save
                </button> 
                </form>
              </div>
            </div>
            
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>  
<!-- ************************************************************ -->
<!-- /.modal -->
<div class="modal fade in" id="modal-improvedFile" style=" overflow-y:hidden; border:none; box-shadow:none; background-color:transparent;padding:auto;">
     
          <div class="modal-dialog center">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Improved File</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
              <form id="improve-form" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                       <label class="form-control-label"
                        for="source_document">Improved Files <span class="required">*</span></label>
                    
                        <div class="file-loading col-md-2">  
                         <input id="improved_files" name="improved_files[]"
                          class="kv-explorer" type="file" multiple>  
                          </div>
                     </div>
                     <label class="form-control-label"
                        for="source_document">Notes </label>
                    
                     <input name="notes_improve" type="text" class="form-control" placeholder="None .."> 
                     <input type="hidden" id="deliveryId_improve" name="deliveryId_improve">
              
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success"> save
                </button> 
                </form>
              </div>
            </div>
         
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
        format: "dd-M-yy hh:ii",
        //formatTime: 'H:i',
        autoclose: true,
        todayBtn: true,
        todayHighlight:true,
        ampm: true, // FOR AM/PM FORMAT
        //startDate: new Date(new Date().getTime()),
        minuteStep: 15,
       
    
    });
    $(".form_datetime").datetimepicker().datetimepicker("setDate", new Date());

  var type = "{{$project->type}}"
  $("#project_type option[value='"+type+"']").attr("selected", "selected");

  var unitTranslation = "{{$transStage->vendor_rateUnit}}"
  $("#rate_unit_translation option[value='"+unitTranslation+"']").attr("selected", "selected");

  var unitEditing = "{{$editStage->vendor_rateUnit}}"
  $("#rate_unit_editing option[value='"+unitEditing+"']").attr("selected", "selected");

//update project  
$('#update').click(function(){
  $('#update_div').fadeIn();
  document.getElementById('update_div').scrollIntoView({behavior: "smooth", block: "start", inline: "nearest"});
//window.scrollBy(0, 200); 
});
// update translation stage
$('#updateTranslation').click(function(){
  $('#update_div_translation').fadeIn();
  document.getElementById('update_div_translation').scrollIntoView({behavior: "smooth", block: "start", inline: "nearest"});

}); 
// update editing stage
$('#updateEditing').click(function(){
  $('#update_div_editing').fadeIn();
  document.getElementById('update_div_editing').scrollIntoView({behavior: "smooth", block: "start", inline: "nearest"});
});
$('#deleteProject').click(function(){
  document.body.style.cursor='wait';           

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
        dataType: 'json',
        contentType: false,
        processData: false,
        data: {
          woId: {{ $project->id}}
        //  category_id: category_id,
        },
        success:function(response) {
          if(response){
              //this.reset();
               //console.log(response) 
              swal("Done! Deleted Successfully", {
              icon: "success"
            }).then((ok) =>{
              window.location.href = '{{route('management.view-allProjects', 'all' )}}';
            }) 
           }
        }
      })           
          } else {
            swal("Your data is safe!");
          }
        });
}); 
}) 

$('.action').click(function(){
  $deliveryId = $(this).attr('id');
  $('#deliveryId').val($deliveryId); 
  
 
});  
$('.reject').click(function(){
   $('#action').val('rejected');
   document.getElementById("notes").required = true;

});  
$('.accept').click(function(){
   $('#action').val('accepted');
   document.getElementById("notes").required = false;
});   
$('#reject-form').submit(function(e) {
  document.body.style.cursor='wait';           

       e.preventDefault();
       let formData = new FormData(this);
  $.ajax({
        data: formData,
        url: "{{route('management.acion-on-deliveryFile') }}",
        type: 'POST',
        contentType: false,
           processData: false,
           success: (response) => {
             if(response){
              this.reset();
               //console.log(response) 
              swal("Done! Sent Successfully", {
              icon: "success"
            }).then((ok) =>{
              location.reload();
            }) 
           }
             
            },
            error: function(data) { 
            //console.log(data);
           }
  });

});

$('.improve').click(function(){
  $deliveryId = $(this).attr('id');
  $('#deliveryId_improve').val($deliveryId);
});
$('#improve-form').submit(function(e) {
  document.body.style.cursor='wait';           

       e.preventDefault();
       let formData = new FormData(this);
  $.ajax({
        data: formData,
        url: "{{route('management.store-improvedFile') }}",
        type: 'POST',
        contentType: false,
           processData: false,
           success: (response) => {
             if(response){
              this.reset();
               //console.log(response) 
              swal("Done! Sent Successfully", {
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

$('.deleteProjectFile').click(function(){
  document.body.style.cursor='wait';           

 $fileType = $(this).attr('id');
 $fileId = $('#fileId'+$fileType).val();
 var url = "{{ route('management.delete-projectFile',['id'=>'fileId', 'type'=>'fileType'] )}}";
url = url.replace('fileType', $fileType);
url = url.replace('fileId', $fileId);
 
swal({
        title: "Are you sure?",
        text: "You will not be able to recover this data!",
       // type: "warning",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
      //console.log(url)
          if (willDelete) {
        $.ajax({
        url:url,
        type: 'POST',
        contentType: false,
        processData: false,
        data: { fileId: $fileId},
       
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
           // console.log(data);
           }
      })           
          } else {
            swal("Your data is safe!");
          }
        });
});
$('.deleteProjectFile_woSource').click(function(){
  document.body.style.cursor='wait';           

 $fileId = $(this).attr('id');
 var url = "{{ route('management.delete-projectFile-woSource','fileId' )}}";
url = url.replace('fileId', $fileId);
 
swal({
        title: "Are you sure?",
        text: "You will not be able to recover this data!",
       // type: "warning",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
      //console.log(url)
          if (willDelete) {
        $.ajax({
        url:url,
        type: 'POST',
        contentType: false,
        processData: false,
        data: { fileId: $fileId},
       
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
           // console.log(data);
           }
      })           
          } else {
            swal("Your data is safe!");
          }
        });
});

</script>
@include('layouts.partials._file_input_plugin_script')

@endsection     

@endsection
