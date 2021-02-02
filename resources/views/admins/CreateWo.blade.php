
@extends('admins.layouts.app')

@section('content')

@section('style')
@include('layouts.partials._file_input_plugin_style')
@endsection

{{--    @include('layouts.partials.default_laravel_validation')--}}

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
              <li class="breadcrumb-item active">Create WO</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">WO Information </h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{route('management.create-wo')}}" method="post" enctype="multipart/form-data">
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
                  <div class="form-group col-md-6">
                   <label for="exampleInputEmail1">Client Rate</label>
                    <input type="number" step="0.01" min="0" class="form-control" name="client_rate" id="client_rate" placeholder="Enter Rate">
                 </div>
                </div>  
          
          <div class="row col-sm-12">
          <div class="form-group col-sm-6">
                    <label class="form-control-label" for="from_language">From Language <span
                    class="required">*</span></label>
                    <select class=" form-control" data-live-search="true" name="from_language" id="from_language">
                   <option disabled selected value="hhhhhhhh" >Select / Insert Language</option>
                   @foreach($languages as $language)
                    <option
                        value="{{$language['name']}}" >
                        {{$language['name']}}
                    </option>
                     @endforeach
                     <option value="arabic" > arabic</option>
                     <option value="english" > english</option>
                     <option value="farsi" > farsi</option>
                    </select>
                  </div>
                  <div class="form-group col-sm-6">
                    <label class="form-control-label" for="to_language">To Language <span
                    class="required">*</span></label>
                    <select class=" form-control" data-live-search="true" name="to_language" id="to_language">
                   <option disabled selected >Select / Insert Language</option>
                   @foreach($languages as $language)
                    <option
                        value="{{$language['name']}}" >
                        {{$language['name']}}
                    </option>
                     @endforeach
                     <option value="arabic" > arabic</option>
                     <option value="english" > english</option>
                     <option value="farsi" > farsi</option>
                    </select>
                  </div>
            </div>
            <div class="row">  
                    <div class="form-group col-md-6" style="position:relative;top:-11px;">
                    <label for="exampleInputFile">Deadline <span class="required"> *</span> </label>
                    <div style="padding:10px;" class="input-append date form_datetime" data-date="2020-12-21T15:25:00Z">
                      <input name="deadline" class="form-control" style="width:90%; height:40px; " size="16" type="text" value="" readonly>
                      <span style="padding:8px 5px; height:40px;" class="add-on"><i class="icon-remove"></i></span>
                      <span style="padding:8px 5px; height:40px;" class="add-on"><i class="icon-calendar"></i></span>
                  </div>
                 </div> 
                  <div class="form-group col-md-6">
                    <label class="form-control-label" for="project_type">Projects Needed 
                    <span class="required">*</span>
                    </label>
                    <select class="select2 form-control" name="projects_needed[]" id="project_type"
                     multiple="multiple" multiple data-placeholder="select projects needed">
                   <option disabled >Select</option>
                    <option value="translation" >Translation  </option>
                    <option value="editing" >Editing  </option>
                    <option value="dtp" >DTP  </option>
                    <option value="linked" >Linked  </option>
                    </select>
                  </div>
                </div>
          <div class="row">     
            <div class="form-group col-md-6">
              <label class="form-control-label" for="words_count">Words Count <span
              class="required">*</span></label>
              <input type="number" min="1" class="form-control" name="words_count" id="words_count" placeholder="Enter ..">

            </div> 
            <div class="form-group col-md-6">
                <label class="form-control-label" for="quality_points">Quality Points<span
                    class="required">*</span></label>
                <input type="number" min="1" class="form-control" name="quality_points" id="quality_points" placeholder="Enter ..">

                  </div>
            
                </div>  
                <div class="row">  
                 <div class="col-sm-6">
                      <!-- textarea -->
                      <div class="form-group">
                        <label>Client Instructions</label>
                        <textarea class="form-control" name="client_instructions" rows="3" placeholder="Enter ..."></textarea>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <!-- textarea -->
                      <div class="form-group">
                        <label>General Instructions</label>
                        <textarea class="form-control" name="general_instructions" rows="3" placeholder="Enter ..."></textarea>
                      </div>
                    </div>
                   </div>
                 
            
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
                     <div class="col-md-4">
                       <div class="form-group">
                       <label class="form-control-label"
                        for="source_document">Target Files <span class="required"></span></label>
                    
                        <div class="file-loading">  
                         <input id="target_files" name="target_files[]"
                          class="kv-explorer custom-file-input" type="file" multiple>  
                        
                          </div>
                       </div>
                   </div>
                </div>   
                
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
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
 



@section('script')
<!-- BS-Stepper -->
<script src="{{asset('plugins/bs-stepper/js/bs-stepper.min.js')}}"></script>


<script>
$(function () {
  bsCustomFileInput.init();
   //Initialize Select2 Elements
   $('.select2').select2();

//Initialize Select2 Elements
$('.select2bs4').select2({
  theme: 'bootstrap4'
})
});
$(".form_datetime").datetimepicker({
        format: "yy-mm-dd H:i:s",
        autoclose: true,
        todayBtn: true,
        startDate: new Date(),
        minuteStep: 10
    });
    $(".form_datetime").datetimepicker().datetimepicker("setDate", new Date());
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
</script>
@include('layouts.partials._file_input_plugin_script')
@endsection

@endsection
