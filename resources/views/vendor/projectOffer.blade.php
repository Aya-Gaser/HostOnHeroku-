@extends('vendor.layouts.app')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Job Offer</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('vendor.dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active">Job Offer</li>
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
                <h2 class="card-title"> Project {{str_pad($wo->id, 4, "0", STR_PAD_LEFT )}} </h2>

                

                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body ">
              <div class="row">
              <p class="data col-md-6"> <Span class="head"> Project Type: </Span> {{$stage->type}} </p>
              <p class="data col-md-6"> <Span class="head">  Language: </Span>{{$wo->from_language}} ▸ {{$wo->to_language}} </p>
              <p class="data col-md-6"> <Span class="head">  Word Count: </Span>
              @if($stage->vendor_unitCount) {{$stage->vendor_unitCount}}
               @else <span class="pending">  Target </span> @endif</p>
              <p class="data col-md-6"> <Span class="head"> MAX Quality Points: </Span>
              @if($stage->vendor_maxQualityPoints) {{$stage->vendor_maxQualityPoints}}
               @else <span class="pending">  Target </span> @endif</p>
              <p class="data col-md-6"> <Span class="head">  Rate Unit: </Span>{{$stage->vendor_rateUnit}} </p>
              <p class="data col-md-6"> <Span class="head">  Rate: </Span>{{$stage->vendor_rate}} </p>
              <p class="col-md-6 data"> <Span class="head"> Instruction: 
              </Span> {{  $stage->instructions }} </p>
              <p class="col-md-6 data"> <Span class="head"> Number of Working Document(s): 
              </Span> {{  $stage->required_docs }} </p>
              <p class="data text-danger col-md-6"> <Span class="head"> Final Delivery Deadline: </Span>
              {{UTC_To_LocalTime($stage->deadline,
                                        Auth::user()->timezone) }}
               </p>
              <p class="data text-danger col-md-6"> <Span class="head"> Offer Expires on:  </Span>
              @php $date = ($group == 1)? 'G1_acceptance_deadline': "G2_acceptance_deadline"; @endphp
              {{UTC_To_LocalTime($stage->$date,
                                        Auth::user()->timezone) }}
                 </p>
            </div>  
              <div class="col-sm-6 col-md-4">
                    <div class="form-group">
                    <br>
                        <h4> Working Document(s) </h4>
                        <br>
                        
                            @forelse($source_files as $file)                                
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
                         <div class="col-sm-6 col-md-4">
                    <div class="form-group">
                    <br>
                        <h4> Source Document(s) </h4>
                        <br>
                        
                            @forelse($vendorSource_files as $file)                                
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
                           </div>
                         </div> 
                     <div class="col-sm-6 col-md-4">
                       <div class="form-group">
                            <h4> Reference Document(s) </h4>
                           <br>
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
                <div class="card-footer row" id="submit_div" style="text-align:right;">
                    <div class=" col-md-2" id="submit_div" >
                    <a href="{{route('vendor.accept-offer',['stage_id'=> $stage->id,
                    'group'=> $group,'vendor'=> $vendor] )}}">
                      <button onclick="document.body.style.cursor='wait';" type="ok" class="btn btn-success ">ACCEPT</button>
                      </a>
                    </div> 
                    <div class="col-md-3" id="" > 
                    <a href="{{route('vendor.decline-offer',['stage_id'=> $stage->id,
                    'group'=> $group,'vendor'=> $vendor] )}}">
                      <button onclick="document.body.style.cursor='wait';" type="ok" class="btn btn-danger ">DECLINE</button>
                      </a>
                    </div>
               </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
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
@endsection
