@extends('admins.layouts.app')

@section('content') 


{{--    @include('layouts.partials.default_laravel_validation')--}}
@section('style')
@include('layouts.partials._file_input_plugin_style')

<style>
td{
  white-space: normal;
  word-break: break-all;
}
#update_div{
  display : none;
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
            <h1></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('management.dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active">WO Information</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
      <div class="row">
      <div class="col-md-10">
            <div class="card card-success shadow-sm">
              <div class="card-header">
                <h3 class="card-title">WO Details</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              

                <!-- /.card-tools -->
              </div> 
              <!-- /.card-header -->
              <div class="card-body">
              <div class="row">
              <p class="data col-md-6"> <Span class="head"> ID:  </Span>
                {{str_pad($wo->id, 4, "0", STR_PAD_LEFT )}}
                </p>
                <p class="data col-md-6"> <Span class="head"> Created on: </Span>
                {{ UTC_To_LocalTime($wo->created_at, Auth::user()->timezone)}}
                </p>
                <p class="data col-md-6"> <Span class="head"> Client:
                     @if(App\client::find($wo['client_id']))
                     {{App\client::find($wo->client_id)->code}} - {{App\client::find($wo->client_id)->name}}
                      @else 
                      {{$wo['client_id']}} - <span class="text-danger"> DELETED </span>
                      @endif
                 </Span>   </p>
                <p class="data text-danger col-md-6" > <Span class="head"> Deadline: </Span>
                {{ UTC_To_LocalTime($wo->deadline, Auth::user()->timezone)}}
                </p>
                <p class="data col-md-6"> <Span class="head"> Client PO Number/Description: </Span>{{$wo->po_number}}</p>
                <p class="data col-md-6"> <Span class="head"> Language: </Span>{{$wo->from_language}} ▸ {{$wo->to_language}}</p>
              </div>
              <div class="row">
                
               
                <p class="data col-md-6"> <Span class="head"> Number of Files:  </Span>
                {{$wo->sent_docs}}
                </p>
                <p class="data col-md-6"> <Span class="head">Created By:  </Span>
                {{App\User::find($wo->created_by)->userName}}
                </p>
                
             
              
               <p class="data col-md-6"> <Span class="head"> Client Instructions: </Span>
                 {{ $wo->client_instructions}}
               </p>
               <p class="data col-md-6"> <Span class="head"> General Instructions: </Span>
                 {{ $wo->general_instructions}}
               </p>
               <p class="data col-md-12"> <Span class="head"> Action: 
               @if($wo->isReceived) <Span class="data"> Confirmed &check;&check; </span>
               @else
               <a href="{{route('management.recieve-wo',$wo->id)}}"> <button class="btn btn-success"> Confirmed </button> </a>
                 @endif </Span>
              
               </p>
              </div>               
             <div class="row">
               <div class="col-sm-6 col-md-6 form-group">
                        <h4> Source Document(s) </h4>
                        <br>
                        
                            @forelse($source_files as $file)                                
                                <li class="text-primary">
                                <a href="{{asset('storage/'.$file['file'])}}"
                                       download="{{$file['file_name']}}">
                                        {{$file['file_name']}}
                                    </a>
                                    <button id="{{$file['id']}}"
                                       class="btn btn-danger btn-sm ml-2 deleteWoFile">
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
                          <div class="col-sm-6 col-md-6 form-group">
                            <h4> Reference Document(s) </h4>
                           <br>
                            @forelse($reference_file as $file)                               
                                <li class="text-primary">
                                    <a href="{{asset('storage/'.$file['file'])}}"
                                       download="{{$file['file_name']}}">
                                        {{str_limit($file['file_name'],50)}}
                                    </a>
                                    <button id="{{$file['id']}}"
                                       class="btn btn-danger btn-sm ml-2 deleteWoFile">
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
               
              <p> 
                
                 <button type="button" id="deleteWo" class="btn btn-danger">Delete WO</button>
                 <button type="update" id="update" class="btn btn-primary">Update WO</button>
               </p>   
               
          </div>
          </div>
          </div>
          <!--*************** edit *************************** -->
          <div class="card card-primary col-md-12" id="update_div">
              <div class="card-header">
              <div class="card-tools">
                  
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
                <h3 class="card-title">Update WO  </h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{route('management.update-wo',$wo->id)}}" method="post" enctype="multipart/form-data">
              @csrf
              <div class="card-body">
              <div class="row">  
                
                <div class="form-group col-md-6">
                  <label class="form-control-label" for="client_number">Client Number <span
                  class="required">*</span></label>
                  <select class=" form-control" data-live-search="true" name="client_number" id="client_number">
                 <option disabled selected >Select / Insert Client</option>
                 @foreach($clients as $client)
                  <option
                      value="{{$client['id']}}" >
                      {{$client['code']}} - {{$client['name']}}
                  </option>
                   @endforeach
                  </select>
                </div>
                <div class="form-group col-md-6" style="position:relative;top:-2px;">
                  <label for="exampleInputFile">Client Deadline <span class="required"> *</span> </label>
                  <div style="" class="input-append date form_datetime" data-date="2020-12-21T15:25:00Z">
                    <input name="deadline" class="form-control" value="{{ UTC_To_LocalTime($wo->deadline, Auth::user()->timezone)}}"
                     style="width:90%; height:40px; " size="16" type="text" value="" readonly>
                    <span style="padding:8px 5px; height:40px;" class="add-on"><i class="icon-remove"></i></span>
                    <span style="padding:8px 5px; height:40px;" class="add-on"><i class="icon-calendar"></i></span>
                </div>
               </div> 
             </div>  
        
        <div class="row">
        <div class="form-group col-sm-6">
                  <label class="form-control-label" for="from_language">Source Language <span
                  class="required">*</span></label>
                  <select class=" form-control" data-live-search="true" name="from_language" id="from_language">
                 <option disabled selected value="hhhhhhhh" >Select / Insert Language</option>
                 @foreach($languages as $language)
                  <option class="language" value="{{$language['name']}}" >
                      {{$language['name']}}
                  </option>
                   @endforeach
                   <option value="Arabic" >
                     Arabic
                    </option>
                    <option value="English" >
                     English
                    </option>
                    <option value="Farsi" >
                     Farsi
                    </option>
                  </select>
                </div>
                <div class="form-group col-sm-6">
                  <label class="form-control-label" for="to_language">Target Language <span
                  class="required">*</span></label>
                  <select class=" form-control" data-live-search="true" name="to_language" id="to_language">
                 <option disabled selected >Select / Insert Language</option>
                 @foreach($languages as $language)
                  <option class="language"
                      value="{{$language['name']}}" >
                      {{$language['name']}}
                  </option>
                   @endforeach
                   <option value="Arabic" >
                     Arabic
                    </option>
                    <option value="English" >
                     English
                    </option>
                    <option value="Farsi" >
                     Farsi
                    </option>
                  
                  </select>
                </div>
          </div>
    
              <div class="row">  
               <div class="col-sm-6">
                    <!-- textarea -->
                    <div class="form-group">
                      <label>Client Instructions</label>
                      <textarea class="form-control" name="client_instructions" value="{{$wo->client_instructions}}"
                      rows="3" placeholder="Enter ..."></textarea>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <!-- textarea -->
                    <div class="form-group">
                      <label>General Instructions</label>
                      <textarea class="form-control" name="general_instructions" value="{{$wo->general_instructions}}"
                       rows="3" placeholder="Enter ..."></textarea>
                    </div>
                  </div>
                 </div>
               
                 <div class="form-group col-md-6">
                <label for="exampleInputEmail1"> Number of Files <span class="required">*</span></label>
                <input type="number" step="1" min="1" class="form-control" name="sent_docs" id="" value="{{$wo->sent_docs}}" required>
              </div>
                 <div class="row">
                 
                 <div class="col-md-6">
                   <div class="form-group">
                     <label class="form-control-label"
                      for="source_document">Source Document(s) <span class="required">*</span></label>
                  
                      <div class="file-loading col-md-2">  
                       <input id="source_files" name="source_files[]"
                        class="kv-explorer" type="file" multiple>  
                        </div>
                   </div>
                 </div> 
                    
                 
                 <div class="col-md-6">
                   <div class="form-group">
                     <label class="form-control-label"
                      for="source_document">Reference Document(s) <span class="required"></span></label>
                  
                      <div class="file-loading">  
                       <input id="reference_files" name="reference_files[]"
                        class="kv-explorer " type="file" multiple>  
                      
                        </div>
                   </div>
                 </div>   
                   
              </div>   
              
              </div>
              <!-- /.card-body -->
              <input type="hidden" id="tasksNum" name="tasksNum">

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Update</button>
                </div>
              </form>
            </div>
                <br>
           <div class=" card-dark col-md-12">
              <div class="card-header">
                  <h4 style="position:relative; top:10px;"> WO Tasks </h4>
                  <div class="card-tools">
                      
                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal-addTask">
                          Add Task </button>
                     
                      
                  </div>  
                  </div>
                  <div class="card-body">
                  @foreach($wo->woTasksNeeded as $task)

                  <div class="row">
                    <div class="card card-noPadding card-success col-12" style="margin-bottom:15px;">
                      <div class="card-header">
                        <h5 class="card-title"> Task #  {{$loop->iteration}}  </h5>
                        
                        <div class="card-tools">
                        <a href="{{ route('management.create-project',['id'=> $wo->id,
                       'type'=> 'single','taskId'=>$task->id] )}}">
                        <button type="ok" class="btn btn-primary ">Add Single Project</button>
                      </a>
                      <a href="{{ route('management.create-project',['id'=> $wo->id,
                          'type'=> 'linked','taskId'=>$task->id ] )}}">
                      <button type="ok" class="btn btn-dark ">Add Linked Project</button>
                      </a>
                          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                          </button>
                        </div>
                      </div>
                      <div class="card-body">
                          <div class="row col-md-12">
                            <div class="col-md-3">
                            <p class="head">  Type </p>
                            <p class="data">  {{$task->type}} </p>
                            </div>
                            <div class="col-md-3">
                            <p class="head"> Client Word Count </p>
                              <p class="data"> 
                             
                              @if($task->client_wordsCount)  {{$task->client_wordsCount}}
                              @else   <span class="text-danger"> Target </span> 
                              @endif
                              </p>
                            </div>
                            
                            <div class="col-md-3">
                            <p class="head">  Client Unit </p>
                            <p class="data">  
                            {{$task->client_rateUnit}}
                            </p>
                            </div>
                            <div class="col-md-3">
                            <p class="head">  Client Rate </p>
                            <p class="data">   {{$task->client_rateValue}} </p>
                            </div>
                            <div class="col-md-3">
                            <p class="head">  Vendor Unit (Suggest) </p>
                            <p class="data">   {{$task->vendor_suggest_rateUnit}} </p>
                            </div>
                            <div class="col-md-3">
                            <p class="head">  Vendor Rate  (Suggest) </p>
                            <p class="data">   {{$task->vendor_suggest_rateValue}} </p>
                            </div> 
                            <div class="col-md-3">
                            <p class="head">  Status</p>
                            <p class="data">   {{$task->status}} </p>
                            </div>
                            <div class="col-md-3">
                              <button type="button" class="btn btn-danger btn-sm deleteTask" id="{{$task->id}}">
                                <i class="fas fa-trash">
                                </i>
                                Delete Task
                              </button>
                            </div>  
                          </div>
                          <div class="row">
                          <div class="card card-noPadding card-primary col-12">
                            <div class="card-header">
                              <h5 class="card-title"> Projects </h5>
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
                                 Vendor
                                </th>
                                <th style="width: " >
                                 Deadline
                                </th>
                                <th style="width: ">
                                Status
                                </th>
                                <th style="width: ">
                               
                                </th>
                              
                            </tr>
                        </thead>
                        <tbody>
                      
                      @foreach ($task->project as $project)
                      
                          <tr>
                            <td> 
                              @if($project->translator) 
                                {{$project->translator->name}}
                              @else
                                <span class="text-danger"> None Yet </span>
                            @endif
                             </td>
                           
                            <td>
                            
                            {{ UTC_To_LocalTime($project->delivery_deadline, Auth::user()->timezone) }}
                            </td>
                            <td>
                             {{$project->status}}
                            </td>
                            <td>
                             <button type="ok" class="btn btn-primary" style=" float: right; margin-right:10px;"> 
                              <a href="{{route('management.view-project',$project->id)}}">
                              View </a>
                             </button>
                            </td> 
                          </tr>   
                        @endforeach
                  
                        </tbody>
                    </table>
                  </div>
                  </div> 
                  </div> 
            <div class="row">
              <div class="col-sm-6 col-md-6">
                   
              
                        <h4> Final Documents </h4>
                        <br>
                        
                            @forelse($task->finalized_projectManagerFile as $file)                                
                                <li class="text-primary">
                                <a href="{{asset('storage/'.$file['file'])}}"
                                       download="{{$file['file_name']}}">
                                        {{$file['file_name']}}
                                    </a>
                                   
                                </li>
                                <div class="clearfix mb-2"></div>
                            @empty
                                <li class="text-danger">None</li>
                            @endforelse
                            <br>
                           </div> 
                           <div class="col-sm-6 col-md-6">
                   
              
                   <h4> Final Client Documents </h4>
                   <br>
                   
                       @forelse($task->finalized_clientFile as $file)                                
                           <li class="text-primary">
                           <a href="{{asset('storage/'.$file['file'])}}"
                                  download="{{$file['file_name']}}">
                                   {{$file['file_name']}}
                               </a>
                              
                           </li>
                           <div class="clearfix mb-2"></div>
                       @empty
                           <li class="text-danger">None</li>
                       @endforelse
                       <br>
                      </div> 
                             
                          </div> 
                        
                    </div>
                  </div>
                  @endforeach
                </div>
                </div>  
              </div>                  
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
    
<!-- /.modal -->
<div class="modal fade in" id="modal-addTask" style=" overflow-y:hidden; border:none; box-shadow:none; background-color:transparent;padding:auto;">
  
          <div class="modal-dialog center">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Add New Task</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
              <form action="{{route('management.add-task',$wo->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div id="task">  
                 <div class="row">
            
                  <div class="form-group col-md-6">
                      <label class="form-control-label" for="task_type">Task Type
                      <span class="required">*</span>
                      </label>
                      <select class="form-control" name="task_type" id="task_type"
                        data-placeholder="select Task Type" required>
                        <option disabled >Select</option>
                        <option value="Translation" >Translation  </option>
                        <option value="Editing" >Editing  </option>
                        <option value="Dtp" >DTP  </option>
                        <option value="Linked" >Linked  </option>
                      </select>
                  </div>
                  <div class="form-group col-md-6">
                    <label class="form-control-label" for="client_wordsCount">Client Word Count<span
                    class="required">*</span></label>
                    <input type="number" min="0" class="form-control" name="client_wordsCount"
                     id="client_wordsCount" placeholder="Enter 0 if Target/DTP" required>
                  </div>
                </div>  
                <div class="row">  
                  

                  <div class="form-group col-md-6">
                      <label class="form-control-label" for="client_rateUnit">Client Unit
                      <span class="required">*</span>
                      </label>
                      <select class="form-control" name="client_rateUnit" id="client_rateUnit"
                        data-placeholder="select Client Rate Unit" required>
                        <option disabled >Select</option>
                        <option value="Word Count" >Word Count  </option>
                        <option value="Hour" >Hour  </option>
                        <option value="Flat" >Flat  </option>
                      </select>
                  </div>
                  <div class="form-group col-md-6">
                    <label class="form-control-label" for="client_rateValue">Client Rate<span
                    class="required">*</span></label>
                    <input type="number" min="0.01" step="0.01" class="form-control" name="client_rateValue"
                     value="0.15" id="client_rateValue" placeholder="" required>
                  </div>
                 </div>
                 <div class="row">  
                  <div class="form-group col-md-6">
                      <label class="form-control-label" for="vendor_rateUnit">Vendor Unit
                      <span class="required">*</span>
                      </label>
                      <select class="form-control" name="vendor_rateUnit" id="vendor_rateUnit"
                        data-placeholder="select vendor Rate Unit" required>
                        <option disabled >Select</option>
                        <option value="Word Count" >Words Count  </option>
                        <option value="Hour" >Hour  </option>
                        <option value="Flat" >Flat  </option>
                      </select>
                  </div>
                  <div class="form-group col-md-6">
                    <label class="form-control-label" for="vendor_rateValue">Vendor Rate<span
                    class="required">*</span></label>
                    <input type="number" min="0.01" step="0.01" class="form-control" name="vendor_rateValue"
                    value="0.03" id="vendor_rateValue" required>
                  </div>

              
               
                </div> 
               </div>  
              
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
          <!--/.col (left) -->
          <!-- right column -->
        
          <!--/.col (right) -->
        </div>
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
        format: "yy-mm-dd hh:mm",
        autoclose: true,
        ampm: true, // FOR AM/PM FORMAT
        todayBtn: true,
       // startDate: " {{ UTC_To_LocalTime($wo->deadline, Auth::user()->timezone)}}",
        minuteStep: 10
    });
  var number = "{{$wo->client_id}}"
  $("#client_number option[value="+number+"]").attr("selected", "selected");

  var to_language = "{{$wo->to_language}}"
  $("#to_language option[value="+to_language+"]").attr("selected", "selected");

  var from_language = "{{$wo->from_language}}"
  $("#from_language option[value="+from_language+"]").attr("selected", "selected");

$('#update').click(function(){
  $('#update_div').fadeIn();
  document.getElementById('update_div').scrollIntoView({behavior: "smooth", block: "start", inline: "nearest"});
//window.scrollBy(0, 200); 
})
$('#deleteWo').click(function(){
  document.body.style.cursor='wait';           

  swal({
        title: "Are you sure?",
        text: "You will not be able to recover this data!",
        type: "warning",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
          if (willDelete) {
            $.ajax({
        url:" {{route('management.delete-wo', $wo->id) }}",
        type: 'POST',
        dataType: 'text',
        data: {
          woId: {{$wo->id}}
        //  category_id: category_id,
        },
        success:function(response) {
          if(response){
             // this.reset();
               //console.log(response) 
              swal("Done! Deleted Successfully", {
              icon: "success"
            }).then((ok) =>{
              window.location.href = '{{route('management.view-allWo')}}';

            }) 
           }
        }
      })           
          } else {
            swal("Your data is safe!");
          }
        });
});
$('.deleteWoFile').click(function(){
  document.body.style.cursor='wait';           

 $fileId = $(this).attr('id');
 var url = "{{ route('management.delete-woFile','id' )}}";
url = url.replace('id', $fileId);
 
swal({
        title: "Are you sure?",
        text: "You will not be able to recover this data!",
       // type: "warning",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
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
            //console.log(data);
           }
      })           
          } else {
            swal("Your data is safe!");
          }
        });
});


$('.deleteTask').click(function(){
  document.body.style.cursor='wait';           

 $taskd = $(this).attr('id');
 var url = "{{ route('management.delete-task', 'id') }}";
url = url.replace('id', $taskd);
 
  swal({
        title: "Are you sure?",
        text: "You will not be able to recover this data!",
       // type: "warning",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
          if (willDelete) {
        $.ajax({
        url:url,
        type: 'POST',
        contentType: false,
        processData: false,
        data: { taskId: $taskd},
       
        success:function(response) {
          if(response){
             // this.reset();
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
})

</script>
@include('layouts.partials._file_input_plugin_script')     
@endsection
@endsection
