<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use \stdClass;
class projectUpdate extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $wo_id, $isFiles, $updates;
    public function __construct($wo_id, $isFiles, $updates )
    {
        $this->wo_id = $wo_id;
        $this->isFiles = $isFiles;
        $this->updates = $updates;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.projectUpdate.projectUpdate')
                     ->with(['wo_id'=>$this->wo_id,'isFiles'=>$this->isFiles,
                            'updates'=>$this->updates])
                    ->from('ayagaser30@example.com') 
                    ->subject('Project : '.str_pad( $this->wo_id, 4, "0", STR_PAD_LEFT )
                    .'  Has Been Updated')->delay(15); 
    
    }
}
