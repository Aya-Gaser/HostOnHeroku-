@component('mail::message')
#Invoice {{str_pad($invoice_id, 4, "0", STR_PAD_LEFT )}} has been submitted. Please take necessary action. 

@component('mail::button', ['url' =>route("management.view-paymentInvoice",$invoice_id), 'color' => 'success'])
    View
@endcomponent

Thank You,<br>
Tarjamat LLC 
@endcomponent