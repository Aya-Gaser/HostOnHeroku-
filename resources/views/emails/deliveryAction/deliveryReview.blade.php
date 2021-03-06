@php 
$wo_id = str_pad($wo_id, 4, '0', STR_PAD_LEFT );
if($action == 'improved')
$body = "# Your Delivery In Project ". $wo_id." Is "."Reviewed And Improvements Required.
Please Login To Check Required Improvements.";
else 
$body = "# Your Delivery In Project ". $wo_id. " Is " .$action.
"Please Login To Check Your Grade.";
@endphp

@component('mail::message')
{{$body}}

Thank You,<br>
Tarjamt LLC 
@endcomponent