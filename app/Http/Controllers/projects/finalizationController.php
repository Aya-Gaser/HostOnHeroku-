<?php

namespace App\Http\Controllers\projects;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use  Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use App\projects;
use App\WO;
use App\project_sourceFile;
use Auth;
use App\vendorDelivery;
use App\projectStage;
use App\editedFile;
use App\proofedFile;
use App\woTasksNeeded;
use App\finalizedFile;
use App\Mail\projectsManger_FinalFiles;
use Illuminate\Support\Facades\Mail;

class finalizationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($filter){
        if(!Auth::user()->can('view-finalization'))
            abort(401);
        if(!$this->validateFilter($filter)) abort(404);
        if($filter == 'progress') $filter = 'under finalization';

        if($filter == 'all')
            $tasks = woTasksNeeded::with('readyToFinalize_projects')->get();
        else
            $tasks = woTasksNeeded::where('status', $filter)
            ->with('readyToFinalize_projects')->get();
        $readyToFinalize_tasks = [];
        foreach($tasks as $task){
           if(count($task->readyToFinalize_projects))
               array_push($readyToFinalize_tasks, $task);
        }
        //return  $readyToProof_tasks;
    
        return view('admins.allTasks_finalization')->with(['tasks'=>$readyToFinalize_tasks]);
    }

    public function validateFilter($filter){
        if($filter == 'progress') $filter = 'under finalization';
        $filters = ['proofed', 'under finalization', 'Completed', 'all'];
        return in_array($filter, $filters); 
     }
    
    public function taskFinalization($taskId){
        $allowComplete = 0;
        if(!Auth::user()->can('view-finalization'))
            abort(401);
        $task = woTasksNeeded::findOrFail($taskId);
        $source_files = $this->getWo_sourceFiles($task->wo_id);
        //$working_filesReadyToFinalize = $project->project_sourceFile_readyToFilnalize;
        $taskJobs = $task->project;
        $taskProofed_clientFiles = $task->proofed_clientFile;
        $allowComplete = $this->ISAllTask_ProjectsFinalized($task);
        
        
        return view('admins.taskFinalization')->with(['source_files'=>$source_files,
            'taskJobs'=>$taskJobs,'allowComplete'=>$allowComplete,
             'taskProofed_clientFiles'=>$taskProofed_clientFiles, 'task'=>$task
        ]);
    }
    
    public function ISAllTask_ProjectsFinalized($task){
        $allTask_project = $task->project;
        $allTask_project_finalized = $task->Finalized_projects;

        return($allTask_project == $allTask_project_finalized );
    }
    public function store_finalizedFile($taskId){
        
        $task = woTasksNeeded::findOrFail($taskId);
        
        if(request()->file('projectManager_file')){
          $this->uploadFiles($taskId, 'projectManager_file');
          Mail::to('Projects.Tarjamatllc@gmail.com')->send(new projectsManger_FinalFiles($task->wo_id));
          //Projects.tarjamatllc@gmail.com
        }
        if(request()->file('client_file')){
            $this->uploadFiles($taskId, 'client_file');
          }
            
        $task->status = 'under finalization';
        $task->save();
        foreach($task->project as $project){
            $project->status = 'Finalized';
            $project->save();
        }
     
        
        alert()->success('Uploaded Successfully !')->autoclose(false);
        return back();
        
        //return 'hh';
    }

    public function uploadFiles($taskId, $inputType){
        foreach(request()->file($inputType) as $attachment){
            $extension = $attachment->extension();
            $fileName = $taskId . '_' . $attachment->getClientOriginalName() . time() . '_' . rand(1111111111, 99999999) . str_random(10) . '.' . $extension;
            $filePath = '/wo_finalizedFiles/' . $taskId . '/';
            Storage::putFileAs('public' . $filePath, new File($attachment), $fileName);
            $finalizedFile = new finalizedFile();
            $finalizedFile->woTask_id =$taskId;
            $finalizedFile->file_name = $attachment->getClientOriginalName();
            $finalizedFile->type = $inputType;
            $finalizedFile->file = $filePath . $fileName;
            $finalizedFile->extension = $extension;
            $finalizedFile->created_by = Auth::user()->id;
            $finalizedFile->save();
            //return  'kkkkkkkk';
        }
    }
    public function getWo_sourceFiles($woId){
        $wo = WO::find($woId);
        $files = $wo->woFiles->where('type', 'source_file');
        return $files;
    }

    public function complete_reOpen_woTask(Request $request){
        $request->validate([
            
            'complete' => 'required',
            'taskId' => 'required',
          ]);
        $complete = $request->input('complete');  
        $taskId = $request->input('taskId');  
        $task = woTasksNeeded::findOrFail($taskId); 
         
        $task->status = ($complete)? 'Completed' : 'under finalization'; //1 >> complete
        foreach($task->project as $project){
            $project->status = 'Finalized';
            $project->save();
        }
        $task->save();

        return response()->json(['success'=>'Done Successfully']);      
    }
}
