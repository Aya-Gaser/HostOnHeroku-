<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class readyToProofFile extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $wo_id;
    public function __construct($wo_id)
    {
        $this->wo_id = $wo_id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.proofingAndFinalization.readyToProofFile')
        ->with(['wo_id'=>$this->wo_id])
       ->from('ayagaser30@example.com') 
       ->subject('WO '.str_pad( $this->wo_id, 4, "0", STR_PAD_LEFT ) 
       .' Has New File(s) Ready To Proofing Proccess ')->delay(15); 
    }
}