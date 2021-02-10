
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
             <p class="data"> <Span class="head"> ID : </Span>{{$project->id}} </p>
             <p class="data"> <Span class="head"> Name : </Span>{{$project->name}} </p>
             <p class="data" > <Span class="head"> Language  : </Span>{{$project->WO->from_language}} ▸ {{$project->WO->to_language}}</p>
              <p class="data"> <Span class="head"> Created At : </Span> {{ UTC_To_LocalTime($project->created_at, Auth::user()->timezone) }}
               </p>
               <p class="data"> <Span class="head"> Deadline : </Span> {{UTC_To_LocalTime($project->delivery_deadline, Auth::user()->timezone) }}</p>

               <p class="data"> <Span class="head"> Deadline Time Left : </Span>  {!! $deadline_difference !!}</p>
               
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
                           
                            
                        </ul>
                    </div>
                </div>
                <p> 
                <button type="button" id="deleteProject" class="btn btn-danger">Delete Wo</button>
                 <button type="update" id="update" class="btn btn-primary">Update Project</button>
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
                        for="source_document">Refrence Files <span class="required"></span></label>
                    
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
                                        
                                        <th width="25%">Working File</th>
                                        <th width="25%">Translated</th>
                                        <th width="13%">Status / Actions</th>
                                        <th width="25%">Edited</th>
                                        <th width="12%">Status / Actions</th>
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
                                              {{$delivery_files->translator_delivery[$source_file->id][0]->status}}
                                              <p>Notes :{{$delivery_files->translator_delivery[$source_file->id][0]->notes}}</p> 
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
                                       <button class="btn btn-success" style="margin-bottom:10px;">
                                       <a href="{{route('management.acion-on-deliveryFile',
                                    ['deliveryId'=> $delivery_files->editor_delivery[$source_file->id][0]->id,
                                     'fileId'=>$source_file->id, 'action'=>'accepted'])}}">
                                     Accept </a>
                                          </button> 
                                          <br>
                                          <button onClick=" @php $deliveryId =$delivery_files->editor_delivery[$source_file->id][0]->id;
                                          @endphp "
                                           type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-default">
                                       Reject
                                        </button>
                                         </td> 
                                         <td></td>
                                         @else
                                              <td>
                                              {{ $delivery_files->editor_delivery[$source_file->id][0]->status }}
                                              <p><b>Notes</b> : {{$delivery_files->editor_delivery[$source_file->id][0]->notes}}</p>
                                              </td>
                                             
                                              @endif
                                        @else 

                                              <td style="color:red; font-size:21px;">
                                          NOT READY YET </td> <td></td> 
                                          @endif
                                             
                                           
                                            
                                         
                                         
                                          @else
                                          <td style="color:red; font-size:21px;">
                                          NOT READY YET </td> <td></td>  <td> </td> <td></td> 
                                          
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
            
            <div class="card col-md-12">
              <div class="card-body">
            
                          <div class="card-header">
                            <h5> Project Editing & Finalization    </h5>
                          </div>
                          <div class="table-responsive">
                                 <table class="table table table-striped">
                                    <thead>
                                        <tr>
                                        
                                        <th width="30%">Source File</th>
                                        <th width="30%">Final Accepted Delivery</th>
                                        <th width="20%">Editing </th>
                                        <th width="20%">Finalization </th>
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
                                      
                                      

                                       
                                       @if($source_file->finalizedFile)
                                       <td>
                                       <p>
                                       <a href="{{asset('storage/'.$source_file->finalizedFile->file)}}"
                                       download="{{$source_file->finalizedFile->file_name}}">
                                        {{str_limit($source_file->finalizedFile->file_name,50)}}
                                    </a>
                                    </p> 
                                    @if(!$source_file->isCompleted)
                                    <p> 
                                     <a method="post" href="{{route('management.delete-finalizedFile',$source_file->finalizedFile->id)}}">
                                          <button type="button" class="btn btn-danger" > 
                                          Delete File </button>
                                      </a>    
                                          
                                     </p>
                                     <p>
                                     <a method="post" href="{{route('management.complete-sourceFile',['sourceFile'=>$source_file->id,'compelte'=>1] )}}">
                                          <button type="button" class="btn btn-success" > 
                                          Completed &check;&check; </button>
                                      </a>    
                                          
                                     </p>
                                     @else

                                      @if($ifNextProject && !$source_file->finalizedFile->isSentToNext)
                                        <p>
                                        <a method="post" href="{{route('management.send-toNextStage', $source_file->finalizedFile->id )}}">
                                              <button type="button" class="btn btn-success" > 
                                              Send To Next Stage</button>
                                          </a>    
                                            
                                      </p>
                                      @elseif($ifNextProject)
                                      <p> Sent To Next Stage &check;&check; </p>
                                      @endif

                                     <p class="success"> completed &check;&check;</p>
                                     <p>
                                     <a method="post" href="{{route('management.complete-sourceFile',['sourceFile'=>$source_file->id,'compelte'=>0] )}}">
                                          <button type="button" class="btn btn-success" > 
                                          RE-OPEN </button>
                                      </a>    
                                          
                                     </p>
                                     @endif
                                    </td>

                                      @elseif($source_file->editedFile || $source_file->readyTo_finalize)
                                      <td>
                                      <p> 
                                      <form action="{{route('management.upload-finalizedFile',['project'=>$project->id, 'sourceFile'=>$source_file->id])}}" method="post" enctype="multipart/form-data">
                                                @csrf
                                              <div class="custom-file"  style="margin-bottom:10px;">
                                            <input type="file" class="custom-file-input" name="finalized_file" required>
                                            <label class="custom-file-label" for="exampleInputFile" style="width:170;">Choose file</label>
                                          </div>
                                          <button type="submit" class="btn btn-primary" > 
                                          upload final </button>
                                          </form>  
                                     </p> </td>
                                      @else
                                      <td></td>
                                      @endif
                                     
                                             
                                              
                                         @else 
                                         <td  style="color:red; font-size:21px;"> NOT READY YET </td> <td> </td> <td></td>   
                                          
                                          @endif
                                         
                                    

                                     
                                    

                                       </tr>
                                    @endforeach
                                    </tbody>
                                  </table>
                          </div>        
                                    
                          </div></div>
                      
            
              <!-- /.card-body -->
          
         
            <div class="card col-md-10">
             <div class="card-header">
             <h4> Translation Stage </h4>
             <button type="update" style="float:right;" id="updateTranslation" class="btn btn-primary">Update Details</button>
               
             </div>
             <div class="card-body">
             <div class="row">
             @php $transStage = App\projectStage::where('project_id', $project->id)
                                  ->where('type','translation')->first(); @endphp
                <p class="data col-md-5"> <Span class="head"> Deadline  : </Span>
                {{ UTC_To_LocalTime($transStage->deadline, Auth::user()->timezone) }}</p>
                <p class="data col-md-4"> <Span class="head">  words Count  : </Span>{{$transStage->vendor_wordsCount}} </p>
                <p class="data col-md-4"> <Span class="head">  Quality Points  : </Span>{{$transStage->vendor_qualityPoints}} </p>
                <p class="data col-md-4"> <Span class="head">  Rate unit : </Span>{{$transStage->vendor_rateUnit}} </p>
               
                <p class="data col-md-3"> <Span class="head"> Translator Rate  : </Span>{{$transStage->vendor_rate}} </p>
                <p class="data col-md-4"> <Span class="head">Translator : </Span> @if($project->translator_id) {{App\User::find($project->translator_id)->name}} 
                @else <span  class="text-danger"> NOT ACCEPTED YET  @endif </span> </p>

                <p class="data col-md-4"> <Span class="head"> Status  : </Span>
               
                  {{$transStage->status}} </p>
                <p>
                @if($transStage->status != 'completed')
                    <a method="post" href="{{route('management.complete-stage',['stage'=>$transStage->id,'compelte'=>1] )}}">
                        <button type="button" class="btn btn-success" > 
                        Completed &check;&check; </button>
                    </a> 
                @else        
                <a method="post" href="{{route('management.complete-stage',['stage'=>$transStage->id,'compelte'=>0] )}}">
                        <button type="button" class="btn btn-success" > 
                        RE-OPEN </button>
                    </a>
                 @endif       
                    </p>
                <p class="data col-md-12"> <Span class="head"> Instructions  : </Span>{{$transStage->instructions}} </p>

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
                  <label for="exampleInputEmail1">Rate</label>
                   <input type="number" min="0.1" step="0.1" class="form-control" 
                   name="vendor_rate_edit_{{$transStage->id}}" id="vendor_rate" 
                   value="{{$transStage->vendor_rate}}" placeholder="">
                 </div>
                  
          
          <div class="form-group-lg col-md-6" style="position:relative;top:-11px;">
                    <label for="exampleInputFile">Delivery Deadline <span class="required"> *</span> </label>
                    <div style="padding:10px;" class="input-append date form_datetime" data-date="2013-02-21T15:25:00Z">
                      <input name="vendor_deadline_{{$transStage->id}}" style="width:90%; height:40px;" size="16"
                      value="{{UTC_To_LocalTime($transStage->deadline, Auth::user()->timezone)}}" type="text" value="" readonly>
                      <span style="padding:8px 5px; height:40px;" class="add-on"><i class="icon-remove"></i></span>
                      <span style="padding:8px 5px; height:40px;" class="add-on"><i class="icon-calendar"></i></span>
                  </div>
                </div>
                </div>
          
          <div class="row">       
                <div class="form-group col-md-6">
              <label> Instructions</label>
              <textarea class="form-control" name="instructions_edit_{{$transStage->id}}" rows="3" 
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
  <br>  <br>
           <div class="card-warning">
              <div class="card-header">
                <h4 class="card-title" style="font-size:24px;"> Delivery History </h4>
               
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
                                        <p class="head"> Source File </p>
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

             <div class="card col-md-10">
             <div class="card-header">
             <h4> Editing Stage </h4>
             <button type="update" style="float:right;" id="updateEditing" class="btn btn-primary">Update Details</button>

             </div>
             <div class="card-body">
             <div class="row">
             @php $editStage = App\projectStage::where('project_id', $project->id)
                                  ->where('type','editing')->first(); @endphp
                <p class="data col-md-5"> <Span class="head"> Deadline  : </Span>
                {{ UTC_To_LocalTime($editStage->deadline, Auth::user()->timezone) }}
                </p>
                <p class="data col-md-4"> <Span class="head">  words Count  : </Span>{{$editStage->vendor_wordsCount}} </p>
                <p class="data col-md-4"> <Span class="head">  Quality Points  : </Span>{{$editStage->vendor_qualityPoints}} </p>
                <p class="data col-md-4"> <Span class="head">  Rate unit : </Span>{{$editStage->vendor_rateUnit}} </p>
             
                <p class="data col-md-3"> <Span class="head"> Editor Rate  : </Span>{{$editStage->vendor_rate}} </p>
                <p class="data col-md-4"> <Span class="head">Editor : </Span>  @if($project->editor_id) {{App\User::find($project->editor_id)->name}} 
                @else <span style="color:red;"> NOT ACCEPTED YET  @endif </span> </p>
                <p class="data col-md-4"> <Span class="head"> Status  : </Span>
                
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
              <p class="data col-md-12"> <Span class="head"> Instructions  : </Span>{{$editStage->instructions}} </p>

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
                  <label for="exampleInputEmail1">Rate</label>
                   <input type="number" min="0.1" step="0.1" class="form-control" 
                   name="vendor_rate_edit_{{$editStage->id}}" id="vendor_rate" 
                   value="{{$editStage->vendor_rate}}" placeholder="">
                 </div>
                     
          
          <div class="form-group-lg col-md-6" style="position:relative;top:-11px;">
                    <label for="exampleInputFile">Delivery Deadline <span class="required"> *</span> </label>
                    <div style="padding:10px;" class="input-append date form_datetime" data-date="2013-02-21T15:25:00Z">
                      <input name="vendor_deadline_{{$editStage->id}}" style="width:90%; height:40px;" size="16"
                      value="{{UTC_To_LocalTime($editStage->deadline, Auth::user()->timezone)}}" type="text" value="" readonly>
                      <span style="padding:8px 5px; height:40px;" class="add-on"><i class="icon-remove"></i></span>
                      <span style="padding:8px 5px; height:40px;" class="add-on"><i class="icon-calendar"></i></span>
                  </div>
                </div>
                </div>
          
            <div class="row">   
                <div class="form-group col-md-6">
              <label> Instructions</label>
              <textarea class="form-control" name="instructions_edit_{{$editStage->id}}" rows="3" 
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
  <br>  <br>
           <div class="card-warning">
              <div class="card-header">
                <h4 class="card-title" style="font-size:24px;"> Delivery History </h4>
               
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
                                <p class="head"> Source File </p>
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
              <form action="{{route('vendor.acion-on-deliveryFile',
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
        format: "yy-mm-dd H:i:s",
        autoclose: true,
        todayBtn: true,
       // startDate: 
        minuteStep: 10
    });
  var type = "{{$project->type}}"
  $("#project_type option[value="+type+"]").attr("selected", "selected");

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
