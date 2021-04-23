<?php

namespace App\Http\Controllers\invoice;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\vendorInvoice;
use App\vendorWorkInvoiceItem;
use Auth;

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
            'action'=>'required|in:0,1'
          ]);
        $invoice = vendorInvoice::findOrFail($request->input('invoiceId'));  
        ($request->input('action'))? $invoice->status = 'Approved': $invoice->status = 'Rejected'; 
        $invoice->save();
        //mail to vendor
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
        //mail to vendor
        return response()->json([ 'success'=> 'Form is successfully submitted!']);


    }
}
