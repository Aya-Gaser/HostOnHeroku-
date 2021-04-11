<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\WO;
class WoRecieved extends Mailable
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
        return $this->markdown('emails.wo.woRecieved')
                     ->with(['wo_id'=>$this->wo_id])
                    ->from('ayagaser30@example.com')
                    ->subject('WO '.str_pad( $this->wo_id, 4, "0", STR_PAD_LEFT )
                    .' has been recieved')->delay(15); 
    }
}
