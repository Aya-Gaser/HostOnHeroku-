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
use App\woTasksNeeded;
use App\woFiles;
use Illuminate\Support\Facades\Mail;
use App\Mail\newWoCreated;
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
      if(!Auth::user()->can('create-wo'))
            abort(401);
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
       $WO->po_number = $request->input('po_number');
       $UTCDeadline = LocalTime_To_UTC($request->input('deadline'), Auth::user()->timezone);
       $WO->deadline = $UTCDeadline;
       $WO->from_language = $request->input('from_language'); 
       $WO->to_language = $request->input('to_language'); 
       $WO->client_instructions = ($request->input('client_instructions'))? $request->input('client_instructions') : 'none';
       $WO->general_instructions = ($request->input('general_instructions'))? $request->input('general_instructions') : 'none';
       $WO->isHandeled = false;
       $WO->created_by = Auth::user()->id;
       $WO->status = 'Pending';
       $WO->sent_docs = $request->input('sent_docs'); 
       $WO->save();
       $is_otherLanguage = false;
       $withProof_language = ['Arabic', 'English'];
       if( !in_array($WO->from_language, $withProof_language) || !in_array($WO->to_language, $withProof_language)  )
          $is_otherLanguage = true;
       $this->storeWo_Tasks($WO->id, $is_otherLanguage);
         // UPLOAD FILES
        if ($request->hasFile('source_files')) {
            $this->uploadWoAttachments($WO, 'source_files','source_file');
        }
        if ($request->hasFile('reference_files')) {
            $this->uploadWoAttachments($WO, 'reference_files','reference_file');
        } 
        Mail::to('Projects.tarjamatllc@gmail.com')->send(new newWoCreated($WO->id));
         //

        alert()->success('Wo Created Successfully !')->autoclose(false);
        //return response()->json(['success'=>'File Uploaded Successfully']);      
      return redirect(route('management.view-allWo'));
    }
    
    public function storeWo_Tasks($wo_id, $is_otherLanguage){
      $taskNum = request()['tasksNum'];
      for($i=1; $i<=$taskNum; $i++){
         $task = new woTasksNeeded();
         $task->wo_id = $wo_id;
         $task->type = request()['task_type'.$i]; 
         $task->client_wordsCount = request()['client_wordsCount'.$i];
         $task->client_rateUnit = request()['client_rateUnit'.$i];
         $task->client_rateValue = request()['client_rateValue'.$i];
         $task->vendor_suggest_rateUnit = request()['vendor_rateUnit'.$i];
         $task->vendor_suggest_rateValue = request()['vendor_rateValue'.$i];
         $task->has_proofAndFinalize = ($is_otherLanguage)? false : true;
         $task->save(); 
      }
      
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