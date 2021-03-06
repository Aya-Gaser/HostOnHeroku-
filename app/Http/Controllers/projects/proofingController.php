<?php

namespace App\Http\Controllers\projects;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use  Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use App\Providers\SweetAlertServiceProvider;
use App\Mail\reviewCompleted;
use App\User;
use App\projects;
use App\WO;
use App\project_sourceFile;
use Auth;
use App\vendorDelivery;
use App\projectStage;
use App\editedFile; 
use App\proofedFile;
use App\woTasksNeeded;
use App\Mail\readyToFinalizeFile;

class proofingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    } 

    public function index($filter){
        if(!$this->validateFilter($filter)) abort(404);
        if($filter == 'all')
            $tasks = woTasksNeeded::with('readyToProof_projects')->get();
        else 
            $tasks = woTasksNeeded::where('status', $filter)
                     ->with('readyToProof_projects')->get();
            $readyToProof_tasks = [];
        foreach($tasks as $task){
           if(count($task->readyToProof_projects))
               array_push($readyToProof_tasks, $task);
        }
        //return  $readyToProof_tasks;
        return view('admins.allTasks_proofing')->with(['tasks'=>$readyToProof_tasks]);
    }
    public function validateFilter($filter){
       $filters = ['pending', 'proofed', 'all'];
       return in_array($filter, $filters);
    }
    public function taskProofing($taskId){
        $task = woTasksNeeded::findOrFail($taskId);
        $wo = WO::find($task->wo_id);
        $readyToProof_projects = $task->readyToProof_projects;
        $wo_sourceFiles = $this->getWo_sourceFiles($task->wo_id);
        $deliveries_edited = [];
        $taskJobs = $task->project;
        foreach($readyToProof_projects as $project){
            array_push($deliveries_edited, $this->getSource_acceptedDelivery_edited($project));
        }
        //return $readyToProof_projects;
        return view('admins.taskProofing')->with(['source_files'=>$wo_sourceFiles,
            'task'=>$task,'taskJobs'=>$taskJobs, 'readyToProof_projects'=>$readyToProof_projects,'wo'=>$wo,
             'deliveries_edited'=>$deliveries_edited
        ]);
    }
    public function getWo_sourceFiles($woId){
        $wo = WO::find($woId);
        $files = $wo->woFiles->where('type', 'source_file');
        return $files;
    }
    

    public function getSource_acceptedDelivery_edited($project){
        $lastStage_id = projectStage::where('project_id',$project->id)
                                    ->where('lastIn_project',1)->first()->id;
        
        $delivery_files = projects::with("project_sourceFile_readyToProof", 'project_sourceFile_readyToProof.editedFile')->findOrFail($project->id); 
       
        $lastAccepted_delivery = vendorDelivery::where('stage_id',$lastStage_id)
                                                 ->where('status','accepted')->orderBy('created_at','desc')->get();
        $lastAccepted_delivery_g = $lastAccepted_delivery->groupBy('sourceFile_id');
        $delivery_files->lastAccepted_delivery = $lastAccepted_delivery_g;  

        return $delivery_files;

     }
    public function store_proofingFiles(/*$sourceFileId */Request $request){
        $request->validate([
            //'vendor_file' => 'required|',
           
            //'client_file' => 'file',
            'sourceFileId' => 'required',
          ]);
        
         $sourceFileId = $request->input('sourceFileId');
         $sourceFile =  project_sourceFile::find($sourceFileId);
         $project_id = $sourceFile->project_id; 
         $project = projects::find($project_id);
         $taskId = $project->woTask_id;
         $project->isReadyToFinalize = true;
         $project->save();
        // proofedFile
        
        if($request->file('vendor_file')){
             $this->upload_proofedAttachments($sourceFileId,$project_id, $taskId, 'vendor_file');
          }
       
        if($request->file('client_file')){
            $this->upload_proofedAttachments($sourceFileId,$project_id, $taskId, 'client_file');
            Mail::to('ayagaser39@gmail.com')->send(new readyToFinalizeFile($project->wo_id));
            //Reeno.tarjamat@gmail.com
        }
        $sourceFile->isReadyToFinalize = true;
        $sourceFile->save();
        $task = woTasksNeeded::find($project->woTask_id);
        $task->status = 'proofed';
        $task->save();
       // return back();
       return response()->json([ 'success'=> 'Form is successfully submitted!']);
        //return $sourceFileId;
        
    }
    
    public function send_reviewToVendor(Request $request){
        $request->validate([
            'quality_points' => 'required',
            'maxQuality_points' => 'required',
            'jobId' => 'required',
          ]);
          $projectId = $request->input('jobId');
          $project = projects::find($projectId);
          $project->status = 'reviewed';
          $project->save();

          $vendor = User::find($project->translator_id);
          $stage = projectStage::where('project_id', $project->id)
                               ->where('vendor_id', $project->translator_id )
                               ->where('type', 'translation')->first();  
          $stage->vendor_maxQualityPoints =  $request->input('maxQuality_points');  
          $stage->vendor_qualityPoints =  $request->input('quality_points'); 
          $stage->status = 'reviewed';
          $stage->save();                  
          Mail::to($vendor->email)->send(new reviewCompleted($project->wo_id));
          
          return response()->json([ 'success'=> 'Form is successfully submitted!']);
     
    }

    private function upload_proofedAttachments($sourceFileId, $project_id, $taskId, $inputType)
     { 
        foreach(request()->file($inputType) as $attachment){
        //$attachment =  request()->file($inputType);
            $extension = $attachment->extension();
            $fileName = $project_id . '_' . $attachment->getClientOriginalName() . time() . '_' . rand(1111111111, 99999999) . str_random(10) . '.' . $extension;
            $filePath = '/projects_proofedFiles/' . $project_id . '/';
            Storage::putFileAs('public' . $filePath, new File($attachment), $fileName);
    
            //save each file 
            $proofedFile =new proofedFile();
            $proofedFile->woTask_id =$taskId;
            $proofedFile->project_id =$project_id;
            $proofedFile->sourceFile_id = $sourceFileId;
            $proofedFile->created_by = Auth::user()->id;
            $proofedFile->file_name = $attachment->getClientOriginalName();
            $proofedFile->type = $inputType;
            $proofedFile->file = $filePath . $fileName;
            $proofedFile->extension = $extension;
            
            if(request()[$inputType.'_note']){
                $proofedFile->note = request()[$inputType.'_note'];
            }
            $proofedFile->save();  
        }             
        
    }
}