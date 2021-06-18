<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;

class createVendor extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    //protected $vendor;
    public function __construct()
    {
        //$this->vendor = $vendor;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.newUser.newVendor')
                    // ->with(['$vendor'=>$this->vendor])
                    ->from('ayagaser30@gmail.com')
                    ->subject('User Account Created')->delay(15); 
    }
}
