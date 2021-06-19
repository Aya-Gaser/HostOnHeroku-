<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\projects;
use App\WO;

class allVendorsDeclined extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $project, $stage_type,$wo,$wo_client; 
    public function __construct($project_id, $vendor_name, $action, $stage_type)
    {
        $this->project = projects::find($project_id);
        $this->stage_type = $stage_type;
        $this->wo = WO::find($this->project->wo_id);
        $this->wo_client = $this->wo->client->code;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.offerAction.allVendorsDeclined')
        ->with(['project_id'=>$this->project->id, 'wo_id'=>$this->project->wo_id,
        'wo_client'=>$this->wo->client->code, 'stage_type'=>$this->stage_type])
       ->from('projects@arabictarjamat.com')
       ->subject('Project '.str_pad( $this->project->wo_id, 4, "0", STR_PAD_LEFT )
       .'-'.str_pad( $this->wo_client, 4, "0", STR_PAD_LEFT ).' Has Been Declined By All Vendors ')->delay(15); 
    }
}
