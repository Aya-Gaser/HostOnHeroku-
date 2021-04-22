<?php

namespace App\Http\Controllers\vendor\invoice;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\projectStage;
use App\vendorInvoice;
use App\vendorWorkInvoiceItem;
use Auth;
//  'stageId' => 'required|unique:project_stages,id',
class invoiceController extends Controller
{
    public function __construct()
     {
         $this->middleware('auth');
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

        $stage = projectStage::find($request->input('stageId'));
        $stage->status = 'invoiced';
        $stage->save();

        return response()->json([ 'success'=> 'Form is successfully submitted!']);

    }

    public function checkOpenInvoice($vendor_id){
        $openInvoice = vendorInvoice::where('vendor_id', $vendor_id)
                                    ->where('status', 'open')->first();
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

    public function viewAllInvoices(){
        $invoices = vendorInvoice::where('vendor_id', Auth::user()->id)->get();

        return view('vendor.invoice.viewAllInvoices')->with(['invoices'=>$invoices]);
    }

    public function viewInvoice($invioce_id){
        $invoice = vendorInvoice::find($invioce_id);

        return view('vendor.invoice.viewInvoice')->with(['invoice'=>$invoice]);
    }
}
