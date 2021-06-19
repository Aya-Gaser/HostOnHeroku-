@extends('admins.layouts.app')

@section('style')

@include('layouts.partials._file_input_plugin_style')
<style> 
.selected {
  background-color: #c9cac9;
}
</style>
@endsection
@section('content')



{{--    @include('layouts.partials.default_laravel_validation')--}}

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
              <li class="breadcrumb-item active">Create Project</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
      <div class="row">
      <div class="col-md-11">
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
                            <h4> Reference files </h4>
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
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
      </div>
        <div class="row">
          <!-- left column -->
          <div class="col-md-11">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Project Details  </h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form id="createProject" action="{{route('management.store-project',['wo'=>$wo->id, 'isLinked'=>0]  )}}" method="post" enctype="multipart/form-data">
              @csrf  
                <div class="card-body">
               
                <div class="row">
                <div class="form-group col-md-6">
                    <label class="form-control-label" for="project_type">WO Task 
                    <span class="required">*</span>
                    </label>
                    <select class="select2 form-control" data-live-search="true" name="woTask_id" id="project_type" required>
                   <option disabled >Select</option>
                    @foreach($wo->woTasksNeeded as $task)
                    <option value="{{$task->id}}" {{selectInputVal(null,isset($taskId) ? $taskId : null,$task->id)}}>
                    {{$task->type != null ? $task->type : null}}
                   
                    @endforeach
                    </select>
                  </div>
                
                <div class="form-group col-md-6">
                  <label for="exampleInputEmail1">Name  <span class="required">*</span></label>
                   <input type="text" class="form-control" name="project_name" id="name" placeholder="" required>
                 </div>
                </div>
            <div class="row">
                      <div class="form-group-lg col-md-6" style="position:relative;top:-11px;">
                    <label for="exampleInputFile">Delivery Deadline <span class="required"> *</span> </label>
                    <div style="padding:10px;" class="input-append date form_datetime" data-date="2013-02-21T15:25:00Z">
                      <input class="form-control" name="delivery_deadline" style="width:90%; height:40px;" size="16" type="text" value="" readonly required>
                      <span style="padding:8px 5px; height:40px;" class="add-on"><i class="icon-remove"></i></span>
                      <span style="padding:8px 5px; height:40px;" class="add-on"><i class="icon-calendar"></i></span>
                  </div>
                </div>
                <div class="form-group col-md-6">
                  <label for="exampleInputEmail1">Acceptance Hours<span class="required">*</span></label>
                   <input type="number" step="1" min="0" class="form-control" name="acceptance_deadline" id="acceptance_deadline" placeholder="" required>
                 </div>
            </div>
          
          <div class="row">
          <div class="form-group col-md-6">
                        <label class="form-control-label" for="vendor_rateUnit"> Unit
                        <span class="required">*</span>
                        </label>
                        <select class="select2 form-control" name="rate_unit" id="rate_unit"
                          data-placeholder="select vendor Rate Unit" required>
                          <option disabled >Select</option>
                          <option value="Word Count" >Word Count  </option>
                          <option value="Hour" >Hour  </option>
                          <option value="Flat" >Flat  </option>
                        </select>
                    </div>
            <div class="form-group col-md-6">
                  <label class="form-control-label" for="unit_count">Unit Count<span
                      class="required">*</span></label>
                  <input type="number" min="0" step="1" class="form-control" name="unit_count"
                  id="unit_count" placeholder="Enter 0 if Target " required>

                    </div>
           
          </div>   
          <div class="row">          
  
             
              <div class="form-group col-md-6">
                <label for="exampleInputEmail1"> Rate <span class="required">*</span></label>
                <input type="number" step="0.01" min="0.01" value="0.03" class="form-control" name="vendor_rate" id="vendor_rate" placeholder="Enter Rate" required>
              </div>
              <div class="form-group col-md-6">
                  <label class="form-control-label" for="quality_points">Max Quality Points</label>
                  <input type="number" min="0" class="form-control" name="maxQuality_points"
                    id="quality_points" placeholder="Enter 0 if Target ">

                    </div>
            </div>
          <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                  <label>Group 1 Members <span class="required">*</span> </label>
                  <select class="select2" name='vendor1_translators_group1[]' id='translators_group1[]'
                   multiple="multiple" multiple data-placeholder="Select / Insert Translators" style="width: 100%;" required>
                   @foreach($vendors as $vendor)
                   <option value= "{{$vendor['id']}}" >{{$vendor['name']}} </option>
                   @endforeach
                  </select>
                </div>
                </div>
                <div class="col-md-6">
                <div class="form-group">
                  <label>Group 2 Members</label>
                  <select class="select2"  name='vendor1_translators_group2[]' multiple
                   multiple="multiple" data-placeholder="Select / Insert Translators" style="width: 100%;">
                   @foreach($vendors as $vendor)
                   <option value= "{{$vendor['id']}}" >{{$vendor['name']}} </option>
                   @endforeach
                  </select>
                </div>
                </div>
            </div>  
            <div class="row">
             <div class="form-group col-md-6">
               <label> Instructions</label>
               <textarea class="form-control" id="instructions" name="instructions" rows="3" placeholder="None ..."></textarea>
             </div>
             <div class="form-group col-md-6">
                <label for="exampleInputEmail1"> Number of Files <span class="required">*</span></label>
                <input type="number" step="1" min="1" class="form-control" name="required_docs" id="" placeholder="Enter sent files number" required>
              </div>
           </div>  
            <div class="row">
                   
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="form-control-label"
                       for="source_document">Working File(s)<span class="required">*</span></label>
                   
                       <div class="file-loading col-md-2">  
                        <input id="source_files" name="source_files[]"
                         class="kv-explorer" type="file" multiple required>  
                         </div>
                    </div>
                  </div> 
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="form-control-label"
                       for="source_document">Reference File(s) </label>
                   
                       <div class="file-loading">  
                        <input id="reference_files" name="reference_files[]"
                         class="kv-explorer " type="file" multiple>  
                       
                         </div>
                    </div>
                  </div> 
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="form-control-label"
                       for="source_document">Source File(s)</label>
                   
                       <div class="file-loading col-md-2">  
                        <input id="vendorSource_files" name="vendorSource_files[]"
                         class="kv-explorer" type="file" multiple >  
                         </div>
                    </div>
                  </div> 
                     
                  
                 
                  <div class="col-sm-6 col-md-6 form-group">
                  <input id="selectedFiles" name="selectedFiles"
                   class="form-control" type="hidden">     
                        <h5>Select WO Source Document(s) </h5>
                        <br>
                        
                            @forelse($source_files as $file)  
                                                          
                                <li class="text-primary">
                                <input type="checkbox" onchange="inputChanged(event)" value="{{$file->id}}"/>
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
            <!-- /.card -->

            <div class="card-footer" id="submit_div">
                  <button id="submitProject" type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
           
            <!-- /.card -->

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
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
    
    </div>
    <strong>Copyright &copy; 2020 Tarjamat LLC</a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->





@section('script')
<!-- BS-Stepper -->
<script src="{{asset('plugins/bs-stepper/js/bs-stepper.min.js')}}"></script>
<script>
var selectedFiles = [];
  function inputChanged(event) {
  
    if(event.target.checked){
    event.target.parentElement.className ='selected';
    selectedFiles.push(event.target.value.trim()) ;

    }
    else{
    event.target.parentElement.className = '';
    selectedFiles.pop();

    }
    trimmed = JSON.stringify(selectedFiles);
    $('#selectedFiles').val(trimmed.substring(1, trimmed.length-1)); 
}

$(function () {
  
     //Initialize Select2 Elements
     $('.select2').select2()

//Initialize Select2 Elements
$('.select2bs4').select2({
  theme: 'bootstrap4'
})

  bsCustomFileInput.init();
  $('select').selectpicker();

$woD = new Date("{{UTC_To_LocalTime($wo->deadline, Auth::user()->timezone, true)}}");
diff = 23 - $woD.getHours();

$(".form_datetime").datetimepicker({
        format: "dd-M-yy H:i:s",
        autoclose: true,
        todayBtn: true,
        todayHighlight:true,
        startDate: new Date(new Date().getTime()),
        minuteStep: 15,
       
       // endDate: new Date($woD.getTime() - 1*24*60*60*1000 + diff*60*60*1000),
      /*  beforeShowDay: function(date) {
          calender_date = date.getFullYear()+'-'+(date.getMonth()+1)+'-'+('0'+date.getDate()).slice(-2);

                var search_index = $.inArray(calender_date, user_busy_days);

                if (search_index > -1) {
                    return {classes: 'non-highlighted-cal-dates', tooltip: 'User available on this day.'};
                }else{
                    return {classes: 'highlighted-cal-dates', tooltip: 'User not available on this day.'};
                }

            
        } */
    });
    $(document).on('change','#from_language',function(){
      $.ajax({
                url: '/create',
                type: 'POST',
                data: { from_language: $('#from_language').val() },
                success: function(response)
                {
                    alert('hi');
                }
            });

      
          });
});
$('#createProject').submit(function(e) {
  document.body.style.cursor='wait';  
  $('#submitProject').attr('disabled', false)          
  
});
</script>
@include('layouts.partials._file_input_plugin_script')
@endsection

@endsection
