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
      <div class="col-md-10">
            <div class="card card-success shadow-sm">
              <div class="card-header">
                <h2 class="card-title"> Project {{$wo->id}} </h2>

                

                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <p> <Span class="data"> Project Type : </Span> {{$stage->type}} </p>
              <p> <Span class="data">  Language  : </Span>{{$wo->from_language}} ▸ {{$wo->to_language}} </p>
              <p> <Span class="data">  Word Count  : </Span>{{$wo->words_count}} </p>
              <p> <Span class="data">  Rate  : </Span>{{$stage->vendor_rate}} </p>
              <p> <Span class="data"> Final Delivery Deadline  : </Span>
              {{UTC_To_LocalTime($stage->deadline,
                                        Auth::user()->timezone) }}
               </p>
              <p> <Span class="data"> Offer Expires Date :  </Span>
              @php $date = ($group == 1)? 'G1_acceptance_deadline' : "G2_acceptance_deadline"; @endphp
              {{UTC_To_LocalTime($stage->$date,
                                        Auth::user()->timezone) }}
                 </p>
              
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
                                   
                                </li>
                                <div class="clearfix mb-2"></div>
                            @empty
                                <li class="text-danger">No documents found</li>
                            @endforelse
                            <br>
                            <h4> Reference files </h4>
                           <br>
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
                            <h4> Target files </h4>
                            <br>
                            @forelse($target_files as $file)                               
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
                        </ul>
                    </div>
                </div>
                <div class="card-footer row" id="submit_div" style="text-align:right;">
                    <div class=" col-md-2" id="submit_div" >
                    <a href="{{ route('vendor.accept-offer',['stage_id'=> $stage->id,
                    'group'=> $group,'vendor'=> $vendor] )}}">
                      <button type="ok" class="btn btn-success ">ACCEPT</button>
                      </a>
                    </div> 
                    <div class="col-md-3" id="" > 
                    <a href="{{ route('vendor.decline-offer',['stage_id'=> $stage->id,
                    'group'=> $group,'vendor'=> $vendor] )}}">
                      <button type="ok" class="btn btn-danger ">DECLINE</button>
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
