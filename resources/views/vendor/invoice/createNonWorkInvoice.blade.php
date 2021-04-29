@extends('vendor.layouts.app')
@section('style')
<style>


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
            <h1></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('vendor.dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active">Non Work Invoice</li>
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
                <h2 class="card-title"> Create Non Work order Invioce </h2>
              </div>
              <div class="card-body">
            
              <!-- form start -->
              <form id="addInvoice-form" action="" method="post" enctype="multipart/form-data">
              @csrf
                <div class="card-body">
               
                <div class="row">
               
                <div class="form-group col-md-6">
                      <label class="form-control-label" for="vendor_rateUnit"> Invoice Item
                      <span class="required">*</span>
                      </label>
                      <input type="text" class="form-control" name="invoice_item" id="invoice_item"
                        placeholder="enter invoice item" required>
                       
                  </div>
               
                  <div class="form-group col-md-6">
                    <label class="form-control-label" for="words_count">Amount<span
                        class="required">*</span></label>
                    <input type="number" min="1" step="1" class="form-control" name="amount"
                      id="amount" placeholder="Enter amount " required>

                  </div>
                  
                   
                  <div class="form-group col-md-12">
                    <label for="exampleInputEmail1"> Note <span class="required">*</span></label>
                    <input type="text" class="form-control" 
                    name="note" id="note" required>
                  </div>
                </div>
                
                  </div>
            <!-- /.card -->

            <div class="card-footer" id="submit_div" style="text-align:right;">
                             
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


    $('#addInvoice-form').submit(function(e) {
       e.preventDefault();
       let formData = new FormData(this); 
      var url = "{{ route('vendor.view-vendorInvoice','id' )}}";
      
        //let formData = new FormData(document.getElementById('addInvoice-form'));
        $.ajax({
                data: formData,
                url: "{{route('vendor.add-nonWorkInvoice') }}",
                type: 'POST',
                contentType: false,
                processData: false,
                success: (response) => {
                    if(response){
                      response = JSON.parse(response.success);
                      $invoiceId = response['invoiceId'];
                      url = url.replace('id', $invoiceId);
                    swal("Done! Added Successfuly", {
                    icon: "success"
                    }).then((ok) =>{
                   // location.reload();
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
