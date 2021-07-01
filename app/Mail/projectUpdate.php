<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use \stdClass;
use App\WO;
class projectUpdate extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $wo_id, $isFiles, $updates,$wo,$wo_client, $stage_id;
    public function __construct($wo_id, $isFiles, $updates )
    {
        $this->wo_id = $wo_id;
        $this->isFiles = $isFiles;
        $this->updates = $updates;
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
        return $this->markdown('emails.projectUpdate.projectUpdate')
                     ->with(['wo_id'=>$this->wo_id,'isFiles'=>$this->isFiles,
                            'updates'=>$this->updates,'wo_client'=>$this->wo->client->code, 'stage_id'=>$this->stage_id])
                    ->from('projects@arabictarjamat.com', 'Tarjamat LLC') 
                    ->subject('Project '.str_pad( $this->wo_client, 4, "0", STR_PAD_LEFT )
                    .'-'.str_pad( $this->wo_id, 4, "0", STR_PAD_LEFT ).'  Has Been Updated')->delay(15); 
    
    }
}
