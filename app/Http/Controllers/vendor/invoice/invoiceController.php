<?php

namespace App\Http\Controllers\vendor\invoice;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\vendorInvoiceNotification;

use App\projectStage;
use App\vendorInvoice;
use App\vendorWorkInvoiceItem;
use Auth;
use App\vendorNonWorkInvoiceItem;
//  'stageId' => 'required|unique:project_stages,id',
class invoiceController extends Controller
{
    public function __construct()
     {
         $this->middleware('auth');
     }  

    public function viewReady_workOrderInvoices(){
        $stages = projectStage::where('vendor_id', Auth::user()->id)
                              ->where('readyToInvoice', 1)->get();
        return view('vendor.invoice.viewReady_workOrderInvoices')->with(['stages'=>$stages]);                        
    } 
    public function generateProjectInvoice($stageId){
        $stage = projectStage::findOrFail($stageId);
        if($stage->readyToInvoice != 1)
            abort(404);
        return view('vendor.invoice.createProjectInvoice')->with(['stage'=>$stage]);
    }

    public function addProjectInvoice(Request $request){
        $request->validate([
            'completion_date' => 'required',
            'rate_unit'=>'required|in:Word Count,Page,Image,Flat,Hour',
            'unit_count'=>'required|numeric',
            'rate'=>'required|numeric',
            'total'=>'required|numeric',
            'stageId' => 'required',
          ]);
        $invioce_id = 0;  
        $openInvoice = $this->checkOpenInvoice(Auth::user()->id); 
        if($openInvoice){
            $invioce_id = $openInvoice->id;
            $openInvoice->total =  $openInvoice->total + $request->input('total');
            $openInvoice->save();
        }
        else{
            $invioce_id = $this->createVendorInvoice(Auth::user()->id, $request->input('total'));
           
        }
        $workInvoiceItem = new vendorWorkInvoiceItem();
        $workInvoiceItem->stageId = $request->input('stageId');
        $workInvoiceItem->invoiceId = $invioce_id;
        $workInvoiceItem->rate_unit = $request->input('rate_unit');
        $workInvoiceItem->unit_count = $request->input('unit_count');
        $workInvoiceItem->rate = $request->input('rate');
        $workInvoiceItem->amount = $request->input('total');
        $workInvoiceItem->save();

        $stage = projectStage::findOrFail($request->input('stageId'));
        $stage->status = 'invoiced';
        $stage->readyToInvoice = 2;
        $stage->save();

        $data = json_encode(array('invoiceId'=>$invioce_id));
        return response()->json([ 'success'=> $data]);
    }

    public function checkOpenInvoice($vendor_id){
        $openInvoice = vendorInvoice::where('vendor_id', $vendor_id)
                                    ->where('status', 'Open')->first();
        if($openInvoice)
            return $openInvoice;
        return null;                                
    }
    public function createVendorInvoice($vendor_id, $total){
        $invoice = new vendorInvoice();
        $invoice->vendor_id = $vendor_id;
        $invoice->total = $total;
        $invoice->save();

        return $invoice->id;
    }
    public function createNonWorkInvoice(){
        return view('vendor.invoice.createNonWorkInvoice')->with(['isEdit'=>0]);
    }

    public function addNonWorkInvoice(Request $request){
        $request->validate([
            'invoice_item' => 'required',
            'amount'=>'required|numeric',
            'note'=>'required|string',
            
          ]);
        $invioce_id = 0;  
        $openInvoice = $this->checkOpenInvoice(Auth::user()->id); 
        if($openInvoice){
            $invioce_id = $openInvoice->id;
            $openInvoice->total =  $openInvoice->total + $request->input('amount');
            $openInvoice->save();
        }
        else{
            $invioce_id = $this->createVendorInvoice(Auth::user()->id, $request->input('amount'));
        }
        $nonworkInvoiceItem = new vendorNonWorkInvoiceItem();
        $nonworkInvoiceItem->invoiceId = $invioce_id;
        $nonworkInvoiceItem->invoice_item = $request->input('invoice_item');
        $nonworkInvoiceItem->amount = $request->input('amount');
        $nonworkInvoiceItem->note = $request->input('note');
        $nonworkInvoiceItem->save();
        
        $data = json_encode(array('invoiceId'=>$invioce_id));
        return response()->json([ 'success'=> $data]);

    }
    public function viewAllInvoices($filter){
        if(!$this->validateFilter($filter)) abort(404);
        if($filter == 'All')
            $invoices = vendorInvoice::where('vendor_id', Auth::user()->id)->get();
        else
            $invoices = vendorInvoice::where('vendor_id', Auth::user()->id)
                                     ->where('status', $filter)->get();
        return view('vendor.invoice.viewAllInvoices')->with(['invoices'=>$invoices]);
    }
    public function validateFilter($filter){
        $filters = ['Open', 'Pending', 'Approved', 'Rejected', 'Paid', 'All'];
        return in_array($filter, $filters); 
     }

    public function viewInvoice($invioce_id){
        $invoice = vendorInvoice::findOrFail($invioce_id);

        return view('vendor.invoice.viewInvoice')->with(['invoice'=>$invoice]);
    }

    public function submitInvoice(Request $request){
        $request->validate([
            'invoiceId' => 'required',
          ]);
        $invoice = vendorInvoice::findOrFail($request->input('invoiceId'));  
        $invoice->status = 'Pending';
        $invoice->save();
        // SEND NOTIFICATION MAIL TO VENDORS
        Mail::to('hoda.tarjamat@gmail.com')->send(new vendorInvoiceNotification($invoice->id));
        Mail::to('reeno.tarjamat@gmail.com')->send(new vendorInvoiceNotification($invoice->id));

        return response()->json([ 'success'=> 'Form is successfully submitted!']);

    }

    public function view_editNonWorkInvoice($invoiceItem_id){
        $nonworkInvoiceItem = vendorNonWorkInvoiceItem::findOrFail($invoiceItem_id);
        return view('vendor.invoice.createNonWorkInvoice')->with(['isEdit'=>1, 'invoiceItem'=>$nonworkInvoiceItem]);
    }
    public function editNonWorkInvoice(Request $request){
        $request->validate([
            'invoice_id' => 'required',
            'invoice_item' => 'required',
            'amount'=>'required|numeric',
            'note'=>'required|string',
            
          ]);
        $nonworkInvoiceItem = vendorNonWorkInvoiceItem::findOrFail($request->input('invoice_id')); 
        $nonworkInvoiceItem->invoice_item = $request->input('invoice_item');
        $oldAmount = $nonworkInvoiceItem->amount;
        $nonworkInvoiceItem->amount = $request->input('amount');
        $nonworkInvoiceItem->note = $request->input('note');
        $nonworkInvoiceItem->save();

        $vendorInvoice = vendorInvoice::findOrFail($nonworkInvoiceItem->invoiceId);
        $vendorInvoice->total = $vendorInvoice->total - $oldAmount;  //subtract old amount
        $vendorInvoice->total = $vendorInvoice->total + $request->input('amount'); // add new amount
        $vendorInvoice->save();
        
        $data = json_encode(array('invoiceId'=>$nonworkInvoiceItem->invoiceId));
        return response()->json([ 'success'=> $data]);

    }
    public function destroyInvoiceItem(Request $request){
        $request->validate([
            'invoiceItem_id' => 'required',
            'invoiceItem_type'=>'required'
        ]);
        if($request->input('invoiceItem_type') == 'workItem')
        {
            $invoiceItem = vendorWorkInvoiceItem::findOrFail($request->input('invoiceItem_id'));
            $stage = projectStage::find( $invoiceItem->stageId);
            $stage->status = 'Completed';
            $stage->readyToInvoice = 1;
            $stage->save();

        }
        else
            $invoiceItem = vendorNonWorkInvoiceItem::findOrFail($request->input('invoiceItem_id'));

        $vendorInvoice = vendorInvoice::findOrFail($invoiceItem->invoiceId);
        $vendorInvoice->total = $vendorInvoice->total - $invoiceItem->amount;
        $vendorInvoice->save();

        $invoiceItem->delete();
        return response()->json([ 'success'=> 'deleted successfully']);

            
    }

    public function view_editWorkInvoice($invoiceItem_id){
        $workInvoiceItem = vendorWorkInvoiceItem::findOrFail($invoiceItem_id);
        $stage = projectStage::find( $workInvoiceItem->stageId);

        return view('vendor.invoice.editProjectInvoice')->with(['stage'=>$stage, 'invoiceItem'=>$workInvoiceItem]);
    }
    public function editProjectInvoice(Request $request){
        $request->validate([
            'completion_date' => 'required',
            'rate_unit'=>'required|in:Word Count,Page,Image,Flat,Hour',
            'unit_count'=>'required|numeric',
            'rate'=>'required|numeric',
            'total'=>'required|numeric',
            'invoiceItemId' => 'required',
          ]);
       
        $workInvoiceItem = vendorWorkInvoiceItem::findOrFail($request->input('invoiceItemId'));
        $workInvoiceItem->rate_unit = $request->input('rate_unit');
        $workInvoiceItem->unit_count = $request->input('unit_count');
        $workInvoiceItem->rate = $request->input('rate');
        $oldAmount = $workInvoiceItem->amount;
        $workInvoiceItem->amount = $request->input('total');
        $workInvoiceItem->save();

        $vendorInvoice = vendorInvoice::findOrFail($workInvoiceItem->invoiceId);
        $vendorInvoice->total = $vendorInvoice->total - $oldAmount;  //subtract old amount
        $vendorInvoice->total = $vendorInvoice->total + $request->input('total'); // add new amount
        $vendorInvoice->save();

        $data = json_encode(array('invoiceId'=>$workInvoiceItem->invoiceId));
        return response()->json([ 'success'=> $data]);
    }


}
