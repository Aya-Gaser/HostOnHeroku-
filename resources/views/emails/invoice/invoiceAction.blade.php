@php
if($action == 'Approved')
$info = " and will be paid at the agreed time.";
else
$info = ". Please login and take necessary action. ";
@endphp

@component('mail::message')
#Invoice {{str_pad($invoice_id, 4, "0", STR_PAD_LEFT )}} has been {{$action}} {{$info}}


Thank You,<br>
Tarjamt LLC 
@endcomponent