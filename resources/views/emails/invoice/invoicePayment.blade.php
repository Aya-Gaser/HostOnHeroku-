@component('mail::message')
#Invoice {{str_pad($invoice_id, 4, "0", STR_PAD_LEFT )}} has been paid.

Thank You,<br>
Tarjamt LLC 
@endcomponent