<?php

namespace App\Http\Controllers\projects;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\projects;
use App\WO;
use App\project_sourceFile;
use Auth;
use App\vendorDelivery;
use App\projectStage;
use App\editedFile;
use SweetAlert;
use App\finalizedFile;
use App\projectFile;
use Carbon\Carbon;
use DateTime;
use \stdClass;
use App\User;
use App\improvedFiles;
use Illuminate\Support\Facades\Mail;
use App\Mail\projectUpdate;
class viewProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    } 
 
    public function index($id){
        $project = projects::findOrFail($id);
        $has_proofAndFinalize = $project->woTasksNeeded->has_proofAndFinalize;
        [$delivery_files,$deliveryHistory_files] =  $this->getProject_Deliveriesfiles($project);    
        ($project->type == 'linked')? $view = 'admins.viewProject_linked': $view = 'admins.viewproject';
        $deliveries_edited = $this->getSource_acceptedDelivery_edited($project);
        //$ifNextProject = $this->ifHas_nextProject($project);
        $reference_files = $this->getprojectsFiles($project);
        $source_files = $project->project_sourceFile;
        $deadline_difference = $this->deadline_difference($project);
        return view($view)->with(['project'=>$project, 'has_proofAndFinalize'=>$has_proofAndFinalize,
        'source_files'=>$source_files, 'reference_files'=> $reference_files,
          'delivery_files'=>$delivery_files,
         'deliveryHistory_files'=>$deliveryHistory_files, 'deliveries_edited'=>$deliveries_edited,
          'deadline_difference'=>$deadline_difference]);
        
    }
    public function deadline_difference($project){
        $deadline = new DateTime($project->delivery_deadline);//deadline time
        $current_date_time = new DateTime("now");
        $sign = '<span class="text-danger">After deadline</span>';
        if($deadline > $current_date_time )
        $sign = '<span class="text-success">Before deadline</span>';
        $diff = $current_date_time->diff($deadline);
        //$diff->format(' %d days %H hours %i minutes ').$sign;
        return $diff->format(' %d days %H hours %i minutes ').$sign;;

    }
    public function getprojectsFiles($project){
        $reference_file =$project->projectFile->where('type','reference_file');
        return $reference_file;
        
    }
    public function getProject_Deliveriesfiles($project){
        $delivery_files = [];
        $deliveryHistory_files = [];
        $delivery_files =  projects::with('project_sourceFile') ->findOrFail($project->id); 
        
        $firstStage = projectStage::where('project_id', $project->id)->first(); 
        if($project->status == 'on progress' ){
            ///get translator deliveries 
            $translator_delivery = vendorDelivery::where('vendor_id',$project->translator_id)
                                                 ->where('stage_id',$firstStage->id);
            //if($translator_delivery){
                $translator_delivery = $translator_delivery->orderBy('created_at','desc')->get();
                $translator_delivery_g = $translator_delivery->groupBy('sourceFile_id');
          //  }
            $delivery_files->translator_delivery = $translator_delivery_g;
            $deliveryHistory_files['translator_delivery'] = $translator_delivery;
        }
        ///get editor deliveries 

        if( $project->type == 'linked' &&  $project->status == 'on progress' ){
            $editStage = projectStage::where('project_id', $project->id)
                                     ->where('type', 'editing')->first(); 

            $editor_delivery = vendorDelivery::where('vendor_id',$project->editor_id)
                                             ->where('stage_id',$editStage->id)->orderBy('created_at','desc')->get();
            $editor_delivery_g = $editor_delivery->groupBy('sourceFile_id');
            $delivery_files->editor_delivery = $editor_delivery_g;  
            $deliveryHistory_files['editor_delivery'] = $editor_delivery;
 
          } 
          return [$delivery_files,$deliveryHistory_files];
     }

     public function getSource_acceptedDelivery_edited($project){
        $lastStage_id = projectStage::where('project_id',$project->id)
                                    ->where('lastIn_project',1)->first()->id;
        
        $delivery_files = projects::with('project_sourceFile', 'project_sourceFile.editedFile')->findOrFail($project->id); 
       
        $lastAccepted_delivery = vendorDelivery::where('stage_id',$lastStage_id)
                                                 ->where('status','accepted')->orderBy('created_at','desc')->get();
        $lastAccepted_delivery_g = $lastAccepted_delivery->groupBy('sourceFile_id');
        $delivery_files->lastAccepted_delivery = $lastAccepted_delivery_g;  

        return $delivery_files;

     }

     public function ifHas_nextProject($project){
        $nextProject = projects::where('wo_id', $project->wo_id)
                               ->where('numInWo', ($project->numInWo) + 1 )->first();
        if($nextProject)
           return $nextProject;
        else
          return null;                         
     }

     public function store_EditedFile($project, $sourceFile){
       $project = projects::find($project);
       $project->isReadyToProof = true;
       $project->save();
       $editedFile = new editedFile();
        $editedFile->project_id = $project->id;
        $editedFile->sourceFile_id = $sourceFile;
        $editedFile->created_by = Auth::user()->id;
        $this->send_toFinalization($sourceFile);
       //get file
       $attachment = request()['edited_file'];
       $extension = $attachment->extension();
       $fileName = $project->wo_id . '_'.$project->id . $attachment->getClientOriginalName() . time() . '_' . rand(1111111111, 99999999) . str_random(10) . '.' . $extension;
       $filePath = '/wo_editedFiles/' . $project->wo_id . '/';
       Storage::putFileAs('public' . $filePath, new File($attachment), $fileName);

       $editedFile->file_name = $attachment->getClientOriginalName();
       $editedFile->file = $filePath . $fileName;
       $editedFile->extension = $extension;
       $editedFile->save();

       return back();
         
     }

     public function delete_EditedFile($editedFile){
         $editedFile = editedFile::find($editedFile);
         $sourceFile = project_sourceFile::find($editedFile->sourceFile_id);  
         $sourceFile->readyTo_finalize = false; 
         $sourceFile->save();
         $editedFile->delete();

         return back();
         
     }

     public function send_toFinalization($sourceFile){
       
        $sourceFile = project_sourceFile::find($sourceFile);  
        $sourceFile->isReadyToProof = true; 
        $sourceFile->save();
       // alert()->success('Project Created Successfully !')->autoclose(false);    
        return back();
     }

     public function store_finalizedFile($project, $sourceFile ){
        $project = projects::find($project);
        //$sourceFile = project_sourceFile::find($sourceFile);

         $finalizedFile = new finalizedFile();
         $finalizedFile->project_id = $project->id;
         $finalizedFile->sourceFile_id = $sourceFile;
         $finalizedFile->created_by = Auth::user()->id;
        //get file
        $attachment = request()['finalized_file'];
        $extension = $attachment->extension();
        $fileName = $project->wo_id . '_'.$project->id . $attachment->getClientOriginalName() . time() . '_' . rand(1111111111, 99999999) . str_random(10) . '.' . $extension;
        $filePath = '/wo_finalizedFiles/' . $project->wo_id . '/';
        Storage::putFileAs('public' . $filePath, new File($attachment), $fileName);
 
        $finalizedFile->file_name = $attachment->getClientOriginalName();
        $finalizedFile->file = $filePath . $fileName;
        $finalizedFile->extension = $extension;
        $finalizedFile->save();
 
        return back();
          
      }
      public function delete_finalizedFile($finalizedFile){
        $finalizedFile = finalizedFile::findOrFail($finalizedFile);
        $finalizedFile->delete();

        return back();
        
    }

    public function complete_reOpen_sourceFile($sourceFile, $complete){
        $sourceFile = project_sourceFile::findOrFail($sourceFile);  
        $sourceFile->isCompleted = $complete; //1 >> complete
        $sourceFile->save();

        return back();
    }

    public function complete_reOpen_vendorStage(Request $request){
        $request->validate([
            
            'complete' => 'required',
            'stageId' => 'required',
          ]);
        $stageId = $request->input('stageId'); 
        $complete = $request->input('complete');  
        $stage = projectStage::findOrFail($stageId); 
        if($complete){
            if($request->input('wordsCount'))
                $stage->vendor_wordsCount = $request->input('wordsCount');
        }      
         
        $stage->status = ($complete)? 'completed' : 'accepted'; //1 >> complete
        
        $stage->save();

        return response()->json(['success'=>'Done Successfully']);      
    }
    
    public function sendFinalized_toNextProject($finalizedFile){
        $finalizedFile = finalizedFile::findOrFail($finalizedFile);
        $project = projects::findOrFail($finalizedFile->project_id);
        $nextProject = projects::where('wo_id', $project->wo_id)
                               ->where('numInWo', ($project->numInWo) + 1 )->first();
        $finalizedFile->isSentToNext = true;
        $finalizedFile->save();
        return $this->storeFinalizedAs_sourceFile( $nextProject, $finalizedFile);
    }

    private function storeFinalizedAs_sourceFile( $nextProject, $finalizedFile){

        //save each file 
        $project_sourceFiles =new project_sourceFile();
        $project_sourceFiles->wo_id =$nextProject->wo_id;
        $project_sourceFiles->project_id =$nextProject->id;
        $project_sourceFiles->file_name = $finalizedFile->file_name;
        $project_sourceFiles->file = $finalizedFile->file;
        $project_sourceFiles->extension = $finalizedFile->extension;
        $project_sourceFiles->readyTo_finalize = false;
        $project_sourceFiles->save();
        
        return back();

        }

        public function deleteAttachment($fileId, $type){
            if($type == 'source')
                $file = project_sourceFile::find($fileId);
            else
                $file = projectFile::find($fileId);
            $file->delete();
            
            return back();

        }
        public function complete_reOpen_project($project, $complete){
            $project = projects::findOrFail($project);  
            $project->status = ($complete)? 'completed' : 'on progress'; //1 >> complete
            $project->save();
    
            return back();
        }

        public function updateProject($projectId){
            $project = projects::findOrFail($projectId);
            $request = new Request();
            $files = false;
            if(request()['project_name_edit'])
               $project->name = request()['project_name_edit'];
            if ($request->hasFile('source_files')) {
                $this->uploadWoAttachments($project->id, 'source_files','source_file');
                $files = true;
            }
            if ($request->hasFile('reference_files')) {
                $this->uploadWoAttachments($project->id, 'reference_files','reference_file');
                $files = true;
            }
            if ($request->hasFile('target_files')) {
                $this->uploadWoAttachments($project->id, 'target_files','target_file');
                $files = true;
            }
           $project->save(); 
           if($files){
               $stages = $project->projectStage;
               foreach($stages as $stage){
                   $vendor_id = $stage->vendor_id;
                   if($vendor_id && $stage->status != 'completed'){
                      $vendor = User::find($vendor);
                      Mail::to($vendor->email)->send(new projectUpdate($project->wo_id,$files, null));
                    }   
                }
            }
           return back();   
        }

        public function updateStage($stageId){
            $stage = projectStage::findOrFail($stageId);
            $isUser = false;
            if($stage->vendor_id){
                $vendor = User::find($stage->vendor_id)->first();
                $isUser = true;
            }   
            $updates = [];
            if(request()['words_count_'.$stage->id] ){ 
                if($stage->vendor_wordsCount != request()['words_count_'.$stage->id]){
                    $old_wordCount = ($stage->vendor_wordsCount)? $stage->vendor_wordsCount : 'Target';
                    $updates['Word Count'] = [$old_wordCount, request()['words_count_'.$stage->id]];
                    $stage->vendor_wordsCount = request()['words_count_'.$stage->id];
                }
            }  
            if(request()['maxQuality_points_'.$stage->id]){ 
                if($stage->vendor_maxQualityPoints != request()['maxQuality_points_'.$stage->id]){
                    $old_qualityPoints = ($stage->vendor_maxQualityPoints)? $stage->vendor_maxQualityPoints : 'Target';
                    $updates['MAX Quality points'] = [$old_qualityPoints, request()['maxQuality_points_'.$stage->id]];
                    $stage->vendor_maxQualityPoints = request()['maxQuality_points_'.$stage->id];
                }
            }    
            if(request()['rate_unit_'.$stage->id]){ 
                if($stage->vendor_rateUnit != request()['rate_unit_'.$stage->id]){
                    $updates['Unit'] = [$stage->vendor_rateUnit, request()['rate_unit_'.$stage->id]];
                    $stage->vendor_rateUnit = request()['rate_unit_'.$stage->id];
                }
            } 
            if(request()['vendor_rate_'.$stage->id]){ 
                if($stage->vendor_rate != request()['vendor_rate_'.$stage->id]){
                    $updates['Rate'] = [$stage->vendor_rate, request()['vendor_rate_'.$stage->id]];
                    $stage->vendor_rate = request()['vendor_rate_'.$stage->id];
                }
            } 
            if(request()['required_docs_'.$stage->id]){ 
                if($stage->required_docs != request()['required_docs_'.$stage->id]){
                    $updates['Sent Files'] = [$stage->required_docs, request()['required_docs_'.$stage->id]];
                    $stage->required_docs = request()['required_docs_'.$stage->id];
                }
            } 
            if(request()['vendor_deadline_'.$stage->id]) {
                
                $deadline = LocalTime_To_UTC(request()['vendor_deadline_'.$stage->id], Auth::user()->timezone);
                if($stage->deadline != $deadline){
                    if($isUser){
                        $updates['Delivery Deadline'] = [ UTC_To_LocalTime($stage->deadline,$vendor->timezone), UTC_To_LocalTime($deadline,$vendor->timezone)];
                        $stage->deadline = $deadline;
                    }
                }
            }
            if(request()['instructions_'.$stage->id]){
                if($stage->instructions != request()['instructions_'.$stage->id]){
                    $updates['Instructions'] = [$stage->instructions, request()['instructions_'.$stage->id]];   
                    $stage->instructions = request()['instructions_'.$stage->id];
                }
            }
            $stage->save();
            if($isUser){
                Mail::to($vendor->email)->send(new projectUpdate($stage->wo_id, false,$updates));
            }    
          /*  return view('emails.projectUpdate.projectUpdate')->with(['wo_id'=>$stage->wo_id,
            'isFiles'=>true,'updates'=>$updates]); */
             //response()->json($updates);   
             return back();
        }
        private function uploadWoAttachments( $project_id, $attachmentInputName, $inputType)
        { 
            foreach (request()->file($attachmentInputName) as $attachment) {
                $extension = $attachment->extension();
                $fileName = $project_id . '_' . $attachment->getClientOriginalName() . time() . '_' . rand(1111111111, 99999999) . str_random(10) . '.' . $extension;
                if($inputType != 'source_file'){ 
                      $filePath = '/projects_files/' . $project_id . '/';
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
                      $project_sourceFile->readyTo_finalize = false;
                      $project_sourceFile->save();
                  
      
                }
                   
             }
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
           
           return  response()->json(['success'=>'Done Successfully']);     
        }  
        public function accept_deliveryFile($delivery){
           $delivery->status = 'accepted';
           $stage = projectStage::where('id', $delivery->stage_id)->first();
           $stage->increment('accepted_docs');
           $stage->status = ($stage->accepted_docs == $stage->required_docs)? 'accepted' : 'pending';
           if(request()['notes']) 
               $delivery->notes = request()['notes'];
           if( $stage->status == 'accepted'){
          
           }
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
   
        public function deliveryFile_improve(){
            ////// validate parameters
            
            $deliveryId = request()['deliveryId_improve'];
            $delivery = vendorDelivery::find($deliveryId);
            $delivery->status = 'improved';
            if(request()['notes_improved'])
                    $delivery->notes = request()['notes_improved'];
            $delivery->save();
            
            $project_id = $delivery->project_id;
            foreach (request()->file('improved_files') as $attachment) {
                $extension = $attachment->extension();
                $fileName = $project_id . $deliveryId.'_' . $attachment->getClientOriginalName() . time() . '_' . rand(1111111111, 99999999) . str_random(10) . '.' . $extension;
            
                $filePath = '/improved_files/' . $project_id . '/'.$deliveryId.'/';
                Storage::putFileAs('public' . $filePath, new File($attachment), $fileName);
    
                //save each file 
                $improvedFile =new improvedFiles();
                $improvedFile->deliveryFile_id = $deliveryId;
                $improvedFile->created_by = Auth::user()->id;
                $improvedFile->file_name = $attachment->getClientOriginalName();
                $improvedFile->file = $filePath . $fileName;
                $improvedFile->extension = $extension;
                $improvedFile->save();
                }

                return response()->json(['success'=>'File Uploaded Successfully']);      
        }
        public function destroy($projectId){
            $project = projects::findOrFail($projectId);
            $project->delete();
            alert()->success('Wo Deleted Successfully !')->autoclose(15);
              //return response()->json(['success'=>'File Uploaded Successfully']);      
           // return redirect(route('management.view-allWo'));
         }
      

}
