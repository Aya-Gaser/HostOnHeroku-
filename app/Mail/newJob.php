<?php

namespace App\Mail;
use Illuminate\Support\Facades\URL;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\projects;
use App\projectStage;
use App\User;
class newJob extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $stage,$vendor,$group,$link, $project;
    public function __construct(projectStage $stage, User $vendor, $group, $link)
    {   
        $this->stage = $stage;
        $this->vendor = $vendor;
        $this->group = $group;
        $this->link = $link;
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
                                                                                             
        $this->project = projects::find($this->stage->project_id);
        return $this->markdown('emails.newJob.projectsAdmin')
                     ->with(['stage'=>$this->stage,'project'=>$this->project, 'vendor'=> $this->vendor,
                      'group'=>$this->group,'link'=>$this->link])
                    ->from('ayagaser30@example.com') 
                    ->subject('New Offer from Tarjamat '.str_pad( $this->stage->wo_id, 4, "0", STR_PAD_LEFT ))->delay(15); 
    
  //  return $this->markdown('emails.newJob.projectsAdmin');
    }
}
