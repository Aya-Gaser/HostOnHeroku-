<?php

namespace App\Http\Controllers\invoice;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\vendorInvoice;
use App\User;
use Auth;
class invoiceReportsController extends Controller
{
    public function __construct()
      {
          $this->middleware('auth');
      }
    public function view_periodInvoices(Request $request){
        if(!Auth::user()->can('view-invoiceReports'))
            abort(401);

        $vendors = User::where('account_type', 'vendor')->get();
        $vendorInvoices = vendorInvoice::whereNotIn('status', ['Open', 'Rejected']);
        return view('admins.invoice.invoiceReports.vendorPeriodInvoices')
        ->with(['vendorInvoices'=>$vendorInvoices, 'vendors'=>$vendors,
        'vendor'=>null,
         'fromDate'=>null,'toDate'=>null]);
    } 
    public function get_vendorFilterdInvoices(Request $request){

        $filters = [
            'vendor' => $request->input('vendor'),
            'fromDate' => $request->input('fromDate'),
            'toDate' => $request->input('toDate'),
        ];
     
      $invoices = vendorInvoice::where(function ($query) use ($filters) {
            $query->whereNotIn('status', ['Open', 'Rejected']);
            if ($filters['vendor']) {
                $query->where('vendor_id', '=', $filters['vendor']);
            }
            else
                $filters['vendor'] = null;

             if ($filters['fromDate']) {
                $query->where('created_at', '>=', $filters['fromDate']);
            }
            else
                $filters['fromDate'] = null;

            if ($filters['fromDate'] && $filters['toDate'] ) {
                $query->where('created_at', '>=', $filters['fromDate'])
                      ->where('created_at', '<=', $filters['toDate']);
            }
            else
                $filters['toDate'] = null;

        })->get();
        $vendors = User::where('account_type', 'vendor')->get();
        return view('admins.invoice.invoiceReports.vendorPeriodInvoices')
        ->with(['vendorInvoices'=>$invoices,
         'vendors'=>$vendors, 'vendor'=>$filters['vendor'],
         'fromDate'=>$filters['fromDate'],'toDate'=>$filters['toDate'],
         ]);

        
    }  
}
