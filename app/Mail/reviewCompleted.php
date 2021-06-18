<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class reviewCompleted extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */ protected $wo_id, $project_id;
    public function __construct($wo_id, $project_id)
    {
        $this->wo_id = $wo_id;
        $this->project_id = $project_id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.vendorReview.reviewCompleted')
        ->with(['wo_id'=>$this->wo_id, 'project_id'=>$this->project_id])
       ->from('ayagaser30@example.com')
       ->subject('Project '.str_pad( $this->wo_id, 4, "0", STR_PAD_LEFT )
       .'  Final Document(s)')->delay(15); 
    }
}
