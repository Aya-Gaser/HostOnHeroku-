


@extends('admins.layouts.app')

@section('content')  

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
              <li class="breadcrumb-item active">Select Project Type</li>
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
          <div class="col-md-8">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title" > Select Project Type </h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
            
                <div class="card-body">
                
                  </div>
            <!-- /.card -->

            <div class="card-footer" id="submit_div" style="text-align:center;">

                <a href="{{ route('management.create-project',['id'=> $wo_id,
                  'type'=> 'single'] )}}">
                 <button type="ok" class="btn btn-primary ">Single</button>
                        </a>
                <a href="{{ route('management.create-project',['id'=> $wo_id,
                    'type'=> 'linked' ] )}}">
                <button type="ok" class="btn btn-success ">Linked</button>
                </a>        
                </div>
             
            </div>
      <div class="row">
      <div class="col-md-12">
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
              <p class="data"> <Span class="head"> ID : </Span>{{$wo->id}} </p>
              <p class="data"> <Span class="head"> Deadline  : </Span>
              {{ UTC_To_LocalTime($wo->deadline, Auth::user()->timezone)}}
               </p>
              <p class="data"> <Span class="head"> Client Number : </Span> {{App\client::find($wo->client_id)->code}} </p>
              <p class="data"> <Span class="head"> Client Rate  : </Span>{{$wo->client_rate}} </p>
              <p class="data"> <Span class="head"> From Language  : </Span>{{$wo->from_language}} </p>
              <p class="data"> <Span class="head"> To Language  : </Span>{{$wo->to_language}} </p>
              <p class="data"> <Span class="head"> Created At : </Span>
              {{ UTC_To_LocalTime($wo->created_at, Auth::user()->timezone)}}
                </p>
              </div>
             
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
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

 </div>
@endsection


