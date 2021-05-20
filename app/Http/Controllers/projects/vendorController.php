<?php

namespace App\Http\Controllers\projects;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\createVendor;
use Auth;
use App\User;
use App\projects;
use App\projectStage;
use App\userRole;
use App\Role;
class vendorController extends Controller
{
    public function __construct()
     {
         $this->middleware('auth');
     } 
   // hash password ->>>>>>> 'password' => Hash::make($request->newPassword)
     public function createVendor(Request $request){
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],

          ]);

         $vendor = new User();
         $vendor->email = request()['email'];
         $vendor->name = request()['name'];
         $vendor->userName = request()['userName'];
         $vendor->account_type = 'vendor';
         $vendor->password = bcrypt('tarjamatNewMember@1234');
         $vendor->visible = encrypt('tarjamatNewMember@1234');
         $vendor->timezone = request()['timezone'];
         if(request()['created_at'])
           $vendor->created_at = request()['created_at'];
         
        $vendor->save();
        $roleuser = new userRole();
        $roleuser->user_id= $vendor->id;
        $roleuser->role_id = Role::where('name', 'vendor')->first()->id;
        $roleuser->save();

         //send mail to vendor
         Mail::to($vendor->email)->send(new createVendor());
         return back();


     }
     public function allvendors(){
        if(!Auth::user()->can('view-vendors'))
            abort(401);
       // if( in_array($type, ['translator','editor', 'all' ], true )  ){
            $vendors = User::where('account_type', 'vendor')->orderBy('created_at','desc')->get();
            return view('admins.viewAllVendors')->with(['vendors'=> $vendors]);
       /* }
        else 
        abort(404); */
    }
   /*
    public function getvendors_filtered($type){
        if($type=='translator' || $type=='editor')
            $vendors = User::where('account_type', $type)->orderBy('created_at','desc')->get();
        else
            $vendors = User::orderBy('created_at','desc')->get();
                                                          
      return $vendors;
    }
    */
    public function viewVendor($vendor_id){
        if(!Auth::user()->can('view-vendors'))
            abort(401);
        $vendor = User::findOrFail($vendor_id);
        $vendorStages = projectStage::where('vendor_id', $vendor_id )->orderby('created_at', 'desc')->get();
        return view('admins.viewVendor')->with(['vendor'=> $vendor, 'vendorStages'=>$vendorStages]);

    }

    public function destroy($vendor_id){
        $vendor = User::findOrFail($vendor_id);
        $vendor->delete();
        return response()->json(['success'=>'Deleted Successfully']); 
    }
    
}
