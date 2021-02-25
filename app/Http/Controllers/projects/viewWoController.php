<?php

namespace App\Http\Controllers\projects;
use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use  Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Mail\WoRecieved;
use App\projects;
use App\WO;
use App\User;
use alert;
use App\client;
use App\languages;
use Illuminate\Http\RedirectResponse;
use Auth;
use App\woFiles;
use App\woTasksNeeded;
class viewWoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    } 
 
    
    public function getWo_Id(){
      
       $route = Route::current();        
       $wo_id = $route->id;
       return $wo_id;

    }

    public function index(){
        $route_id = $this->getWo_Id();
        $wo = WO::findOrFail($route_id);
        $projects = $wo->projects;
        $clients = $this->getClients();
        $languages = $this->getLanguages();
      //  date_default_timezone_set("America/Guayaquil");
      [$source_files, $reference_files] = $this->getWoFiles($wo);
        return view('admins.viewWo')->with(['wo'=>$wo, 'projects'=>$projects, 'clients'=>$clients,
        'languages'=>$languages, 'source_files'=>$source_files,'reference_file'=>$reference_files]);
    }

    public function getWoFiles($wo){
      $source_files = $wo->woFiles->where('type','source_file');
      $reference_file =$wo->woFiles->where('type','reference_file');
      
      return [$source_files,$reference_file];

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
    public function getWoProjects($wo){
        $projects = $wo->projects->get()->orderBy('created_at');
        
        return $projects;

    }

    public function recieveWo($wo_id){
        $wo = WO::find($wo_id);
        $wo->isReceived = true;
        $wo->save();
        $woCreator = User::find($wo->created_by);
        Mail::to($woCreator->email)->send(new WoRecieved($wo->id));
        return back();
    }

    public function updateWo($woId){

        $wo = WO::findOrFail($woId);
        $request = new Request();
        if(request()['client_number'] && $wo->client_id != request()['client_number'] )
           $wo->client_id = request()['client_number'];
        if(request()['from_language'] && $wo->from_language != request()['from_language'])
           $wo->from_language = request()['from_language'];

        if(request()['to_language'] && $wo->to_language != request()['to_language'])
           $wo->to_language = request()['to_language'];
        if(request()['deadline']){
            $deadline = LocalTime_To_UTC(request()['deadline'], Auth::user()->timezone);
           if($wo->deadline != $deadline)
               $wo->deadline = $deadline; 
        }
        if(request()['client_instructions'] && $wo->client_instructions != request()['client_instructions'])
           $wo->client_instructions = request()['client_instructions'];
        if(request()['general_instructions'] && $wo->general_instructions = request()['general_instructions'])
           $wo->general_instructions = request()['general_instructions'];   
        if(request()['sent_docs'] && $wo->sent_docs != request()['sent_docs'])
           $wo->sent_docs = request()['sent_docs'];     
        $wo->save(); 

        // UPLOAD FILES
        if ($request->hasFile('source_files')) {
         $this->uploadWoAttachments($wo, 'source_files','source_file');
         }
        if ($request->hasFile('reference_files')) {
               $this->uploadWoAttachments($wo, 'reference_files','reference_file');
         }
        
       alert()->success('Wo Updated Successfully !')->autoclose(false);
       return back();   
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

    public function addTask($woId){
      $task = new woTasksNeeded();
      $task->wo_id = $woId;
      $task->type = request()['task_type']; 
      $task->client_wordsCount = request()['client_wordsCount'];
      $task->client_rateUnit = request()['client_rateUnit'];
      $task->client_rateValue = request()['client_rateValue'];
      $task->vendor_suggest_rateUnit = request()['vendor_rateUnit'];
      $task->vendor_suggest_rateValue = request()['vendor_rateValue'];
      $task->save();

      alert()->success('Task Added Successfully !')->autoclose(false);
      return back();
    }
    public function destroyTask($taskId){
       $task = woTasksNeeded::findOrFail($taskId);
       $task->delete();

       alert()->success('Task Deleted Successfully !')->autoclose(false);
      return back();
    }
    public function destroyWoFile($fileId){
       $file = woFiles::findOrFail($fileId);
       $file->delete();
       alert()->success('File Deleted Successfully !')->autoclose(15);
       return back();
    }

    public function destroy($woId){
      $wo = WO::findOrFail($woId);
      $wo->delete();
      alert()->success('Wo Deleted Successfully !')->autoclose(15);
        //return response()->json(['success'=>'File Uploaded Successfully']);      
      return redirect(route('management.view-allWo'));
   }

 
    
}
