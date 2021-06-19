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
use App\WO;
class newJob extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $stage,$vendor,$group,$link, $project,$wo,$wo_client;
    public function __construct(projectStage $stage, User $vendor, $group, $link)
    {   
        $this->stage = $stage;
        $this->vendor = $vendor;
        $this->group = $group;
        $this->link = $link;
        $this->wo = WO::find($this->stage->wo_id);

        $this->wo_client = $this->wo->client->code;

        
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
                    ->from('projects@arabictarjamat.com') 
                    ->subject('Project '.str_pad( $this->wo_client, 4, "0", STR_PAD_LEFT )
                    .'-'.str_pad( $this->stage->wo_id, 4, "0", STR_PAD_LEFT ).' - Action Needed')->delay(15); 
    
  //  return $this->markdown('emails.newJob.projectsAdmin');
    }
}
