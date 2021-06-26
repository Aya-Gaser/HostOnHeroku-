<?php

namespace App\Http\Controllers\vendor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\projects;
use App\projectStage;
use App\User;
use Auth;
use App\vendorInvoice;

class dashboardController extends Controller
{
  public function __construct()
     {
         $this->middleware('auth');
     }   
  public function index(){
        
       $VendorProjects_all = count(projectStage::where('vendor_id', Auth::user()->id)->get());
       $VendorProjects_reviewed = count(projectStage::where('vendor_id', Auth::user()->id)
                                                    ->where('status', 'reviewed')->get());
       $VendorProjects_completed = count(projectStage::where('vendor_id', Auth::user()->id)
                                                    ->where('status', 'Completed')->get());
       $VendorProjects_undelivered = count(projectStage::where('vendor_id', Auth::user()->id)
                                                    ->where('status', 'In Progress')->get());
       /****************************** */
       $VendorInvoices_all = count(vendorInvoice::where('vendor_id', Auth::user()->id)->get());
       $VendorInvoices_opened = count(vendorInvoice::where('vendor_id', Auth::user()->id)
                                                    ->where('status', 'Open')->get());
       $VendorInvoices_approved = count(vendorInvoice::where('vendor_id', Auth::user()->id)
                                                    ->where('status', 'Approved')->get());
       $VendorInvoices_paid = count(vendorInvoice::where('vendor_id', Auth::user()->id)
                                                    ->where('status', 'Paid')->get());
        $VendorInvoices_pending = count(vendorInvoice::where('vendor_id', Auth::user()->id)
                                                    ->where('status', 'Pending')->get());
                           

        
        

        return view('vendor.dashboard')->with(['VendorProjects_all'=>$VendorProjects_all,
        'VendorProjects_reviewed'=>$VendorProjects_reviewed, 'VendorProjects_completed'=>$VendorProjects_completed,
        'VendorProjects_undelivered'=>$VendorProjects_undelivered,'VendorInvoices_all'=>$VendorInvoices_all,
        'VendorInvoices_pending'=>$VendorInvoices_pending, 'VendorInvoices_approved'=>$VendorInvoices_approved,
        'VendorInvoices_paid'=>$VendorInvoices_paid
         ]);
    }
    public function profile(){
        $user = Auth::user();
        return view('vendor.profile')->with(['user'=>$user]);
    }
    public function updateProfile($userId){
        $user = User::findOrFail($userId);
        if(request()['name'])
          $user->name = request()['name'];
        if(request()['email'])
          $user->email = request()['email'];
        if(request()['birthdate'])  
          $user->birthdate = request()['birthdate'];
        if(request()['native_language'])  
          $user->native_language = request()['native_language'];
        if(request()['password']){
          $user->password = bcrypt(request()['password']);
          $user->visible = encrypt(request()['password']);
        }
        if(request()['timezone'])
          $user->timezone = request()['timezone'];
        $user->save();
        return back();  
    }

    public function first(){
      $vendor = User::findOrFail(Auth::user()->id);
      return view('vendor.profile_firstLogin')->with(['vendor'=>$vendor]);
  }
    public function completeData(Request $request){ 
      if(!Auth::user()->isFirstLogin)
        abort(404);
      $request->validate([
        'name' => 'required',
        'email' => ['required', 'string', 'email', 'max:255'],
        'timezone' => 'required',
        'birthdate' => 'required',
        'native_language'=>'required',
        'password' => ['required', 'string', 'min:8', 'confirmed'],
      ]);

      $vendor = User::findOrFail(Auth::user()->id);
      $vendor->name = request()['name'];
      $vendor->email = request()['email'];
      $vendor->native_language = request()['native_language'];
      $vendor->timezone = request()['timezone'];
      $vendor->birthdate = request()['birthdate'];
      $vendor->password = bcrypt(request()['password']);
      $vendor->visible = encrypt(request()['password']);
      $vendor->isFirstLogin = 0;
      $vendor->save();

      return redirect(route('vendor.dashboard'));
  }
}
