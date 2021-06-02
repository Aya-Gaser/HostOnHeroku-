@extends('admins.layouts.app')
@section('style')
<style>

#edit_div_invoice{
  display : none;
}
.data2,.head2{
    font-size:13px;
    font-family:verdana; 
    color:#c51d1d;
}
.data2{
  font-weight:bold;
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
            <h1></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('management.dashboard')}}">Home</a></li>
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
              <p class="data col-md-4"> <Span class="head"> Vendor Name: </Span>  {{App\User::find($invoice['vendor_id'])->name }} </p>
                        
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
                                WO ID
                            </th>
                            <th style="width: ">
                            Task
                            </th>
                           
                            <th style="width:  " >
                            Rate Unit
                            </th>
                            
                            <th style="width:">
                            Rate
                            </th>
                            <th style="width:  " >
                           Unit Count
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
                            {{str_pad(App\projectStage::find($invoiceItem->stageId)->wo_id, 4, "0", STR_PAD_LEFT )}}
                            </td>
                            
                            <td>
                            {{App\projectStage::find($invoiceItem->stageId)->type}}
                           
                            </td>
                            
                            <td>
                            {{$invoiceItem->rate_unit}} <br>
                               <span class="data2 col-md-4"> <Span class="head2"> System : </Span>  {{App\projectStage::find($invoiceItem->stageId)->vendor_rateUnit}}  </span> 
                            </td>
                            <td> 
                            {{$invoiceItem->rate}} <br>
                               <span class="data2 col-md-4"> <Span class="head2"> System : </Span>  {{App\projectStage::find($invoiceItem->stageId)->vendor_rate}}   </span>                      
                            </td>
                            <td> 
                            {{$invoiceItem->unit_count}} <br>
                               <span class="data2 col-md-4"> <Span class="head2"> System : </Span>  {{App\projectStage::find($invoiceItem->stageId)->vendor_unitCount}}  </span>                    
                            </td>
                            <td>
                            {{ UTC_To_LocalTime($invoiceItem['created_at'], Auth::user()->timezone)}} 
                            </td>
                            <td>
                            {{$invoiceItem->amount}} <br>
                               <span class="data2 col-md-4"> <Span class="head2"> System : </Span>  {{App\projectStage::find($invoiceItem->stageId)->vendor_unitCount * App\projectStage::find($invoiceItem->stageId)->vendor_rate}}  </span>                     
                            </td>
                          
                          </tr>
                            
                            @endforeach
                
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
                            
                        
                            @endforeach
                        </tr>
                
                    </tbody>
                </table>
                </div>
        <!-- /.card-body -->
        </div>
         @endif
           @if($invoice->status == 'Approved')
                <div class="card-footer" id="generatedInvoice_btns" style="text-align:right;">
                <span class="data col-md-4" style="padding-right: 56px;"> <Span class="head"> Total: </Span>  {{$invoice->total}} </span>

                    <button id="invoicePayment" type="ok" class="btn btn-success">Mark as Paid &check;&check; </button>                   
                    
               </div>
            @endif   
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
 
    $('#invoicePayment').click(function(){ 
       
        let formData = new FormData(document.getElementById('invoice-form'));
        $.ajax({
                data: formData,
                url: "{{route('management.invoice-payment') }}",
                type: 'POST',
                contentType: false,
                processData: false,
                success: (response) => {
                    if(response){
                    //this.reset();
                    //console.log(response) 
                    swal("Done Successfully", {
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
