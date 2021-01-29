<?php

namespace App\Jobs;

//use App\Jobs
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;

use App\Mail\newJob;
use App\User;
use App\projectsInvitations;
use App\projects;
use App\projectStage;
use Carbon\Carbon;

class inviteGroup2 implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $project, $vendor, $stage;
    
    public function __construct($stage_id, $vendor)
    {
        $this->stage = projectStage::find($stage_id);
        $this->vendor = $vendor;
        $this->project = projects::find($this->stage->project_id);
        
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
            
        if($this->stage->vendor_id ==null && $this->project){
            $invitations = projectsInvitations::where('project_id',$this->stage->project_id)
                                              ->where('group',2)
                                              ->where('vendor', $this->vendor);
            if($invitations){
               $vendorsGroup = $invitations->get();
               foreach ($vendorsGroup as $invitation) {
            
                    $member = User::find($invitation->vendor_id);
                    if ($member != null)  {
                        
                        $link =  route('vendor.project-offer', ['stage_id' => $this->stage->id, 'group'=> 2,'vendor'=> $this->vendor]);
                        Mail::to($member->email)->send(new newJob($this->stage,$member,'GROUP_2', $link));
                    }
                
              
                }
                $this->stage->G2_acceptance_deadline= Carbon::now()->addHours($this->stage->G2_acceptance_hours);
                $this->stage->save();
            } 
         //  Mail::to('ayagaser30@gmail.com')->send(new newJob());

        }
    }
}