<?php

namespace App\Http\Controllers\projects;
use Illuminate\Console\Scheduling\Schedule;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Routing\UrlGenerator;
use  Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use App\Providers\SweetAlertServiceProvider;
use App\Mail\newJob;
use Carbon\Carbon;
use App\projectsInvitations;
use Illuminate\Support\Facades\URL;
use App\woFiles;
use App\projects;
use App\WO;
use App\User;
use App\clients;
use App\languages;
use Auth;
use App\woSourceFiles_toProjectsVendors;
use SweetAlert;
use App\Jobs\inviteGroup2;
use App\editingDetails;
use App\projectStage;
use App\project_sourceFile;
use App\projectFile;
use App\woTasksNeeded;

class createProjectController extends Controller
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
    public function getTranslators(){
      $vendors = User::where('account_type','vendor')->get();
      
        return $vendors;
     }

     //select sngle or linked 
    public function selectProject_type($id){
        $wo = WO::findOrFail($id);
       
      return view('admins.selsctProjectType')->with([ 'wo_id' => $id, 'wo'=> $wo ]);
    } 

    public function index($id,$type,$taskId){
      if(!Auth::user()->can('create-project'))
        abort(401);
      $route_id = $this->getWo_Id();
      $wo = WO::findOrFail($route_id);
      /*if($wo->isHandeled)
        return redirect('/allWo'); */
       $this->validateFilter($type);
      $task =  woTasksNeeded::find($taskId);
      $vendors = $this->getTranslators();
      $source_files = $wo->woFiles->where('type','source_file');
      $reference_file =$wo->woFiles->where('type','reference_file');
      $view = ($type =='linked') ? 'admins.createProject_linked' : 'admins.createProject';
      return view($view)->with([ 'wo'=>$wo,'source_files'=>$source_files,'taskId'=>$taskId,
      'reference_file'=>$reference_file, 'vendors'=>$vendors, 'task'=> $task]);
    }
    
  
  public function deleteAttachment($file_id)
  {
      //delete from storage 
      /*
      $fileLink ='storage/public/';
      if(Storage::delete('/public/wo_files/112'.$fileName))
      return"jjj";
      */
      //delete from woFiles table
      woFiles::find($file_id)->delete();
      //alert()->success('Attachment Deleted Successfully !')->autoclose(false);
      return back();
  } 
  public function validateFilter($filter){
    $filters = array('single', 'linked');
    if(!in_array($filter, $filters))
      abort(404);
} 
  public function store(Request $request){
    //get client id
    /// islinked
    $route = Route::current();        
    $isLinked = $route->isLinked;
    //data
    $wo_id=$route->wo;
    $wo = WO::findOrFail($wo_id);
    $project = new projects(); 
    $project->wo_id = $wo_id;
    $project->woTask_id = $request->input('woTask_id');; ///////////////////////???????
    $project->type = woTasksNeeded::find($project->woTask_id)->type;
    //($isLinked)? 'linked' : $request->input('project_type');
    $project->name = $request->input('project_name');
    $UTCDeadline = LocalTime_To_UTC($request->input('delivery_deadline'), Auth::user()->timezone);
    $project->delivery_deadline = $UTCDeadline;
    
    //$project->vendor_rate = $request->input('vendor_rate'); 	
    //$project->words_count = $request->input('words_count');
   // $project->instructions = $request->input('instructions');
    $project->created_by = Auth::user()->id;
    $project->status = 'pending';
    $project->save();
    $transStage =null;
    $editStage =null; 

    $wo->isHandeled = true;
    $wo->isReceived = true;
    $wo->save();
    ///// CREATE PROJECT STAGES//////// instructions_editing
    if($isLinked){
        $transStage = $this->createStage($wo_id,$project->id, 'Translation', false, false );
        $editStage = $this->createStage($wo_id,$project->id, 'Editing', true, true );
    }
    else{
       $transStage =  $this->createStage($wo_id, $project->id, $project->type, true, false);
    }
    if(request()['vendor1_translators_group1'])
       $this->inviteGroup1($transStage,request()['vendor1_translators_group1']);

    /// LINKED PROJECT 
    if($isLinked){
     //   $this->storeEditing($project);
        if(request()['vendor2_translators_group1'])
            $this->store_GroupInvitations($project,request()['vendor2_translators_group1'],2,1 );
        if(request()['vendor2_translators_group2'])
            $this->store_GroupInvitations($project,request()['vendor2_translators_group2'],2,2 );
    } 

     // UPLOAD FILES
      if ($request->hasFile('source_files')) {
          $this->uploadWoAttachments($project->id, 'source_files','source_file');
          }
      if ($request->hasFile('reference_files')) {
          $this->uploadWoAttachments($project->id, 'reference_files','reference_file');
      }
      if ($request->hasFile('vendorSource_files')) {
          $this->uploadWoAttachments($project->id, 'vendorSource_files','vendorSource_file');
      }
      // SELECT WO SOURCE FILES TO SEND TO VENDOR
      if(request()['selectedFiles'])
          $this->send_WoSourceFiles_toVendor($project->id, request()['selectedFiles']);
      
     
      alert()->success('Project Created Successfully !')->autoclose(false);
        //return response()->json(['success'=>'File Uploaded Successfully']);      
      return redirect(route('management.view-allProjects', 'all'));
  }

  public function send_WoSourceFiles_toVendor($project_id, $selectedFiles){
    $group = explode(',', $selectedFiles);
    foreach($group as $sourceFile_s){
        $sourceFile_id = trim($sourceFile_s, '"');

        $woSourceToVendor = new woSourceFiles_toProjectsVendors();
        $woSourceToVendor->project_id = $project_id;
        $woSourceToVendor->woSourceFile_id = $sourceFile_id;
        $woSourceToVendor->save();
        
      } 
  }
  
  public function createStage($wo_id,$project_id, $project_type, $IsLast, $isLinkedEditing){
       
        $stage = new projectStage();
        $stage->wo_id = $wo_id;
        $stage->project_id = $project_id;
        $stage->type = $project_type;
        //instructions_editing
        $stage->lastIn_project = $IsLast;
        $required_docs_inputName = ($isLinkedEditing)? 'required_docs_edit' : 'required_docs';
        $deadline_inputName = ($isLinkedEditing)? 'delivery_deadline_edit' : 'delivery_deadline';
        $vendorRate_inputName = ($isLinkedEditing)? 'vendor_rate_edit' : 'vendor_rate';
        $acceptance_deadline = ($isLinkedEditing)? 'acceptance_deadline_edit' : 'acceptance_deadline';
        $unit_count_inputName = ($isLinkedEditing)? 'unit_count_edit' : 'unit_count';
        $maxQuality_points_inputName = ($isLinkedEditing)? 'maxQuality_points_edit' : 'maxQuality_points';
        $vendorRate_unit_inputName = ($isLinkedEditing)? 'rate_unit_edit' : 'rate_unit';
        $instruction_inputName = ($isLinkedEditing)? 'instructions_edit' : 'instructions';

        $UTCDeadline = LocalTime_To_UTC(request()[$deadline_inputName], Auth::user()->timezone);
        $stage->deadline = $UTCDeadline;
        $stage->required_docs = request()[$required_docs_inputName];
        if(request()[$instruction_inputName])
          $stage->instructions = request()[$instruction_inputName];
        $stage->vendor_unitCount = request()[$unit_count_inputName];
        $stage->vendor_maxQualityPoints = (request()[$maxQuality_points_inputName])? request()[$maxQuality_points_inputName] : 0 ;
        $stage->vendor_rateUnit = request()[$vendorRate_unit_inputName];
        $stage->vendor_rate = request()[$vendorRate_inputName];
        $stage->G1_acceptance_hours = request()[$acceptance_deadline];
        $stage->G2_acceptance_hours = request()[$acceptance_deadline];
        $stage->G1_acceptance_deadline= Carbon::now()->addHours(request()[$acceptance_deadline]);
        $stage->G2_acceptance_deadline= (new Carbon($stage->G1_acceptance_deadline))->addHours(request()[$acceptance_deadline]);
        $stage->save();
        return $stage;

     
      }
  private function uploadWoAttachments( $project_id, $attachmentInputName, $inputType)
  { 
      foreach (request()->file($attachmentInputName) as $attachment) {
          $extension = $attachment->extension();
          $fileName = $project_id . '_' . $attachment->getClientOriginalName() . time() . '_' . rand(1111111111, 99999999) . str_random(10) . '.' . $extension;
          if($inputType != 'source_file'){ 
                $filePath = '/projects_files/'.$inputType.'/' . $project_id . '/';
                Storage::putFileAs('public' . $filePath, new File($attachment), $fileName);

              //save each file 
              $projectFile =new projectFile();
              $projectFile->project_id =$project_id;
              $projectFile->file_name = $attachment->getClientOriginalName();
              $projectFile->type = $inputType;
              $projectFile->file = $filePath . $fileName;
              $projectFile->extension = $extension;
              $projectFile->save();
          }
          else{
            $filePath = '/projects_sourceFiles/' . $project_id . '/';
            Storage::putFileAs('public' . $filePath, new File($attachment), $fileName);
  
                //save each file 
                $project_sourceFile =new project_sourceFile();
                $project_sourceFile->project_id =$project_id;
               //$woSourceFiles->stage_id =$wo_id;
                $project_sourceFile->file_name = $attachment->getClientOriginalName();
                $project_sourceFile->file = $filePath . $fileName;
                $project_sourceFile->extension = $extension;
                $project_sourceFile->save();
            

          }
             
       }
  }
  private function inviteGroup1($stage, $groupInput )
    {
       // $includeInQuery = ($job['type'] == Job::JOB_TYPE_LINKED & !$sendMail) ? false : ($group == JobUser::GROUP_1);
        foreach ($groupInput as $member) {
            
            $member = User::find($member);

            if ($member != null)  {
               $link =  route('vendor.project-offer', ['stage_id' => $stage->id, 'group'=> 1,'vendor'=>1]);
                Mail::to($member->email)->send(new newJob($stage,$member,'GROUP_1', $link));
               
            }
        }
        $this->store_GroupInvitations($stage->project_id, $stage->id,request()['vendor1_translators_group1'],1,1 );

        if(request()['vendor1_translators_group2']){
            $this->store_GroupInvitations($stage->project_id, $stage->id, request()['vendor1_translators_group2'],1,2 );
           // $this->push_G2Invitations($stage);

        }
        
            
        
    }
    private function store_GroupInvitations($project_id, $stage_id, $groupInput, $vendor, $group )
    {
        foreach ($groupInput as $member) {
           $invitation = new projectsInvitations();
           $invitation->project_id = $project_id;
           $invitation->stage_id = $stage_id;
           $invitation->vendor_id = $member;
           $invitation->group = $group;
           $invitation->vendor = $vendor;
           $invitation->status = 'pending';
           $invitation->save();
            
        }
    }
    private function push_G2Invitations($stage){
     /*  $job = (new  inviteGroup2($stage->id, 1))->delay(Carbon::now()->addSeconds(60*60* $stage->G1_acceptance_hours));
        $job->dispatch();  */
        inviteGroup2::dispatch($stage->id, 1)
                    ->delay(Carbon::now()->addHours($stage->G1_acceptance_hours));

    }
    
    private function storeEditing($project){
        $request = new Request();
        $editing = new editingDetails();
        $editing->project_id=$project->id;
     // $editing->delivery_deadline = request()['delivery_deadline_edit'];
        $editing->G1_acceptance_deadline= Carbon::now()->addHours(request()['acceptance_deadline_edit']);
        $editing->G2_acceptance_deadline= Carbon::now()->addHours(2*request()['acceptance_deadline_edit']);
       /* $editing->vendor_rate = request()['vendor_rate_edit']; 	
        $editing->words_count = request()['words_count_edit'];
        $editing->instructions = request()['instructions_edit']; */
        $editing->save();
    }

}
