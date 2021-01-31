<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\projects;
class vendorNewDelivery extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $project_id,$project, $vendor_name,$isAdmin;
    public function __construct($project_id, $vendor_name, $isAdmin)
    {
        $this->project_id = $project_id;
        $this->vendor_name =  $vendor_name;
        $this->isAdmin = $isAdmin;
        $this->project = projects::find($project_id);
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $markdown = ($this->isAdmin)? 'vendorDelivery_admin' : 'vendorDelivery_editor';
        return $this->markdown('emails.vendorDelivery.'.$markdown)
        ->with(['project_id'=>$this->project->wo_id, 'vendor_name'=>$this->vendor_name])
       ->from('ayagaser30@example.com')
       ->subject('Project : '.str_pad( $this->project->wo_id, 4, "0", STR_PAD_LEFT )
       .' Has New Delivey')->delay(15); 
    }
}
