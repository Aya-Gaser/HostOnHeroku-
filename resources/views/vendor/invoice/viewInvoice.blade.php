@extends('vendor.layouts.app')
@section('style')
<style>

#edit_div_invoice{
  display : none;
}

</style>

@endsection

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Create Work Order Invoice</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('vendor.dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active">Work Order Invoice</li>
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
            <div class="card card-success shadow-sm" >
              <div class="card-header">
                <h2 class="card-title"> Project {{str_pad($stage->wo_id, 4, '0', STR_PAD_LEFT )}} </h2>

                

                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body ">
              <div class="row">
              <p class="data col-md-6"> <Span class="head"> Project Type: </Span> {{$stage->type}} </p>
              <p class="data col-md-6"> <Span class="head"> Project Completion Date: </Span>
              {{UTC_To_LocalTime($stage->deadline,
                                        Auth::user()->timezone) }}
               </p>
              
              <p class="data col-md-6"> <Span class="head">  Rate Unit: </Span>{{$stage->vendor_rateUnit}} </p>
              <p class="data col-md-6"> <Span class="head">  Word Count: </Span>
              @if($stage->vendor_wordsCount) {{$stage->vendor_wordsCount}}
               @else <span class="pending">  Target </span> @endif</p>
              <p class="data col-md-6"> <Span class="head">  Rate: </Span>{{$stage->vendor_rate}} </p>
             
              <p class="col-md-6 data"> <Span class="head"> Total: 
              </Span> {{$stage->vendor_wordsCount * $stage->vendor_rate}} </p>
             
              
            </div>  
             
                <div class="card-footer" id="generatedInvoice_btns" style="text-align:right;">
                    <button id="editInvoice" class="btn btn-primary">Edit</button>
                    <button type="ok" class="btn btn-success submitInvoice">Add Invoice</button>                   
                    
               </div>
               </div>
              </div>
            </div> 
            
               <!-- **************** EDIT INVOICE **************************************** -->
          

            
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

@section('script')

<script>
$(function () {
    $('#editInvoice').click(function(){
        $('#edit_div_invoice').fadeIn();
        $('#generatedInvoice_btns').fadeOut();
        
        document.getElementById('edit_div_invoice').scrollIntoView({behavior: "smooth", block: "start", inline: "nearest"});
    });
    $('#rate').keyup(function () {
                var unit_count = $('#words_count').val();
                var rate = $('#rate').val();
                var total = unit_count * rate;
                $('#total').val(total);
            });


    $('#words_count').keyup(function () {
        var unit_count = $('#words_count').val();
        var rate = $('#rate').val();
        var total = unit_count * rate;
        $('#total').val(total);
    });

    $('.submitInvoice').click(function(){ 
       
        let formData = new FormData(document.getElementById('addInvoice-form'));
        $.ajax({
                data: formData,
                url: "{{route('vendor.add-workInvoice') }}",
                type: 'POST',
                contentType: false,
                processData: false,
                success: (response) => {
                    if(response){
                    //this.reset();
                    //console.log(response) 
                    swal("Done! Added Successfuly", {
                    icon: "success"
                    }).then((ok) =>{
                    location.reload();
                    }) 
                }
                    
                    },
                    error: function(data) { 
                    console.log(data);
                }
        });
    });

});
</script>
@endsection 
@endsection
