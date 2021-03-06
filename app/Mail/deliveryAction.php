<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class deliveryAction extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $wo_id, $action;
    public function __construct($wo_id, $action)
    {
        $this->wo_id = $wo_id;
        $this->action = $action;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.deliveryAction.deliveryReview')
                     ->with(['wo_id'=>$this->wo_id,'action'=>$this->action])
                    ->from('ayagaser30@example.com') 
                    ->subject('Your Delivery For Project '.str_pad( $this->wo_id, 4, "0", STR_PAD_LEFT )
                    .'  Has Been Reviewed')->delay(15); 
    }
}
