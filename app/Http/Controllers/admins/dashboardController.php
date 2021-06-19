<?php

namespace App\Http\Controllers\admins;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\WO;
use App\projects;
use Auth;
use App\User;
use App\vendorInvoice;
use App\client;
class dashboardController extends Controller
{
  public function __construct()
     {
         $this->middleware('auth');
     } 
    public function index(){
        
        $notRecievedWo = count(WO::where('isReceived', false)->get());
        $CompletedWo = count(WO::where('isHandeled', true)->get());
        $pendingWo = count(WO::where('isHandeled', false)->get()); 
        $allWo = count(WO::all()); 
        $allProjects =  count(projects::all()); 
        $allInvoices = count(vendorInvoice::where('status','!=','rejected')->get()); 

        //all invoice 
        $vendorInvoice_pending = count(vendorInvoice::where('status', 'Pending')->get() );

        $vendorInvoice_approved = count(vendorInvoice::where('status', 'Approved')->get() );

        $vendorInvoice_paid = count(vendorInvoice::where('status', 'Paid')->get() );

        //all projects 
        $allProjects_pending = count(projects::where('status', 'pending')->get() );

        $allProjects_progress = count(projects::where('status', 'on progress')->get() );

        $allProjects_completed = count(projects::where('status', 'completed')->get() );

         //translation
        $translationProjects_pending = count(projects::where('type', 'translation')
                                                        ->where('status', 'pending')->get() );
        $translationProjects_onProgress = count(projects::where('type', 'translation')
                                                        ->where('status', 'on progress')->get() );
        $translationProjects_completed = count(projects::where('type', 'translation')
                                                        ->where('status', 'completed')->get() );
        $translationProjects_all= count(projects::where('type', 'translation')->get()) ;
        //editing
        $editingProjects_pending = count(projects::where('type', 'editing')
                                                        ->where('status', 'pending')->get() );
        $editingProjects_onProgress = count(projects::where('type', 'editing')
                                                        ->where('status', 'on progress')->get() );
        $editingProjects_completed = count(projects::where('type', 'editing')
                                                        ->where('status', 'completed')->get() );
        $editingProjects_all = count(projects::where('type', 'editing')->get() );
       
        //dtp
        $dtpProjects_pending = count(projects::where('type', 'dtp')
                                                        ->where('status', 'pending')->get() );
        $dtpProjects_onProgress = count(projects::where('type', 'dtp')
                                                         ->where('status', 'on progress')->get() );
        $dtpProjects_completed = count(projects::where('type', 'dtp')
                                                       ->where('status', 'completed')->get() );
        $dtpProjects_all = count(projects::where('type', 'dtp')->get() );
        
        //linked
        $linkedProjects_pending = count(projects::where('type', 'linked')
                                                        ->where('status', 'pending')->get() );
        $linkedProjects_onProgress = count(projects::where('type', 'linked')
                                                        ->where('status', 'on progress')->get() );
        $linkedProjects_completed = count(projects::where('type', 'linked')
                                                       ->where('status', 'completed')->get() );
        $linkedProjects_all = count(projects::where('type', 'linked')->get() );

        return view('admins.dashboard')->with(['notRecievedWo'=>$notRecievedWo, 'CompletedWo'=>$CompletedWo,
        'pendingWo'=>$pendingWo, 'allWo'=>$allWo, 'translationProjects_pending'=>$translationProjects_pending,
         'translationProjects_onProgress'=>$translationProjects_onProgress, 'translationProjects_completed'=>$translationProjects_completed,
         'translationProjects_all'=>$translationProjects_all, 'editingProjects_all'=>$editingProjects_all,
         'editingProjects_pending'=>$editingProjects_pending, 'editingProjects_onProgress'=>$editingProjects_onProgress,
          'editingProjects_completed'=>$editingProjects_completed, 'dtpProjects_all'=>$dtpProjects_all,
          'dtpProjects_pending'=>$dtpProjects_pending, 'dtpProjects_completed'=>$dtpProjects_completed,'dtpProjects_onProgress'=>$dtpProjects_onProgress,
          'linkedProjects_onProgress'=>$linkedProjects_onProgress, 'linkedProjects_all'=>$linkedProjects_all,
          'linkedProjects_pending'=>$linkedProjects_pending, 'linkedProjects_completed'=>$linkedProjects_completed,
          'linkedProjects_onProgress'=>$linkedProjects_onProgress,
          'allProjects'=>$allProjects,'allProjects_pending'=>$allProjects_pending,
          'allProjects_progress'=>$allProjects_progress,'allProjects_completed'=>$allProjects_completed,
          'allInvoices'=>$allInvoices, 'vendorInvoice_pending'=>$vendorInvoice_pending,
          'vendorInvoice_approved'=>$vendorInvoice_approved,'vendorInvoice_paid'=>$vendorInvoice_paid ]);
    }
    public function profile(){
        $user = Auth::user();
        return view('admins.profile')->with(['user'=>$user]);
    }

    public function updateProfile($userId){
        $user = User::findOrFail($userId);
        if(request()['name'])
          $user->name = request()['name'];
        if(request()['email'])
          $user->email = request()['email'];
        if(request()['birthdate'])
          $user->birthdate = request()['birthdate'];
        if(request()['password']){
          $user->password = bcrypt(request()['password']);
          $user->visible = encrypt(request()['password']);
        }
        $user->save();
        return back();  
    }
    public function first(){
      $vendor = User::findOrFail(Auth::user()->id);
      return view('admins.profile_firstLogin')->with(['vendor'=>$vendor]);
  }
    public function completeData(Request $request){ 
      if(!Auth::user()->isFirstLogin)
        abort(404);
      $request->validate([
        'name' => 'required',
        'email' => ['required', 'string', 'email', 'max:255'],
        'timezone' => 'required',
        'birthdate' => 'required',
        'password' => ['required', 'string', 'min:8', 'confirmed'],
      ]);
      $admin = User::findOrFail(Auth::user()->id);
      $admin->name = request()['name'];
      $admin->email = request()['email'];
      $admin->timezone = request()['timezone'];
      $admin->birthdate = request()['birthdate'];
      $admin->password = bcrypt(request()['password']);
      $admin->visible = encrypt(request()['password']);
      $admin->isFirstLogin = 0;
      $admin->save();

      return redirect(route('management.dashboard'));
  }

  public function excel(){
    $row = 1;
    if (($handle = fopen("Client_Base.csv", "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $num = count($data);
            echo "<p> $num fields in line $row: <br /></p>\n";
            $row++;
            
                echo $data[0] . "<br />\n";
                echo $data[1] . "<br />\n";
                $this->createClient($data[0], $data[1]);
            
        }
        fclose($handle);
    }

  }
  public function createClient($name, $code){
    $client = new client();
    $client->name = $name;
    $client->code = $code;
    
    $client->save();
  }
}
