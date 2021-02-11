


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
     

      <div class="row">
      <div class="col-md-12">
            <div class="card card-success shadow-sm">
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
              <p class="col-md-6 data"> <Span class="head"> ID  : </Span>{{$project->wo_id}} </p>
              <p class="col-md-6 data"> <Span class="head"> Started At : </Span>
              {{UTC_To_LocalTime($project->created_at,
                                        Auth::user()->timezone) }}  </p>
              <p class="col-md-6 data"> <Span class="head">  Language  : </Span>{{$wo->from_language}} ▸ {{$wo->to_language}} </p>
              <p class="col-md-6 data text-danger"> <Span class="head"> Deadline  : 
              </Span>{{UTC_To_LocalTime($stage->deadline,
                                        Auth::user()->timezone) }}
               </p>
              
    
              
              <p class="data col-md-6"> <Span class="head">  Word Count  : </Span>
              @if($stage->vendor_wordsCount) {{$stage->vendor_wordsCount}} @else 
              <span class="pending">  Target </span> @endif</p>
              <p class="data col-md-6"> <Span class="head">  Quality Points  : </Span>
              @if($stage->vendor_qualityPoints) {{$stage->vendor_qualityPoints}} 
              @else <span class="pending">  Target </span> @endif</p>
              <p class="data col-md-6"> <Span class="head">  Rate Unit  : </Span>{{$stage->vendor_rateUnit}} </p>
              <p class="data col-md-6"> <Span class="head">  Rate  : </Span>{{$stage->vendor_rate}} </p>

              
              <p class="col-md-6 data"> <Span class="head"> Instruction : 
              </Span> {{  $stage->instructions }} </p>
              <p class="col-md-6 data"> <Span class="head"> Sent Files Number : 
              </Span> {{  $stage->required_docs }} </p>
              
              <p class="col-md-6 data"> <Span class="head"> Deadline Time Left : 
              </Span>  {!! $deadline_difference !!} </p>
              <p class="data col-md-6"> <Span class="head"> Status  : </Span>
                  {{$stage->status}} </p>
              </div>
              <div class="col-sm-12 col-md-12">
                    <div class="form-group">
                    <br>
                    
              <h4> Reference files </h4>
                           <br>
                           <ul>
                            @forelse($reference_file as $file)                               
                                <li class="text-primary">
                                    <a href="{{asset('storage/'.$file['file'])}}"
                                       download="{{$file['name']}}">
                                        {{str_limit($file['file_name'],50)}}
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
                  
                    <br>
                        <br>
                       
                        <div class="card">
                          <div class="card-header">
                            <h5> Working Files  
                             </h5>
                          </div>
                          <div class="card-body">
                          <div class="table-responsive">
                                 <table class="table table table-striped">
                                    <thead>
                                        <tr>
                                       
                                        <th width="25%">Working File</th>
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
                                      
                                    
                                       
                                      
                                              
                                              @if(isset( $deliver_withFiles->thisVendor_delivery[$source_file->id]))
                                              <td> 
                                              <p> 
                                              <a href="{{asset('storage/'.$deliver_withFiles->thisVendor_delivery[$source_file->id][0]->file)}}"
                                       download="{{$deliver_withFiles->thisVendor_delivery[$source_file->id][0]->file_name}}">
                                        {{str_limit($deliver_withFiles->thisVendor_delivery[$source_file->id][0]->file_name,50)}}
                                    </a>
                                              
                                              </p>
                                              <p> {{UTC_To_LocalTime($deliver_withFiles->thisVendor_delivery[$source_file->id][0]->created_at,
                                        Auth::user()->timezone) }} <br>
                                        {!! $deliver_withFiles->thisVendor_delivery[$source_file->id][0]->deadline_difference !!}
                                              </p>
                                              @if($deliver_withFiles->thisVendor_delivery[$source_file->id][0]->status != 'accepted')
                                              <p>
                                              <form action="{{route('vendor.resend-delivery',
                                    ['stage'=> $stage->id,
                                     'delivery'=>$deliver_withFiles->thisVendor_delivery[$source_file->id][0]->id])}}" method="post" enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-group">
                                                    <div class="file-loading">  
                                                    <input id="reference_files" name="delivery_file{{$stage->id}}" required
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
                                              <p><b>Notes</b> :  {{$deliver_withFiles->thisVendor_delivery[$source_file->id][0]->notes}} </p>
                                              </td>
                                              @else
                                             
                                             
                                             
                                              <td>
                                            <p>
                                            <form action="{{route('vendor.send-delivery',['stage'=> $stage->id,
                                              'sourceFile'=>$source_file->id])}}" method="post" enctype="multipart/form-data">
                                             @csrf
                                             <div class="form-group">
                                                    <div class="file-loading">  
                                                    <input id="reference_files" name="delivery_file{{$stage->id}}" required
                                                      class="kv-explorer " type="file">  
                                                      </div>
                                                </div>
                                        <button type="submit" class="btn btn-primary" > 
                                             upload delivery</button>
                                        </form>     
                                            </p> 
                                            </td>  <td></td>
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
                                        <p class="head"> Delivery date </p>
                                        <p class="data">  {{UTC_To_LocalTime($delivery->created_at,
                                        Auth::user()->timezone) }}
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
             </div>
           </div>
          </div>
      </div>
       
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

@section('script')
<script>
$(function () {
   // $('#modal').fadeOut()
  bsCustomFileInput.init();
 /* 
$('#myinput').on('click',function(){
      $('#modal').fadeIn();
  })
  $('#close').on('click',function(){
      $('#modal').fadeOut();
  }) */
});
</script>

@include('layouts.partials._file_input_plugin_script')

@endsection
@endsection

