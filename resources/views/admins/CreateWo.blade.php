
@extends('admins.layouts.app')

@section('content')

@section('style')
<link href="{{asset('bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" media="screen">
<style>
.form-check{
   padding-top:40px;
   padding-left:60px;
}
</style>
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
              <form id="createWo" action="{{route('management.create-wo')}}" method="post" enctype="multipart/form-data">
              @csrf
      <div class="card-body">
                <div class="row">  
                
                  <div class="form-group col-md-6">
                    <label class="form-control-label" for="client_number">Client Number <span
                    class="required">*</span></label>
                    <select class="select2 form-control" data-live-search="true" name="client_number" id="client_number" required>
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
                      <label for="exampleInputEmail1">Client PO Number/Description <span class="required">*</span></label>
                      <input type="text"  class="form-control" name="po_number" id="" placeholder="Enter PO number" required>
                    </div>
                 </div>

                 <div class="row"> 
                  <div class="form-group col-md-6" style="position:relative;top:-2px;">
                    <label for="exampleInputFile">Client Deadline <span class="required"> *</span> </label>
                    <div style="" class="input-append date form_datetime" data-date="2020-12-21T15:25:00Z">
                      <input name="deadline" class="form-control" style="width:90%; height:40px; " size="16" type="text" value="" readonly required>
                      <span style="padding:8px 5px; height:40px;" class="add-on"><i class="icon-remove"></i></span>
                      <span style="padding:8px 5px; height:40px;" class="add-on"><i class="icon-calendar"></i></span>
                  </div>
                 </div>
                 <div class="form-group col-md-6">
                <label for="exampleInputEmail1"> Number of Files <span class="required">*</span></label>
                <input type="number" step="1" min="1" class="form-control" name="sent_docs" id="" placeholder="Enter sent files number" required>
              </div> 
               </div>  
          
          <div class="row">
          <div class="form-group col-sm-6">
                    <label class="form-control-label" for="from_language">Source Language <span
                    class="required">*</span></label>
                    <select class="select2 form-control" data-live-search="true" name="from_language" id="from_language" required>
                   <option disabled selected value="" >Select / Insert Language</option>
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
                    <select class="select2 form-control" data-live-search="true" name="to_language" id="to_language" required>
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
           <div id="tasksNeeded"> 
             <p class="form-control-label text-primary" style="font-size:24px;" >Tasks Needed </p>
                <div id="task1">  
                 <div class="row">
            
                  <div class="form-group col-md-4">
                      <label class="form-control-label" for="task_type1">Task #1 Type
                      <span class="required">*</span>
                      </label>
                      <select class="select2 form-control" name="task_type1" id="task_type1"
                        data-placeholder="select Task Type" required>
                        <option disabled >Select</option>
                        <option value="Translation" >Translation  </option>
                        <option value="Editing" >Editing  </option>
                        <option value="Dtp" >DTP  </option>
                        <option value="Linked" >Linked  </option>
                      </select>
                  </div>
                 
                </div>  
                <div class="row">  
                  <div class="form-group col-md-3 hide">
                    <label class="form-control-label" for="client_wordsCount1">Client Word Count<span
                    class="required">*</span></label>
                    <input type="number" min="0" class="form-control" name="client_wordsCount1"
                     id="client_wordsCount1" placeholder="Enter 0 if Target/DTP" required>
                  </div>

                  <div class="form-group col-md-2">
                      <label class="form-control-label" for="client_rateUnit1">Client Unit
                      <span class="required">*</span>
                      </label>
                      <select class="form-control" name="client_rateUnit1" id="client_rateUnit1"
                        data-placeholder="select Client Rate Unit" required>
                        <option disabled >Select</option>
                        <option value="Word Count" >Word Count  </option>
                        <option value="Hour" >Hour  </option>
                        <option value="Flat" >Flat  </option>
                        <option value="Page" >Page  </option>
                        <option value="Image" >Image  </option>
                      </select>
                  </div>
                  <div class="form-group col-md-2">
                    <label class="form-control-label" for="client_rateValue1">Client Rate<span
                    class="required">*</span></label>
                    <input type="number" min="0.01" step="0.01" class="form-control" name="client_rateValue1"
                     value="0.15" id="client_rateValue1" placeholder="" required>
                  </div>

                  <div class="form-group col-md-2">
                      <label class="form-control-label" for="vendor_rateUnit1">Vendor Unit
                      <span class="required">*</span>
                      </label>
                      <select class="form-control" name="vendor_rateUnit1" id="vendor_rateUnit1"
                        data-placeholder="select vendor Rate Unit" required>
                        <option disabled >Select</option>
                        <option value="Word Count" >Word Count  </option>
                        <option value="Hour" >Hour  </option>
                        <option value="Flat" >Flat  </option>
                        <option value="Page" >Page  </option>
                        <option value="Image" >Image  </option>
                      </select>
                  </div>
                  <div class="form-group col-md-2">
                    <label class="form-control-label" for="vendor_rateValue1">Vendor Rate<span
                    class="required">*</span></label>
                    <input type="number" min="0.01" step="0.01" class="form-control" name="vendor_rateValue1"
                    value="0.03" id="vendor_rateValue1" placeholder="Enter .. " required>
                  </div>

              
                </div> 
               </div>  
              </div>
                
                <div class="form-group col-md-2">
                   <button type="button" id="addTask" class="" 
                   style="border:none; background:transparent; color:green; font-weight:bold;">
                   <i class="fas fa-plus"></i> Add more tasks </button>
                </div> 
                <div class="row">  
                 <div class="col-sm-6">
                      <!-- textarea -->
                      <div class="form-group">
                        <label>Client Instructions</label>
                        <textarea class="form-control" name="client_instructions" rows="3" placeholder="None ..."></textarea>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <!-- textarea -->
                      <div class="form-group">
                        <label>General Instructions</label>
                        <textarea class="form-control" name="general_instructions" rows="3" placeholder="None ..."></textarea>
                      </div>
                    </div>
                   </div>
               
            
                   <div class="row">
                   
                   <div class="col-md-6">
                     <div class="form-group">
                       <label class="form-control-label"
                        for="source_document">Source Document(s) <span class="required">*</span></label>
                    
                        <div class="file-loading col-md-2">  
                         <input id="source_files" name="source_files[]"
                          class="kv-explorer" type="file" multiple required>  
                          </div>
                     </div>
                   </div> 
                      
                   
                   <div class="col-md-6">
                     <div class="form-group">
                       <label class="form-control-label"
                        for="source_document">Reference Document(s)</label>
                    
                        <div class="file-loading">  
                         <input id="reference_files" name="reference_files[]"
                          class="kv-explorer " type="file" multiple>  
                        
                          </div>
                     </div>
                   </div>   
                     
              
                
                </div>
                <!-- /.card-body -->
                <input type="hidden" id="tasksNum" name="tasksNum">
                <div class="card-footer">
                  <button id="submitWo" type="submit" class="btn btn-primary">Submit</button>
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
<script type="text/javascript" src="{{asset('bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.js')}}" charset="UTF-8"></script>
<script type="text/javascript" src="{{asset('bootstrap-datetimepicker-master/js/locales/bootstrap-datetimepicker.fr.js')}}" charset="UTF-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.14/moment-timezone-with-data-2012-2022.min.js"></script>

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
        format: "dd-M-yy H:i:s",
        autoclose: true,
        todayBtn: true,
        todayHighlight:true,
        startDate: new Date(new Date().getTime() + 1*24*60*60*1000),
        initialDate: new Date(new Date().getTime() + 1*24*60*60*1000),
        minuteStep: 15,
        endDate: new Date(new Date().getTime()+100*24*60*60*1000)
    });
    $(".form_datetime").datetimepicker().datetimepicker("setDate", new Date());
    $(document).on('change','#from_language',function(){
      $.ajax({
                url: '/create',
                type: 'POST',
                data: { from_language: $('#from_language').val() },
                success: function(response)
                {
                  //  alert('hi');
                }
            });
          });
 $task = 1;
 $('#tasksNum').val($task);
$('#addTask').click(function(){
  $task++;
  $('#tasksNeeded').append(`
  <div id="task`+$task+`" class="">  
          <div class="row">
            <div class="form-group col-md-4 col-sm-10">
                <label class="form-control-label" for="task_type`+$task+`">Task #`+$task+` Type 
                <span class="required">*</span>
                </label>
                <select class="form-control" name="task_type`+$task+`" id="task_type`+$task+`"
                  data-placeholder="select Task Type" required>
                  <option disabled >Select</option>
                  <option value="Translation" >Translation  </option>
                  <option value="Editing" >Editing  </option>
                  <option value="Dtp" >DTP  </option>
                  <option value="Linked" >Linked  </option>
                </select>
            </div>
            <div class="form-group col-md-2 col-sm-2 justify-content-center align-self-center"
               style="padding-top:28px;">
               <button type="button" id="`+$task+`" class="removeTask btn btn-danger btn-sm ml-2">
                Remove <span class="btn-inner--icon"><i class="far fa-trash-alt"></i></span>
                 </button>
              
            </div>
          </div>  
          <div class="row">
            <div class="form-group col-md-3 col-sm-10 hide">
              <label class="form-control-label" for="client_wordsCount`+$task+`">Client Words Count<span
              class="required">*</span></label>
              <input type="number" min="0" class="form-control" name="client_wordsCount`+$task+`"
               id="client_wordsCount`+$task+`" placeholder="Enter 0 if Target/DTP" required>
            </div>

            <div class="form-group col-md-2 col-sm-10">
                <label class="form-control-label" for="client_rateUnit`+$task+`">Client Unit
                <span class="required">*</span>
                </label>
                <select class="form-control" name="client_rateUnit`+$task+`" id="client_rateUnit`+$task+`"
                  data-placeholder="select Client Rate Unit" required>
                  <option disabled >Select</option>
                  <option value="Word Count" >Word Count  </option>
                  <option value="Hour" >Hour  </option>
                  <option value="Flat" >Flat  </option>
                  <option value="Page" >Page  </option>
                  <option value="Image" >Image  </option>
                </select>
            </div>
            <div class="form-group col-md-2 col-sm-10">
              <label class="form-control-label" for="client_rateValue`+$task+`">Client Rate<span
              class="required">*</span></label>
              <input type="number" min="0.01" step="0.01" class="form-control" name="client_rateValue`+$task+`"
               value="0.15" id="client_rateValue`+$task+`" placeholder="" required>
            </div>

            <div class="form-group col-md-2 col-sm-10">
                <label class="form-control-label" for="vendor_rateUnit`+$task+`">Vendor Unit
                <span class="required">*</span>
                </label>
                <select class="form-control" name="vendor_rateUnit`+$task+`" id="vendor_rateUnit`+$task+`"
                  data-placeholder="select vendor Rate Unit" required>
                  <option disabled >Select</option>
                  <option value="Word count" >Word Count  </option>
                  <option value="Hour" >Hour  </option>
                  <option value="Flat" >Flat  </option>
                  <option value="Page" >Page  </option>
                  <option value="Image" >Image  </option>
                </select>
            </div>
            <div class="form-group col-md-2 col-sm-10">
              <label class="form-control-label" for="vendor_rateValue`+$task+`">Vendor Rate<span
              class="required">*</span></label>
              <input type="number" min="0.01" step="0.01" class="form-control" name="vendor_rateValue`+$task+`"
              value="0.03" id="vendor_rateValue`+$task+`" placeholder="Enter .. " required>
            </div>

          </div> 
      </div>   
  `);
 
  $('#tasksNum').val($task);
}); 

$('body').on('click', '.removeTask', function(){ //injected html elements, events must rebind again 
//$('#m').on('click',function(){  >>>>>>> not working in injected elements
  $deleteTask = 'task'+$(this).attr("id");
  //alert($deleteTask);

  $('#'+$deleteTask).remove();
  $task--;
  $('#tasksNum').val($task);
});

$('#createWo').submit(function(e) {
  document.body.style.cursor='wait';  
  $('#submitWo').attr('disabled', false)          
         

});
</script>
@include('layouts.partials._file_input_plugin_script')
@endsection

@endsection
