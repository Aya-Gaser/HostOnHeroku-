<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\WO;
class CompleteStageVendor extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $wo_id, $stage_id, $wo,$wo_client;
    public function __construct($wo_id, $stage_id)
    {
        $this->wo_id = $wo_id;
        $this->stage_id = $stage_id;
        $this->wo = WO::find($this->wo_id);
        $this->wo_client = $this->wo->client->code;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.CompleteStage.CompleteStageVendor')
                     ->with(['wo_id'=>$this->wo_id,'stage_id'=>$this->stage_id,
                     'wo_client'=>$this->wo->client->code])
                    ->from('projects@arabictarjamat.com') 
                    ->subject('Project '.str_pad( $this->wo_id, 4, "0", STR_PAD_LEFT )
                    .'-'.str_pad( $this->wo_client, 4, "0", STR_PAD_LEFT ).' Completed')->delay(15); 
    }
}
