@extends('admins.layouts.app')

@section('content') 

@section('style')
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
              <p class="data" > <Span class="head"> Deadline  : </Span>
              {{ UTC_To_LocalTime($wo->deadline, Auth::user()->timezone)}}
              </p>
              <p class="data"> <Span class="head"> Client Number : </Span> {{App\client::find($wo->client_id)->first()->code}} </p>
              <p class="data"> <Span class="head"> Client Rate  : </Span>{{$wo->client_rate}} </p>
              <p class="data"> <Span class="head"> words Count  : </Span>{{$wo->words_count}} </p>
              <p class="data"> <Span class="head"> Quality Points  : </Span>{{$wo->quality_points}} </p>

              <p class="data"> <Span class="head"> Language  : </Span>{{$wo->from_language}} ▸ {{$wo->to_language}}</p>
              <p class="data"> <Span class="head"> Created At : </Span>
              {{ UTC_To_LocalTime($wo->created_at, Auth::user()->timezone)}}
               </p>
               <p class="data"> <Span class="head"> Projects Needed  :
               <ul>
               @foreach($wo->woProjectsNeeded as $projectNeeded)
                  <li class="data"> {{$projectNeeded->type}} </li>
               @endforeach
               </ul>
               </Span> </p>
               <p class="data"> <Span class="head"> Client Instructions : </Span>
                 {{ $wo->client_instructions}}
               </p>
               <p class="data"> <Span class="head"> General Instructions : </Span>
                 {{ $wo->general_instructions}}
               </p>
               <p class="data"> <Span class="head"> Recieve : 
               @if($wo->isReceived) <Span class="data"> Recieved &check;&check; </span>
               @else
               <a href="{{route('management.recieve-wo',$wo->id)}}"> <button class="btn btn-success"> Recieve </button> </a>
                 @endif </Span>
              
               </p>
               <p> 
                 <button type="update" id="update" class="btn btn-primary">Update Wo</button>
               </p>              
         
          </div>
          </div>
          <!--*************** edit *************************** -->
          <div class="card card-primary col-md-12" id="update_div">
              <div class="card-header">
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
                   <option disabled>Select / Insert Client</option>
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
                    <input type="number" step="0.01" min="0" class="form-control"
                    value="{{$wo->client_rate}}" name="client_rate" id="client_rate" placeholder="Enter Rate">
                 </div>
                </div>  
          
          <div class="row col-sm-12">
          <div class="form-group col-sm-6">
                    <label class="form-control-label" for="from_language">From Language <span
                    class="required">*</span></label>
                    <select class=" form-control" data-live-search="true" name="from_language" id="from_language">
                   <option disabled >Select / Insert Language</option>
                   @foreach($languages as $language)
                    <option
                        value="{{$language['name']}}" >
                        {{$language['name']}}
                    </option>
                     @endforeach
                    </select>
                  </div>
                  <div class="form-group col-sm-6">
                    <label class="form-control-label" for="to_language">To Language <span
                    class="required">*</span></label>
                    <select class=" form-control" data-live-search="true" name="to_language" id="to_language">
                   <option disabled >Select / Insert Language</option>
                   @foreach($languages as $language)
                    <option
                        value="{{$language['name']}}" >
                        {{$language['name']}}
                    </option>
                     @endforeach
                    </select>
                  </div>
            </div>
            <div class="row">  
                    <div class="form-group col-md-6" style="position:relative;top:-11px;">
                    <label for="exampleInputFile">Deadline <span class="required"> *</span> </label>
                    <div style="padding:10px;" class="input-append date form_datetime" data-date="2020-12-21T15:25:00Z">
                      <input name="deadline" style="width:90%; height:40px; " size="16"
                      value="{{ UTC_To_LocalTime($wo->deadline, Auth::user()->timezone)}}" type="text" value="" readonly>
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
              <input type="number" min="1" class="form-control" name="words_count"
              value="{{$wo->words_count}}" id="words_count" placeholder="Enter ..">

            </div> 
            <div class="form-group col-md-6">
                <label class="form-control-label" for="quality_points">Quality Points<span
                    class="required">*</span></label>
                <input type="number" min="1" class="form-control" name="quality_points"
                value="{{$wo->quality_points}}" id="quality_points" placeholder="Enter ..">

                  </div>
            
                </div>  
                <div class="row">  
                 <div class="col-sm-6">
                      <!-- textarea -->
                      <div class="form-group">
                        <label>Client Instructions</label>
                        <textarea class="form-control" name="client_instructions"
                        value="{{$wo->client_instructions}}" rows="3" placeholder="Enter ..."></textarea>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <!-- textarea -->
                      <div class="form-group">
                        <label>General Instructions</label>
                        <textarea class="form-control" name="general_instructions" 
                        value="{{$wo->general_instructions}}" rows="3" placeholder="Enter ..."></textarea>
                      </div>
                    </div>
                   </div>
                 
            
                
                
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Update</button>
                </div>
              </form>
            </div>
                <br>
                      <div class="card col-md-12">
                  <div class="card-header">
                  <h4 style="position:relative; top:10px;"> WO Projects </h4>
                  <button type="button" class="btn btn-success" style=" float: right; margin-right:10px;"> 
                          <a href="{{route('management.select-projectType', $wo->id )}}">
                         + ADD PROJECT </a>
                          </button>
                  </div>
                  <div class="card-body">
                  @php $i=0; @endphp
                  @foreach($projects as $project)
                  @php $i++; @endphp
                      <div class="card" style="margin-bottom:15px;">
                        <div class="card-header">
                        <h5> Project #  {{$i}}  </h5>
                        </div>
                        <div class="card-body">
                          <div class="row col-md-12">
                            <div class="col-md-3">
                            <p class="head">  ID </p>
                            <p class="data">  {{$project->id}} </p>
                            </div>
                            <div class="col-md-3">
                            <p class="head"> Created at </p>
                              <p class="data"> 
                              {{ UTC_To_LocalTime($project->created_at, Auth::user()->timezone)}}
                            
                              </p>
                            </div>
                            
                            <div class="col-md-3">
                            <p class="head">  Type </p>
                            <p class="data">  
                            {{$project->type}}
                            </p>
                            </div>
                            <div class="col-md-3">
                            <p class="head">  Status </p>
                            <p class="data">   {{$project->status}} </p>
                            </div>
                        
                        </div>
                        <button type="ok" class="btn btn-primary" style=" float: right; margin-right:10px;"> 
                          <a href="{{route('management.view-project',$project->id)}}">
                          See Full Project </a>
                          </button>
                        </div>
                      </div>
                      @endforeach
                    </div>
                    </div>                  
              </div>
              <!-- /.card-body -->
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
})    
</script>
     
@endsection
@endsection
