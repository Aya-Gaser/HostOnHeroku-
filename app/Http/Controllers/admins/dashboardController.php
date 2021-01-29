<?php

namespace App\Http\Controllers\admins;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\WO;
use App\projects;
use Auth;
use App\User;
class dashboardController extends Controller
{
    public function index(){
        
        $notRecievedWo = count(WO::where('isReceived', false)->get());
        $CompletedWo = count(WO::where('isHandeled', true)->get());
        $pendingWo = count(WO::where('isHandeled', false)->get()); 
        $allWo = count(WO::all()); 

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
          'linkedProjects_onProgress'=>$linkedProjects_onProgress ]);
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
    public function completeData(){ 
      $admin = User::findOrFail(Auth::user()->id);
      $admin->name = request()['name'];
      $admin->email = request()['email'];
      $admin->timezone = request()['timezone'];
      $admin->birthdate = request()['birthdate'];
      //$admin->name = request()['name'];
      $admin->isFirstLogin = 0;
      $admin->save();

      return redirect(route('management.dashboard'));
  }
}
