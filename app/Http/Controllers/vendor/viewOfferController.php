<?php

namespace App\Http\Controllers\vendor;

use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use  Illuminate\Support\Facades\Route;
use App\projects;
use Auth;
use App\WO;
use App\User;
use alert;
use App\projectFile;
use App\editingDetails;
use App\projectsInvitations;
use App\Jobs\inviteGroup2;
use App\projectStage;
use App\project_sourceFile;
use App\Mail\newJob;
use Illuminate\Support\Facades\Mail;
use App\Mail\offerAction;
use App\Mail\allVendorsDeclined;
use App\woFiles;
use App\woSourceFiles_toProjectsVendors;
use Illuminate\Http\RedirectResponse;
use Carbon\Carbon;
class viewOfferController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    } 
 
    
    public function isExpired($stage, $group, $vendor){

            $deadline = ($group == 1)? $stage->G1_acceptance_deadline : $stage->G2_acceptance_deadline;
      
            $response =(now()>$deadline)? true : false;
         
           return  $response;
       
    
    }
    public function isAvailable($stage, $vendor){
          $response = ($stage->vendor_id != null)? false : true;
        
        return $response;
          
    }
    public function isDeclined($stage, $group, $vendor){
       $invitation = projectsInvitations::where('project_id', $stage->project_id)
                                    ->where('vendor_id', Auth::user()->id)
                                    ->where('group', $group)
                                    ->where('vendor', $vendor)->first();
         //check of invitaion exsist for this vendor                           
        $status = ($invitation)? $invitation->status : abort(404);
        $response = ($status == 'declined')? true : false;  
        return $response;                             
    }

    
    public function index($stage_id, $group, $vendor){
       // [$project_id, $group, $vendor] = $this->getproject_Id();
        $stage = projectStage::findOrFail($stage_id);
        $project = projects::findOrFail($stage->project_id);
        
        $isExpired = $this->isExpired($stage, $group, $vendor);
        $isAvailable = $this->isAvailable($stage, $vendor);
        $isDeclined = $this->isDeclined($stage, $group, $vendor);
        if($isAvailable && !$isExpired && !$isDeclined)
        {
            $wo = WO::where('id',$stage->wo_id)->first();
        
           
            [$WO_vendorSource_files, $vendorSource_files, $reference_files] = $this->getprojectsFiles($stage->project_id);
            $source_files = $project->project_sourceFile;
            return view('vendor.projectOffer')->with(['stage'=>$stage, 'vendor'=>$vendor,
             'wo'=>$wo,'group'=>$group,
            'source_files'=>$source_files,'reference_file'=>$reference_files,
            'vendorSource_files'=>$vendorSource_files, 'WO_vendorSource_files'=>$WO_vendorSource_files]); 
        }
        else 
       return view('vendor.notAvailable');  
      //  return $isDeclined;
    }
    
    public function getprojectsFiles($project_id){
        $project = projects::find($project_id);
        $reference_file =$project->projectFile->where('type','reference_file');
        $vendorSource_files =$project->projectFile->where('type','vendorSource_file');
        $WO_vendorSource_files = woSourceFiles_toProjectsVendors::where('project_id', $project->id)->get();

        return [$WO_vendorSource_files, $vendorSource_files, $reference_file];
        
    }
    //return 'g';
    public function acceptOffer($stage_id, $group, $vendor){
        $stage = projectStage::findOrFail($stage_id);
        $project = projects::findOrFail($stage->project_id);
        //return $project->id;
        
        $invitation = projectsInvitations::where('project_id', $project->id)
                                        ->where('vendor_id', Auth::user()->id)
                                        ->where('group', $group)
                                        ->where('vendor', $vendor)->first();
        if(!$invitation) abort(404);  
        //else return $invitation;
                                   
        $isExpired = $this->isExpired($stage, $group, $vendor);
        $isAvailable = $this->isAvailable($stage, $vendor);
        $isDeclined = $this->isDeclined($stage, $group, $vendor);
       
        if($isAvailable && !$isExpired && !$isDeclined){
            if($vendor == 1){
                $project->translator_id = Auth::user()->id;

                if($project->isLinked)
                    $this->inviteVendor2($stage);
                   
            }
            else if($vendor == 2)
                 $project->editor_id = Auth::user()->id;
            
            $project->status = 'With Vendor';
           // $this->update_taskStatus($project);
            $stage->vendor_id = Auth::user()->id;
            $stage->status = 'In Progress';
            $stage->save();
            $project->save();
            $invitation->status = 'accepted';
            $invitation->save();
                         
        } 
       $this->sendMail_toProjectCreator($project->id, 'Accepted', $stage->type );
       return redirect(route('vendor.dashboard'));
       
    }

    public function update_taskStatus($project){
        $task = $project->woTaskNeeded;
        $task->status = 'With Vendor';
        $task->save();
    }
    
    public function declineOffer($stage_id, $group, $vendor){
        $stage = projectStage::findOrFail($stage_id);

        $invitation = projectsInvitations::where('project_id', $stage->project_id)
                                     ->where('vendor_id', Auth::user()->id)
                                     ->where('group', $group)
                                     ->where('vendor', $vendor)->first();
          //check of invitaion exsist for this vendor                           
         if(!$invitation)  abort(404);
        $invitation->status = 'declined'; 
        $invitation->save();
        $this->sendMail_toProjectCreator($project->id, 'Declined', $stage->type );

        //check if all deaclined
        
        $invitations_all = projectsInvitations::where('project_id', $stage->project_id)
                                            ->where('group', $group)
                                            ->where('vendor', $vendor)->get();
        $invitationsAll = count($invitations_all);
        $invitations_declined = projectsInvitations::where('project_id', $stage->project_id)
                                            ->where('group', $group)
                                            ->where('vendor', $vendor)
                                            ->where('status','declined')->get();
        $invitationsDeclined = count($invitations_declined);
        
        if($invitationsAll == $invitationsDeclined){
            if($group == 1)
            $this->inviteGroup2($stage, $vendor);
            else
             $this->sendMail_toProjectCreator($stage->project_id, 'allDeclined', $stage->type);

        }
    
        
        return redirect(route('vendor.dashboard'));
    }

    public function inviteVendor2($stage){
         // $includeInQuery = ($job['type'] == Job::JOB_TYPE_LINKED & !$sendMail) ? false : ($group == JobUser::GROUP_1);
         $invitations = projectsInvitations::where('project_id', $stage->project_id)
                                        ->where('group', 1)
                                        ->where('vendor', 2);
        $nextStage = projectStage::where('project_id', $stage->project_id)
                                 ->where('type', 'editing')->first();
        if($invitations && $nextStage){  
            $vendor2Group = $invitations->get();
            foreach ($vendor2Group as $invitation) {
                
                $member = User::find($invitation->vendor_id);

                if ($member != null)  {
                    $link =  route('vendor.project-offer', ['stage_id' => $nextStage->id, 'group'=> 1,'vendor'=>2]);
                    Mail::to($member->email)->send(new newJob($nextStage,$member,'GROUP_1', $link));
                
                }
            }
            $this->push_G2Invitations($nextStage);
        }    

    }

    private function push_G2Invitations($stage){

        $job = (new  inviteGroup2($stage->id, 1))->delay(60*60* $stage->G1_acceptance_hours);
        $this->dispatch($job);
    }

    

    public function sendMail_toProjectCreator($project_id, $action, $stage_type){
        $project = projects::find($project_id);
        $projectCreator = User::find($project->created_by);
        if($action == 'allDeclined')
            Mail::to('Projects.Tarjamatllc@gmail.com')->send(new allVendorsDeclined($project_id, Auth::user()->name, $action, $stage_type));
        else
            Mail::to('Projects.Tarjamatllc@gmail.com')->send(new offerAction($project_id, Auth::user()->name, $action, $stage_type));
    }

    public function inviteGroup2($stage, $vendor){
        $invitations = projectsInvitations::where('project_id', $stage->project_id)
                                         ->where('group', 2)
                                         ->where('vendor', $vendor);
        if($invitations){  
            $vendor2Group = $invitations->get();
            $stage->G2_acceptance_deadline= Carbon::now()->addHours($stage->G2_acceptance_hours);
            $stage->save();
            foreach ($vendor2Group as $invitation) {
                
                $member = User::find($invitation->vendor_id);

                if ($member != null)  {
                    $link =  route('vendor.project-offer', ['stage_id' => $stage->id, 'group'=> 2,'vendor'=>$vendor]);
                    Mail::to($member->email)->send(new newJob($stage,$member,'GROUP_2', $link));
                
                }
            }
        }
    }
    
}
