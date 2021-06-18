<?php

namespace App\Http\Controllers\vendor;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use App\Http\Controllers\Controller;
use App\User;
use App\projects;
use Auth;
use App\WO;
use alert;
use App\projectFile;
use App\editingDetails;
use App\projectsInvitations;
use App\projectStage;
use App\vendorDelivery;
use App\deliveryFiles;
use App\project_sourceFile;
use Carbon\Carbon;
use DateTime;
use App\woFiles;
use App\woSourceFiles_toProjectsVendors;

use Illuminate\Support\Facades\Mail;
use App\Mail\vendorNewDelivery;
class viewAllProjectsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    } 
    //// view all/status
    public function index($filter){ 
        $this->validateFilter($filter); 
        if($filter == 'undelivered') $filter = 'Not delivered';
        if($filter == 'Completed')
            $stages = projectStage::where('vendor_id', Auth::user()->id)
                                  ->where('readyToInvoice', 1)->get();

        else
            $stages = ($filter == 'all')? projectStage::where('vendor_id', Auth::user()->id)->get(): $this->filterProjects($filter);       
        
        return view('vendor.viewAllProjects')->with(['stages'=>$stages, 'filter'=>$filter]);
    }
    public function filterProjects($filter){
       // if($filter == '')
        $stages = projectStage::where('vendor_id', Auth::user()->id)
                                  ->where('status', $filter)->get();
        return $stages;
    }
    public function validateFilter($filter){
        if($filter == 'undelivered') $filter = 'Not delivered';

        $filters = array('all','Not delivered', 'Delivered', 'Completed', 'reviewed', 'invoiced');
        if(!in_array($filter, $filters))
          abort(404);
    }
    ////view a project
    public function viewProject($id){
       $stage = projectStage::findOrfail($id);
       $project = projects::findOrfail($stage->project_id);
       $wo = WO::where('id', $project->wo_id)->first();
       //[$source_files,$reference_file, $target_file] =  $this->getprojectFile($wo); //'wo->files';
      
       $view = 'vendor.viewProject';
       $isEditing=0;
      // [$source_files,$reference_file, $target_file];
       if($project->type == 'linked'){
            $isEditing = ($stage->type == 'editing')? true : false;
       } 
      
       return $this->firstStage_view($wo, $project, $stage, $isEditing);  
        
          
            
    }
    public function firstStage_view($wo, $project, $stage, $isEditing){
        if($isEditing){
           $transStage = projectStage::where('project_id', $stage->project_id)
                                       ->where('type', 'translation')->first(); 
           $view = 'vendor.viewProject_linkededitor'; 
           [$deliver_withFiles,$thisVendor_delivery] =  $this->getWo_Deliveriesfiles($stage, $transStage);           
        }
        else{
            $view = 'vendor.viewProject'; 
            [$deliver_withFiles,$thisVendor_delivery] =  $this->getWo_Deliveriesfiles($stage); 
        }
         
        [$WO_vendorSource_files, $vendorSource_files, $reference_file] =  $this->getprojectFile($project); //'wo->files';
        $deadline_difference = $this->deadline_difference($stage);
        return view($view)->with(['deliver_withFiles'=>$deliver_withFiles, 'thisVendor_delivery'=> $thisVendor_delivery,
        'reference_file'=> $reference_file,'vendorSource_files'=> $vendorSource_files, 
        'WO_vendorSource_files'=>$WO_vendorSource_files, 'wo'=>$wo, 'project'=>$project,
         'stage'=>$stage, 'deadline_difference'=>$deadline_difference]);

    }
    public function deadline_difference($stage){
        $deadline = new DateTime($stage->deadline);//deadline time
        $current_date_time = new DateTime("now");
        $sign = '<span class="text-danger">After deadline</span>';
        if($deadline > $current_date_time )
        $sign = '<span class="text-success">Before deadline</span>';
        $diff = $current_date_time->diff($deadline);
        //$diff->format(' %d days %H hours %i minutes ').$sign;
        return $diff->format(' %d days %H hours %i minutes ').$sign;

    }
    public function getprojectFile($project){
        $reference_file =$project->projectFile->where('type','reference_file');
        $vendorSource_files =$project->projectFile->where('type','vendorSource_file');
        
        $WO_vendorSource_files = woSourceFiles_toProjectsVendors::where('project_id', $project->id)->get();

        return [$WO_vendorSource_files, $vendorSource_files, $reference_file];

    }
  
     public function getWo_Deliveriesfiles($currentStage, $transStage = false){
        $project = projects::findOrFail($currentStage->project_id);
        $files = projects::with('project_sourceFile')->findOrFail($project->id); 
        
        $thisVendor_delivery = vendorDelivery::where('vendor_id',Auth::user()->id)
                                         ->where('stage_id',$currentStage->id)->orderBy('created_at','desc')->get();
        $thisVendor_delivery_g = $thisVendor_delivery->groupBy('sourceFile_id');
        $files->thisVendor_delivery = $thisVendor_delivery_g;

        if( $project->type == 'linked' && $currentStage->type == 'editing'){
            
               $translator_delivery = vendorDelivery::where('vendor_id',$transStage->vendor_id)
                                                    ->where('stage_id',$transStage->id)
                                                    ->where('status','!=','rejected')
                                                    ->where('status','!=','canceled')
                                                   ->orderBy('created_at','desc')->get();
                $translator_delivery_g = $translator_delivery->groupBy('sourceFile_id');
               $files->translator_delivery = $translator_delivery_g;
               
          } 
          return [$files,$thisVendor_delivery];
     }

     ///////////////////////// storeDelivery ///////////
     public function storeDelivery($stage, $sourceFile){
         //check if both not null, check if both  are hers
         $stage = projectStage::findOrFail($stage);
         $project = projects::findOrFail($stage->project_id); 
         $sourceFile = project_sourceFile::findOrFail($sourceFile);
        
         if (request()['delivery_file'.$stage->id]) {
            $attachment = request()['delivery_file'.$stage->id];
            $extension = $attachment->extension();
            $fileName = $stage->wo_id .$stage->project_id.$stage->id. '_' . $attachment->getClientOriginalName() . time() . '_' . rand(1111111111, 99999999) . str_random(10) . '.' . $extension;
            $filePath = '/delivery_files/' . $stage->wo_id.'/'.$stage->project_id.'-'.$stage->id .'/';
            Storage::putFileAs('public' . $filePath, new File($attachment), $fileName);

            $delivery = new vendorDelivery();
            $delivery->wo_id = $stage->wo_id;
            $delivery->project_id = $project->id;
            $delivery->stage_id = $stage->id;
            $delivery->sourceFile_id = $sourceFile->id;
            $delivery->vendor_id = Auth::user()->id;
            $delivery->status = 'pending';
            $delivery->file_name = $attachment->getClientOriginalName();
            $delivery->file = $filePath . $fileName;
            $delivery->extension = $extension;
            
            $diff = $this->deadline_difference($stage);
            $delivery->deadline_difference = $diff;
           // echo $interval->format('%Y years %m months %d days %H hours %i minutes');  
            $delivery->save();

            if($stage->accepted_docs >= $stage->required_docs){
                $stage->status = 'Delivered';
                $stage->save();
            }

            if($project->type =='linked' && $stage->type == 'translation'){
              //mail to editor
              $editingStage = projectStage::where('project_id',$project->id)
                                          ->where('type','editing')->first();
              $editor = User::find($editingStage->vendor_id);                            
              Mail::to($editor->email)->send(new vendorNewDelivery($project->id, Auth::user()->name,'editor'));
    
            }
             //mail to creator
             $projectCreator = User::find($project->created_by);
             Mail::to($projectCreator->email)->send(new vendorNewDelivery($project->id, Auth::user()->name,'admin'));
             

        }
        return back();   
        alert()->success('delivery submitted Successfully !')->autoclose(false);
        //return response()->json(['success'=>'File Uploaded Successfully']);      
     // return redirect('/allWo');
    }
    
    public function REsendDelivery($stage, $delivery){
        $delivery = vendorDelivery::find($delivery);
        $delivery->status = ($delivery->status == 'rejected')? 'rejected' :'canceled';
        $delivery->save();
        $sourceFile = $delivery->sourceFile_id;
        return $this->storeDelivery($stage, $sourceFile);
    }
    
   

     public function deliveryFile_action(){
         ////// validate parameters
         $action = request()['action'];
         $deliveryId = request()['deliveryId'];
         $delivery = vendorDelivery::findOrFail($deliveryId);
         $delivery->isReceived = true;
         $actions = ['accepted', 'rejected'];
         if(!in_array($action, $actions))
           abort(404);
        

        if($action == 'accepted')
          $this->accept_deliveryFile($delivery) ;
        else
         $this->reject_deliveryFile($delivery) ;
        
        return back();    
     }  
     public function accept_deliveryFile($delivery){
        $delivery->status = 'accepted';
        $stage = projectStage::where('id', $delivery->stage_id)->first();
        $stage->increment('accepted_docs');
       
        $stage->status = ($stage->accepted_docs == $stage->required_docs)? 'Delivered' : 'Undelivered';
       /*
        if( $stage->status == 'accepted'){
       
        }*/
        //mail
       
        $stage->save();
        $delivery->save();
       
     }
     public function reject_deliveryFile($delivery){
        if(request()['notes']) 
               $delivery->notes = request()['notes'];
        $delivery->status = 'rejected'; /* *************************************** */
        //mail
        $delivery->save();
     }



     
}
