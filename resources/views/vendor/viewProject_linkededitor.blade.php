

@extends('vendor.layouts.app')

@section('content')


@section('style')
<style>
td{
  white-space: normal;
  word-break: break-all;
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
            <h1>My Projects</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('vendor.dashboard')}}">Home</a></li>
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
      <div class="col-md-12">
            <div class="card card-primary shadow-sm">
              <div class="card-header">
                <h3 class="card-title">Project Details </h3>

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
              <p class="col-md-6 data"> <Span class="head"> ID: </Span>@if($project->WO->client) {{$project->WO->client->code}} - @endif{{str_pad($project->WO->id, 4, "0", STR_PAD_LEFT )}} - {{$project->id}}  </p>
              <p class="col-md-6 data"> <Span class="head"> Started on: </Span>
              {{UTC_To_LocalTime($project->created_at,
                                        Auth::user()->timezone) }}  </p>
              <p class="col-md-6 data"> <Span class="head">  Language: </Span>{{$wo->from_language}} ▸ {{$wo->to_language}} </p>
              <p class="col-md-6 data text-danger"> <Span class="head"> Deadline: 
              </Span>{{UTC_To_LocalTime($stage->deadline,
                                        Auth::user()->timezone) }}
               </p>
              
    
              
              <p class="data col-md-6"> <Span class="head">  Word Count: </Span>
              @if($stage->vendor_wordsCount) {{$stage->vendor_wordsCount}} @else 
              <span class="pending">  Target </span> @endif</p>
              <p class="data col-md-6"> <Span class="head"> MAX Quality Points: </Span>
              @if($stage->vendor_maxQualityPoints) {{$stage->vendor_maxQualityPoints}} 
              @else <span class="pending">  Target </span> @endif</p>
              <p class="data col-md-6"> <Span class="head">  Rate Unit: </Span>{{$stage->vendor_rateUnit}} </p>
              <p class="data col-md-6"> <Span class="head">  Rate: </Span>{{$stage->vendor_rate}} </p>
              
              <p class="col-md-6 data"> <Span class="head"> Instruction: 
              </Span> {{  $stage->instructions }} </p>
              <p class="col-md-6 data"> <Span class="head"> Sent Files Number: 
              </Span> {{  $stage->required_docs }} </p>
              
              <p class="col-md-6 data"  style="color:black;"> <Span class="head"> Time until Deadline: 
              </Span>  {!! $deadline_difference !!} </p>
              <p class="data col-md-6"> <Span class="head"> Status: </Span>
                  {{$stage->status}} </p>
              </div>   
              <div clas="row">
              <div class="col-sm-6 col-md-6">
                    <div class="form-group">
                    <br>
                    
              <h4> Source Document(s) </h4>
                           <br>
                           <ul>
                            @foreach($vendorSource_files as $file)                               
                                <li class="text-primary">
                                    <a href="{{asset('storage/'.$file['file'])}}"
                                       download="{{$file['file_name']}}">
                                        {{str_limit($file['file_name'],50)}}
                                    </a>
                                    
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
                                   
                                </li>
                                <div class="clearfix mb-2"></div>
                            @empty
                                <li class="text-danger">None</li>
                            @endforelse
                            <br>
                           
             
                            </ul>
                    </div>
                   </div>  
              <div class="col-sm-6 col-md-6">
                    <div class="form-group">
                    <br>
                    
              <h4> Reference Document(s) </h4>
                           <br>
                           <ul>
                            @forelse($reference_file as $file)                               
                                <li class="text-primary">
                                    <a href="{{asset('storage/'.$file['file'])}}"
                                       download="{{$file['file_name']}}">
                                        {{str_limit($file['file_name'],50)}}
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
                    <br><br>
                    @if($project->status == 'reviewed')
                    <div class="card card-success">
                          <div class="card-header">
                            <h5> Reviewed Document(s)  
                             </h5>
                          </div>
                          <div class="card-body">
                          <div class="table-responsive">
                            <table class="table table table-striped">
                              <thead>
                                  <tr>
                                  
                                  <th width="">Working Document</th>
                                  <th width="">Reviewed Document</th>
                                  </tr>
                              </thead>
                              <tbody>
                            @foreach($project->project_sourceFile as $file)                                
                                <tr>
                                 <td> 
                                <li class="text-primary">
                                  <a href="{{asset('storage/'.$file['file'])}}"
                                       download="{{$file['file_name']}}">
                                       {{str_limit($file->file_name,50)}}
                                  </a>
                                   
                                </li>
                              </td>
                             <td> 
                             <ul>
                             @foreach($file->proofed_vendorFile as $proofed)  
                             
                             <li class="text-primary">
                                  <a href="{{asset('storage/'.$proofed['file'])}}"
                                       download="{{$proofed['file_name']}}">
                                       {{str_limit($proofed->file_name,50)}}
                                  </a>
                                   
                                </li>
                              NOTES:  {{$proofed['note']}}  
                             @endforeach   
                             </ul>
                            </td>
                            
                            </tr>
                            @endforeach
                            </tbody>
                            </table>
                           </div>
                         </div> 
                       </div>    
                     @endif
                      
                        <div class="card card-dark">
                          <div class="card-header">
                            <h5> Working Document(s)    </h5>
                          </div>
                          <div class="card-body">
                          <div class="table-responsive">
                                 <table class="table table table-striped">
                                    <thead>
                                        <tr>
                                       
                                        <th width="25%">Source Document</th>
                                        <th width="25%">Translated</th>
                                        <th width="13%">Status / Actions</th>
                                        <th width="25%">Delivery</th>
                                        <th width="12%">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                   
                                    @foreach($deliver_withFiles->project_sourceFile as $source_file)
                                      <tr>
                                       <td> 
                                       <a href="{{asset('storage/'.$source_file->file)}}"
                                       download="{{$source_file->file_name}}">
                                        {{str_limit($source_file->file_name,50)}}
                                    </a>
                                       </td> 
                                      
                                     @if(isset( $deliver_withFiles->translator_delivery[$source_file->id]))
                                       
                                       <td> <p class="data">
                                       <a href="{{asset('storage/'.$deliver_withFiles->translator_delivery[$source_file->id][0]->file)}}"
                                       download="{{$deliver_withFiles->translator_delivery[$source_file->id][0]->file_name}}">
                                        {{str_limit($deliver_withFiles->translator_delivery[$source_file->id][0]->file_name,50)}}
                                    </a>
                                       </p>
                                       <p class="data"> {{$deliver_withFiles->translator_delivery[$source_file->id][0]->created_at}} </p>
                                       </td>
                                     
                                        @if($deliver_withFiles->translator_delivery[$source_file->id][0]->status == 'pending')
                                        <td>
                                        <button type="button" class="btn btn-success action accept" id="{{$deliver_withFiles->translator_delivery[$source_file->id][0]->id}}"
                                        data-toggle="modal" data-target="#modal-actionNote">
                                           Accept
                                          </button>
                                          <br><br>
                                       
                                        <button type="button" class="btn btn-danger action reject" id="{{$deliver_withFiles->translator_delivery[$source_file->id][0]->id}}"
                                        data-toggle="modal" data-target="#modal-actionNote">
                                           Reject
                                          </button>
                                       
                                         </td> 
                                         <td></td>
                                        @else 
                                        <td>
                                              {{$deliver_withFiles->translator_delivery[$source_file->id][0]->status}} <br> 
                                              <p><b>Notes</b>:  {{$deliver_withFiles->translator_delivery[$source_file->id][0]->notes}} </p>
                                              @if($deliver_withFiles->translator_delivery[$source_file->id][0]->improvedFiles)
                                                <ul>
                                                @foreach($deliver_withFiles->translator_delivery[$source_file->id][0]->improvedFiles as $improvedFile)   
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
                                              
                                             
                                              
                                              @if(isset( $deliver_withFiles->thisVendor_delivery[$source_file->id]))
                                              <td> 
                                              <p class="data">
                                              <a href="{{asset('storage/'.$deliver_withFiles->thisVendor_delivery[$source_file->id][0]->file)}}"
                                       download="{{$deliver_withFiles->thisVendor_delivery[$source_file->id][0]->file_name}}">
                                        {{str_limit($deliver_withFiles->thisVendor_delivery[$source_file->id][0]->file_name,50)}}
                                    </a> 
                                    <p> {{UTC_To_LocalTime($deliver_withFiles->thisVendor_delivery[$source_file->id][0]->created_at,
                                        Auth::user()->timezone) }} <br>
                                    {!! $deliver_withFiles->thisVendor_delivery[$source_file->id][0]->deadline_difference !!}
                                              </p>
                                              <p class="data">
                                               {{ $deliver_withFiles->thisVendor_delivery[$source_file->id][0]->created_at }}
                                              </p>
                                              @if($deliver_withFiles->thisVendor_delivery[$source_file->id][0]->status != 'accepted')
                                              <p class="data">
                                              
                                              <form action="{{route('vendor.resend-delivery',
                                                    ['stage'=> $stage->id,
                                                   'delivery'=>$deliver_withFiles->thisVendor_delivery[$source_file->id][0]->id])}}" method="post" enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-group">
                                                    <div class="file-loading">  
                                                    <input id="delivery_files" name="delivery_file{{$stage->id}}" required
                                                      class="kv-explorer " type="file">  
                                                      </div>
                                                </div>
                                          <button type="submit" class="btn btn-primary" > 
                                             Cancel & Re-submit </button>
                                          </form>   
                                             </p>
                                             @endif 
                                              </td>
                                              <td>
                                              {{ $deliver_withFiles->thisVendor_delivery[$source_file->id][0]->status }}
                                              <p><b>Notes</b>:  {{$deliver_withFiles->thisVendor_delivery[$source_file->id][0]->notes}} </p>
                                              </td>
                                              @else
                                             
                                             
                                             
                                              <td>
                                            <p class="data">
                                            <form id="deliveryForm" action="{{route('vendor.send-delivery',['stage'=> $stage->id,
                                              'sourceFile'=>$source_file->id])}}" method="post" enctype="multipart/form-data">
                                             @csrf
                                             <div class="form-group">
                                                    <div class="file-loading">  
                                                    <input id="delivery_files" name="delivery_file{{$stage->id}}" required
                                                      class="kv-explorer " type="file">  
                                                      </div>
                                                </div>
                                        <button type="submit" class="btn btn-primary" > 
                                             upload delivery</button>
                                        </form>     
                                            </p> 
                                            </td>  <td></td>
                                            @endif
                                           
                                          @endif
                                          <td> </td> <td></td> 
                                          @else
                                          <td style="color:red; font-size:23px;">
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
           <div class="card col-md-10">
             <div class="card-header">
             <h4> Delivery History </h4>
             </div>
             <div class="card-body">
             @php $i=0; @endphp
             @foreach($thisVendor_delivery as $delivery)
             @php $i++; @endphp
                             <div class="card" style="margin-bottom:15px;">
                                <div class="card-header">
                                <h5> Delivery #  {{$i}}  </h5>
                                </div>
                                <div class="card-body">
                                   <div class="row col-md-12">
                                        <div class="col-md-3">
                                        <p class="data" class="head"> Delivery date </p>
                                        <p class="data" class="data"> 
                                        {{UTC_To_LocalTime($delivery->created_at,
                                        Auth::user()->timezone) }} </p>
                                        </div>
                                        <div class="col-md-3">
                                        <p class="data" class="head"> Source File </p>
                                         <p class="data" class="data"> 
                                         <a href="{{asset('storage/'.App\woSourceFile::find($delivery->sourceFile_id)->file)}}"
                                       download="{{App\woSourceFile::find($delivery->sourceFile_id)->file_name}}">
                                        {{str_limit(App\woSourceFile::find($delivery->sourceFile_id)->file_name,50)}}
                                    </a>
                                         </p>
                                        </div>
                                       
                                        <div class="col-md-3">
                                        <p class="data" class="head"> #Delivered Document </p>
                                        <p class="data" class="data">  
                                        <a href="{{asset('storage/'.$delivery->file)}}"
                                       download="{{$delivery->file_name}}">
                                        {{str_limit($delivery->file_name,50)}}
                                    </a>
                                        </p>
                                        </div>
                                        <div class="col-md-3">
                                        <p class="data" class="head"> Delivery Status </p>
                                        <p class="data" class="data">   {{$delivery->status}} </p>
                                        </div>
                                   </div>
                                 </div> 
                                 </div> 

                               @endforeach   
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
                <input name="notes" type="text" class="form-control" placeholder="None .."> 
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
         
        <!-- /.row -->
      </div><!-- /.container-fluid -->
     
    </section>
    <!-- /.content -->
  </div>

@section('script')

<script>
$(function () {
   // $('#modal').fadeOut()
  bsCustomFileInput.init();
 
 
});

$('.action').click(function(){
  $deliveryId = $(this).attr('id');
  $('#deliveryId').val($deliveryId);  
 
});  
$('.reject').click(function(){
   $('#action').val('rejected');
});  
$('.accept').click(function(){
   $('#action').val('accepted');
});   
$('#reject-form').submit(function(e) {
  document.body.style.cursor='wait';
       e.preventDefault();
       let formData = new FormData(this);
  $.ajax({
        data: formData,
        url: "{{route('vendor.acion-on-deliveryFile') }}",
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
$('#deliveryForm').submit(function(e) {
           document.body.style.cursor='wait';           

        });
</script>
@include('layouts.partials._file_input_plugin_script')

@endsection

@endsection     

