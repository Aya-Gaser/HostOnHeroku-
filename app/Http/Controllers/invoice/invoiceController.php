<?php

namespace App\Http\Controllers\invoice;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\vendorInvoice;
use App\vendorWorkInvoiceItem;
use Auth;
use App\Mail\invoice\invoiceAction;
use App\Mail\invoice\invoicePyment;
use App\projectStage;
use App\User;
use Illuminate\Support\Facades\Mail;
class invoiceController extends Controller
{
    public function __construct()
      {
          $this->middleware('auth');
      } 

    public function viewAllInvoices($filter){
       if(!$this->validateFilter($filter)) abort(404);
       if($filter == 'All')
            $invoices = vendorInvoice::where('status', '<>' , 'Open')->get();
        else
            $invoices = vendorInvoice::where('status', $filter)->get();
        return view('admins.invoice.viewAllInvoices')->with(['invoices'=>$invoices]);    
    
    }

    
    public function validateFilter($filter){
        $filters = ['Pending', 'Approved', 'Rejected', 'Paid', 'All'];
        return in_array($filter, $filters); 
     }

     public function viewInvoice($invoiceId){
        $invoice = vendorInvoice::findOrFail($invoiceId);
        return view('admins.invoice.viewInvoice')->with(['invoice'=>$invoice]);

     }
    public function actionOnInvoice(Request $request){
        $request->validate([
            'invoiceId' => 'required',
            'action'=>'required|in:0,1',
            //'notes'=>'string'
          ]);
        $invoice = vendorInvoice::findOrFail($request->input('invoiceId'));  
        ($request->input('action'))? $invoice->status = 'Approved': $invoice->status = 'Rejected'; 
        if($request->input('notes'))
            $invoice->note = $request->input('notes');
        $invoice->save();

        $vendor = User::find($invoice->vendor_id);
        Mail::to($vendor->email)->send(new invoiceAction($invoice->id, $invoice->status));

        return response()->json([ 'success'=> 'Form is successfully submitted!']);


    }
    
    public function viewAllReadyToPayInvoices($filter){
        $filters = ['Approved','Paid'];
        if(!in_array($filter, $filters))
          abort(404);
        $invoices = vendorInvoice::where('status', $filter)->get();
        
        return view('admins.invoice.allReadyTopayInvoices')->with(['invoices'=>$invoices]);
    }

    public function viewPaymentInvoice($invoiceId){
        $invoice = vendorInvoice::findOrFail($invoiceId);
        return view('admins.invoice.invoicePayment')->with(['invoice'=>$invoice]);

    }
    public function payInvoice(Request $request){
        $request->validate([
            'invoiceId' => 'required',
          ]);
        $invoice = vendorInvoice::findOrFail($request->input('invoiceId'));  
        $invoice->status = 'Paid'; 
        $invoice->save();

        $vendor = User::find($invoice->vendor_id);
        Mail::to($vendor->email)->send(new invoicePyment($invoice->id));

       
        return response()->json([ 'success'=> 'Form is successfully submitted!']);


    }
}
