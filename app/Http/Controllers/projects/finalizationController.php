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
class finalizationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $tasks = woTasksNeeded::with('readyToFinalize_projects')->get();
        $readyToFinalize_tasks = [];
        foreach($tasks as $task){
           if(count($task->readyToFinalize_projects))
               array_push($readyToFinalize_tasks, $task);
        }
        //return  $readyToProof_tasks;
    
        return view('admins.allTasks_finalization')->with(['tasks'=>$readyToFinalize_tasks]);
    }
    
    public function taskFinalization($taskId){
        $task = woTasksNeeded::findOrFail($taskId);
        $source_files = $this->getWo_sourceFiles($task->wo_id);
        //$working_filesReadyToFinalize = $project->project_sourceFile_readyToFilnalize;
        $taskJobs = $task->project;
        $taskProofed_clientFiles = $task->proofed_clientFile;
        
        
        return view('admins.taskFinalization')->with(['source_files'=>$source_files,
            'taskJobs'=>$taskJobs, 'taskProofed_clientFiles'=>$taskProofed_clientFiles, 'task'=>$task
        ]);
    }

    public function store_finalizedFile($taskId, $type){
        
        $task = woTasksNeeded::findOrFail($taskId);
        $inputType = $type.'_file';
        if(request()->file($inputType)){
           // $attachment = request()->file('projectManager_file');
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
        alert()->success('Uploaded Successfully !')->autoclose(false);
        return back();
        
        //return 'hh';
    }
    public function getWo_sourceFiles($woId){
        $wo = WO::find($woId);
        $files = $wo->woFiles->where('type', 'source_file');
        return $files;
    }
}