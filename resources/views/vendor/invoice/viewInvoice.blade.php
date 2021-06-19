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
              <li class="breadcrumb-item active">View Invoice</li>
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
            <div class="card card-success shadow-sm" >
              <div class="card-header">
                <h2 class="card-title"> Invoice {{str_pad($invoice->id, 4, '0', STR_PAD_LEFT )}} </h2>

                

                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body ">
              <div class="row">
              <p class="data col-md-4"> <Span class="head"> Name: </Span>  {{App\User::find($invoice['vendor_id'])->name }} </p>
                        
              <p class="col-md-4 data"> <Span class="head"> Total:</Span> {{$invoice->total}} </p>
              <p class="col-md-4 data"> <Span class="head"> Status:</Span> {{$invoice->status}} </p>
              @if($invoice->status != 'Pending' && $invoice->status != 'Open')
                 <p class="col-md-4 data"> <Span class="head"> Notes:</Span> {{$invoice->note}} </p>
                @endif
               
            </div>  
            @if(count($invoice->vendorWorkInvoiceItem))
             <!-- ************* WORK ORDER INVOICE ITEMS *************** -->
             <div class="card card-info">
                <div class="card-header">
                <h2 class="card-title">Work Order Invoice Items</h2>
        
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                    </button>
                </div>
                </div>
                <div class="card-body p-0 table-responsive">
                <table class="table table-striped " id="">
                    <thead>
                        <tr>                            
                            <th style="width: " >
                                Project ID
                            </th>
                            <th style="width: ">
                            Task
                            </th>
                          
                            <th style="width:  " >
                             Unit
                            </th>
                            <th style="width:  " >
                             Unit Count
                            </th>
                            <th style="width:">
                            Rate
                            </th>
                            <th style="width: ">
                             Date
                            </th>
                           
                            <th style="width:">
                            Amount
                            </th>
                         </tr>
                    </thead>
                    <tbody id="">
                    @foreach ($invoice->vendorWorkInvoiceItem as $invoiceItem )
                    <tr>
                            <td> 
                            {{str_pad(App\WO::find(App\projectStage::find($invoiceItem->stageId)->wo_id)->client->code, 4, "0", STR_PAD_LEFT )}}-{{str_pad(App\projectStage::find($invoiceItem->stageId)->wo_id, 4, "0", STR_PAD_LEFT )}}

                            </td>
                            
                            <td>
                            {{App\projectStage::find($invoiceItem->stageId)->type}}
                           
                            </td>
                            <td>
                            {{$invoiceItem->rate_unit}}
                            </td>
                            <td>
                            {{$invoiceItem->unit_count}}
                            </td>
                            <td>
                            {{$invoiceItem->rate}}                        
                            </td>
                            <td>
                            {{ UTC_To_LocalTime($invoiceItem['created_at'], Auth::user()->timezone)}}
                            </td>
                           
                            <td>
                            {{$invoiceItem->amount}}                        
                            </td>
                            @if($invoice->status == 'Open' || $invoice->status == 'Rejected')
                            <td> 
                            <button type="button" class="btn btn-warning">
                              <a href="{{route('vendor.view-editWorkInvoice', $invoiceItem->id)}}"> 
                                Edit </a>
                             </button>    
                             <button type="button" class="btn btn-danger" onclick="delete_invoiceItem('{{$invoiceItem->id}}', 'workItem')">Delete </button>
                             </td>
                            @endif 
                            @endforeach
                        </tr>
                
                    </tbody>
                </table>
                </div>
        <!-- /.card-body -->
        </div>
         @endif

         @if(count($invoice->vendorNonWorkInvoiceItem))
             <!-- ************* NON WORK ORDER INVOICE ITEMS *************** -->
             <div class="card card-dark">
                <div class="card-header">
                <h2 class="card-title">Non Work Order Invoice Items</h2>
        
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                    </button>
                </div>
                </div>
                <div class="card-body p-0 table-responsive">
                <table class="table table-striped " id="">
                    <thead>
                        <tr>                            
                           
                            <th style="width:">
                            Invoice Item
                            </th>
                            <th style="width:25%">
                            Note
                            </th>
                            <th style="width:  " >
                            Date
                            </th>
                            <th></th> <th></th>
                            <th style="width:">
                            Amount
                            </th>
                            
                        </tr>
                    </thead>
                    <tbody id="">
                    @foreach ($invoice->vendorNonWorkInvoiceItem as $invoiceItem )
                    <tr>
                           
                            <td>
                            {{$invoiceItem->invoice_item}}
                            </td>
                            <td>
                            {{$invoiceItem->note}}                        
                            </td>
                            <td>
                            {{ UTC_To_LocalTime($invoiceItem['created_at'], Auth::user()->timezone)}}
                            </td>
                            <td></td> <td></td>
                            <td>
                            {{$invoiceItem->amount}}                        
                            </td>
                            @if($invoice->status == 'Open')
                            <td> 
                            <button type="button" class="btn btn-warning">
                              <a href="{{route('vendor.view-editNonWorkInvoice', $invoiceItem->id)}}"> 
                                Edit </a>
                             </button>
                            <button type="button" class="btn btn-danger" onclick="delete_invoiceItem('{{$invoiceItem->id}}', 'nonWork')">Delete </button>
                             </td>
                            @endif 
                        
                            @endforeach
                        </tr>
                
                    </tbody>
                </table>
                </div>
               
        <!-- /.card-body -->
        </div>
         @endif
           
                <div class="card-footer " id="generatedInvoice_btns" style="text-align:right;">
                <span class="data col-md-4" style="padding-right: 56px;"> <Span class="head"> Total: </Span>  {{$invoice->total}} </span>
                @if($invoice->status == 'Open')
                    <button id="submitInvoice" type="ok" class="col-md-2 btn btn-success" @if($invoice->total <= 0) disabled @endif >Submit</button>                   
                @endif 
                @if($invoice->status == 'Rejected')
                    <button id="submitInvoice" type="ok" class="col-md-2 btn btn-success" @if($invoice->total <= 0) disabled @endif >Re-Submit</button>                   
                @endif           
               </div>
            
               </div>
              </div>
            </div> 
            
               <!-- **************** EDIT INVOICE **************************************** -->
               <form id="invoice-form" action="" method="post" enctype="multipart/form-data">
              @csrf

              <input type="hidden" id="invoiceId" name="invoiceId" value="{{$invoice->id}}">

              </form>

            
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
      </div>
      <form id="delete-invoiceItem" action="" method="post" enctype="multipart/form-data">
              @csrf
        <input type="hidden" name="invoiceItem_type" id="invoiceItem_type">
        <input type="hidden" name="invoiceItem_id" id="invoiceItem_id">
        
      </form>
       
           
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
  function delete_invoiceItem(invoiceId, invoiceType){
      $('#invoiceItem_id').val(invoiceId);
      $('#invoiceItem_type').val(invoiceType);
    

    // $('#delete_invoiceItem').click(function(){
    swal({
          title: "Are you sure?",
          text: "You will not be able to recover this data!",
          type: "warning",
          
          buttons: true,
          dangerMode: true,
      })
      .then((willDelete) => {
            if (willDelete) {
              let formData = new FormData(document.getElementById('delete-invoiceItem'));
          $.ajax({
          data: formData,
          url:" {{route('vendor.delete-invoiceItem')}}",
          type: 'POST',
          dataType: 'json',
          contentType: false,
          processData: false,
        
          //  category_id: category_id,
          
          success:function(response) {
            if(response){
                //this.reset();
                //console.log(response) 
                swal("Done! Deleted Successfully", {
                icon: "success"
              }).then((ok) =>{
                window.location.reload();
              }) 
            }
          },
          error: function(data) { 
              console.log(data);
            }
          })           
            } else {
              swal("Your data is safe!");
            }
          });
       
  }

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

    $('#submitInvoice').click(function(){ 
      document.body.style.cursor='wait';           

        let formData = new FormData(document.getElementById('invoice-form'));
        $.ajax({
                data: formData,
                url: "{{route('vendor.submit-invoice') }}",
                type: 'POST',
                contentType: false,
                processData: false,
                success: (response) => {
                    if(response){
                    //this.reset();
                    //console.log(response) 
                    swal("Done! Added Successfully", {
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

    /// delete
});    



</script>
@endsection 
@endsection
