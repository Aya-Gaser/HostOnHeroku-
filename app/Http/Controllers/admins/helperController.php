<?php

namespace App\Http\Controllers\admins;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\projects;
class helperController extends Controller
{
    public function __construct()
     {
         $this->middleware('auth');
     } 
    public function getStage_qualityPoints( Request $request){
        $request->validate([
       
            'projectId' => 'required'
          ]);
       
       $project = projects::find($request->input('projectId'));
       $stage = $project->translationStage->first();
       $data = json_encode(array('qp'=>$stage->vendor_qualityPoints, 'maxQp'=>$stage->vendor_maxQualityPoints));
       return response()->json(['success'=> $data]);      
    }
}
