<?php

namespace App\Mail\invoice;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class vendorInvoiceNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $invoice_id;
    public function __construct($invoice_id)
    {
        $this->invoice_id = $invoice_id;
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.invoice.invoiceNotifyManagement')
                     ->with(['invoice_id'=>$this->invoice_id])
                    ->from('no-reply@arabictarjamat.com', 'Tarjamat LLC') 
                    ->subject('Invoice '.str_pad( $this->invoice_id, 4, "0", STR_PAD_LEFT )
                    .'  Submitted')->delay(15); 
    }
}
