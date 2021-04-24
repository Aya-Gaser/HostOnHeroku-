<?php

namespace App\Http\Controllers\vendor\invoice;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
                              ->where('status', 'Completed')->get();
        return view('vendor.invoice.viewReady_workOrderInvoices')->with(['stages'=>$stages]);                        
    } 
    public function generateProjectInvoice($stageId){
        $stage = projectStage::findOrFail($stageId);
        if($stage->status != 'Completed')
            abort(404);
        return view('vendor.invoice.createProjectInvoice')->with(['stage'=>$stage]);
    }

    public function addProjectInvoice(Request $request){
        $request->validate([
            'completion_date' => 'required',
            'rate_unit'=>'required|in:Word Count,Page,Image,Flat,Hour',
            'words_count'=>'required|numeric',
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
        $workInvoiceItem->unit_count = $request->input('words_count');
        $workInvoiceItem->rate = $request->input('rate');
        $workInvoiceItem->total = $request->input('total');
        $workInvoiceItem->save();

        $stage = projectStage::findOrFail($request->input('stageId'));
        $stage->status = 'invoiced';
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
        return view('vendor.invoice.createNonWorkInvoice');
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
        
        return response()->json([ 'success'=> 'Form is successfully submitted!']);

    }
}
