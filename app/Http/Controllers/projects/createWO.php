<?php

namespace App\Http\Controllers\projects;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Http\Controllers\Controller;
use App\client;
use App\languages;
use App\User;
use App\WO;
use Auth;
use App\woProjectsNeeded;
use App\woFiles;
class createWO extends Controller
{

     //// protect routes from unlogged ////////////
     public function __construct()
     {
         $this->middleware('auth');
     } 
   
     public function index(){
        // relations 
       /* 
        $client_id= 5691;
         $client = clients::where('id',$client_id)->first();
         return $client->Wo->first();
         */
     }
    public function getClients(){
   
        $clients = client::all();
        return $clients;
   
    }
    public function getLanguages(){
   
        $languages = languages::all();
       // return View::make("admins.CreateWo")->with($languages);
        return $languages;
   
    }
    public static function getVendors(){
         $vendors =User::where('account_type', 'vendor')->get();
       // $request = new Request();
      /*  $lang = $request->input('from_language'); */
        return $vendors; 
        //return $languages;
   
    }
    
    public function getAllData(Request $request) {
        $clients = $this->getClients();
        $languages = $this->getLanguages();
        $vendors = $this->getVendors();
      //  $test = $this->index();
        return view('admins.CreateWo')->with(['clients'=>$clients,'languages'=>$languages,
        'vendors'=>$vendors]);
    }
   public function store(Request $request){
      //get client id
   //   $client = client::find($request->input('client_number'));
      $client_id = $request->input('client_number');

      $WO = new WO(); 
      
       $WO->client_id = $client_id;
       $UTCDeadline = LocalTime_To_UTC($request->input('deadline'), Auth::user()->timezone);
       $WO->deadline = $UTCDeadline;
       $WO->client_rate = $request->input('client_rate');
       $WO->from_language = $request->input('from_language');
       $WO->to_language = $request->input('to_language'); 
       $WO->words_count = $request->input('words_count');
       $WO->quality_points = $request->input('quality_points');
       $WO->client_instructions = $request->input('client_instructions');
       $WO->general_instructions = $request->input('general_instructions');
       $WO->isHandeled = false;
       $WO->created_by_id = Auth::user()->id;
       $WO->status = 'pending';
       $WO->save();

         // UPLOAD FILES
        if ($request->hasFile('source_files')) {
            $this->uploadWoAttachments($WO, 'source_files','source_file');
        }
        if ($request->hasFile('reference_files')) {
            $this->uploadWoAttachments($WO, 'reference_files','reference_file');
        }
        if ($request->hasFile('target_files')) {
            $this->uploadWoAttachments($WO, 'target_files','target_file');
        }

       if($request->input('projects_needed')){
         foreach($request->input('projects_needed') as $projectType){
               $projectNeeded = new woProjectsNeeded();
               $projectNeeded->wo_id = $WO->id;
               $projectNeeded->type = $projectType;
               $projectNeeded->save();
         }
       }
       
      
        alert()->success('Wo Created Successfully !')->autoclose(15);
        //return response()->json(['success'=>'File Uploaded Successfully']);      
      return redirect(route('management.view-allWo'));
    }

    private function uploadWoAttachments( $WO, $attachmentInputName, $inputType)
    { 
        foreach (request()->file($attachmentInputName) as $attachment) {
            $extension = $attachment->extension();
            $fileName = $WO->id . '_' . $attachment->getClientOriginalName() . time() . '_' . rand(1111111111, 99999999) . str_random(10) . '.' . $extension;
            $filePath = '/wo_files/' . $WO->id. '/' . $WO->client_id . '/';
            Storage::putFileAs('public' . $filePath, new File($attachment), $fileName);

                //save each file 
                $woFiles =new woFiles();
                $woFiles->wo_id =$WO->id;
                $woFiles->file_name = $attachment->getClientOriginalName();
                $woFiles->type = $inputType;
                $woFiles->file = $filePath . $fileName;
                $woFiles->extension = $extension;
                $woFiles->save();
               
         }
    }


    
   


}