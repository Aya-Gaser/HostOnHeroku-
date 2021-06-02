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
              <p class="data col-md-6"> <Span class="head">  Unit Count: </Span>
              @if($stage->vendor_unitCount) {{$stage->vendor_unitCount}}
               @else <span class="pending">  Target </span> @endif</p>
              <p class="data col-md-6"> <Span class="head">  Rate: </Span>{{$stage->vendor_rate}} </p>
             
              <p class="col-md-6 data"> <Span class="head"> Total: 
              </Span> {{$stage->vendor_unitCount * $stage->vendor_rate}} </p>
             
              
            </div>  
             
                <div class="card-footer" id="generatedInvoice_btns" style="text-align:right;">
                    <button id="editInvoice" class="btn btn-primary">Edit</button>
                    <button type="ok" class="btn btn-success submitInvoice">Add Invoice</button>                   
                    
               </div>
               </div>
              </div>
            </div> 
            
               <!-- **************** EDIT INVOICE **************************************** -->
           <div class="card card-primary col-md-11" id="edit_div_invoice">
              <div class="card-header">
                <h3 class="card-title">Edit Invoice Details  </h3>
                <div class="card-tools">
                 
                 
                </div>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form id="addInvoice-form" action="" method="post" enctype="multipart/form-data">
              @csrf
                <div class="card-body">
               
                <div class="row">
                <input type="hidden" value="{{$stage->id}}" name="stageId" id="stageId">
                <div class="form-group-lg col-md-6" style="position:relative;top:-11px;">
                    <label for="exampleInputFile">Completion Date <span class="required"> *</span> </label>
                    <div style="padding:10px;" class="input-append date form_datetime" data-date="2013-02-21T15:25:00Z">
                      <input name="completion_date" style="width:90%; height:40px;" size="16"
                      class="form-control" value="{{UTC_To_LocalTime($stage->deadline, Auth::user()->timezone)}}" type="text" value="">
                      <span style="padding:8px 5px; height:40px;" class="add-on"><i class="icon-remove"></i></span>
                      <span style="padding:8px 5px; height:40px;" class="add-on"><i class="icon-calendar"></i></span>
                  </div>
                </div>
                <div class="form-group col-md-6">
                      <label class="form-control-label" for="vendor_rateUnit"> Unit
                      <span class="required">*</span>
                      </label>
                      <select class="form-control" name="rate_unit" id="rate_unit"
                        data-placeholder="select vendor Rate Unit" required>
                        <option disabled >Select</option>
                        <option value="Word Count" >Word Count  </option>
                        <option value="Hour" >Hour  </option>
                        <option value="Page" >Page  </option>
                        <option value="Image" >Image  </option>
                        <option value="Flat" >Flat  </option>
                      </select>
                  </div>
                </div>
                <div class="row">  
                  <div class="form-group col-md-6">
                    <label class="form-control-label" for="unit_count">Unit Count<span
                        class="required">*</span></label>
                    <input type="number" min="0" step="1" class="form-control" name="unit_count"
                     value="{{$stage->vendor_unitCount}}" id="unit_count" placeholder="Enter 0 if Target " required>

                  </div>
                  
                   
                  <div class="form-group col-md-6">
                    <label for="exampleInputEmail1"> Rate <span class="required">*</span></label>
                    <input type="number" step="0.01" min="0.01" class="form-control" 
                    name="rate" id="rate" value="{{$stage->vendor_rate}}" required>
                  </div>
                </div>
                <div class="row">
              
                <div class="form-group col-md-6">
                <label for="exampleInputEmail1">Total <span class="required">*</span></label>
                <input id="total" name="total" type="number" class="form-control" name="required_docs_{{$stage->id}}" value="{{$stage->vendor_unitCount * $stage->vendor_rate}}" required readonly>
              </div>
                </div>
          
         
         
            
                  </div>
            <!-- /.card -->

            <div class="card-footer" id="submit_div" style="text-align:right;">
               
                 <button type="button" onclick="location.reload()" class="btn btn-primary">Restore Default Details</button>
              
                <button type="submit" class="btn btn-success submitInvoice">Add</button>
                </div>
        </form>
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

@section('script')

<script>
$(function () {
    $('#editInvoice').click(function(){
        $('#edit_div_invoice').fadeIn();
        $('#generatedInvoice_btns').fadeOut();
        
        document.getElementById('edit_div_invoice').scrollIntoView({behavior: "smooth", block: "start", inline: "nearest"});
    });
    $('#rate').keyup(function () {
                var unit_count = $('#unit_count').val();
                var rate = $('#rate').val();
                var total = unit_count * rate;
                $('#total').val(total);
            });


    $('#unit_count').keyup(function () {
        var unit_count = $('#unit_count').val();
        var rate = $('#rate').val();
        var total = unit_count * rate;
        $('#total').val(total);
    });

    $('.submitInvoice').click(function(){ 
       url = "{{route('vendor.view-vendorInvoice', 'id' )}}"
        let formData = new FormData(document.getElementById('addInvoice-form'));
        var url = "{{ route('vendor.view-vendorInvoice','id' )}}";
        $.ajax({
                data: formData,
                url: "{{route('vendor.add-workInvoice') }}",
                type: 'POST',
                contentType: false,
                processData: false,
                success: (response) => {
                    if(response){
                      response = JSON.parse(response.success);
                      $invoiceId = response['invoiceId'];
                      url = url.replace('id', $invoiceId);
                    swal("Done! Added Successfully", {
                    icon: "success"
                    }).then((ok) =>{
                      window.location.href = url
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
