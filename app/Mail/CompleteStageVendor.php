<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CompleteStageVendor extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $wo_id, $stage_id;
    public function __construct($wo_id, $stage_id)
    {
        $this->wo_id = $wo_id;
        $this->stage_id = $stage_id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.CompleteStage.CompleteStageVendor')
                     ->with(['wo_id'=>$this->wo_id,'stage_id'=>$this->stage_id])
                    ->from('ayagaser30@example.com') 
                    ->subject('Project '.str_pad( $this->wo_id, 4, "0", STR_PAD_LEFT )
                    .' Completed')->delay(15); 
    }
}
