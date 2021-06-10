<?php

namespace App\Http\Controllers\projects;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\WO;
use App\projects;

class allWoController extends Controller
{
      //// protect routes from unlogged ////////////
      public function __construct()
      {
          $this->middleware('auth');
      } 
      //
      public function getPendingWo(){
        $allPending_wo = WO::where('isHandeled',false)->get();
        return $allPending_wo;

    }
   
    public function getCompletedWo(){
        $allCompleted_wo = WO::where('isHandeled',true)->get();
         return $allCompleted_wo;
    }
    public function index(){
        $allPending_wo = $this->getPendingWo();
        $allCompleted_wo = $this->getCompletedWo();
        return view('admins.allWo')->with(['allPending_wo'=>$allPending_wo,'allCompleted_wo'=>$allCompleted_wo]);

    }
    public function allProjects($status){
        
        if( in_array($status, ['pending','Completed', 'all', 'progress' ], true )  ){
            $projects = $this->getprojects_filtered($status);
            return view('admins.allProjects')->with(['projects'=> $projects,'type'=>'All']);
        }
        else 
            abort(404);
    }

    public function getprojects_filtered($status){
        if($status=='all')
            $projects = projects::orderBy('created_at','desc')->get();
        else if($status == 'progress')
            $projects = projects::where('status','!=', 'pending')
                                ->where('status','!=', 'Completed')->orderBy('created_at','desc')->get();
        else
            $projects = projects::where('status', $status)->orderBy('created_at','desc')->get();

                                                          
      return $projects;
    }
    public function allProjects_type_status($type, $status){
        
        if( in_array($status, ['pending','Completed', 'all', 'progress' ], true ) &&  in_array($type, ['translation','editing', 'dtp', 'linked' ], true )){
            $projects = $this->getprojects_filtered_type_status($type, $status);
            return view('admins.allProjects')->with(['projects'=> $projects,'type'=>$type]);
        }
        else 
            abort(404);
    }
    public function getprojects_filtered_type_status($type, $status){
        if($status=='all')
            $projects = projects::where('type','=', $type)->get();
        else if($status == 'progress')
            $projects = projects::where('type','=', $type)
                                ->where('status','!=', 'pending')
                                ->where('status','!=', 'Completed')->orderBy('created_at','desc')->get();
        else
            $projects = projects::where('type','=', $type)
                                ->where('status', $status)->orderBy('created_at','desc')->get();

                                                          
      return $projects;
    }
}
