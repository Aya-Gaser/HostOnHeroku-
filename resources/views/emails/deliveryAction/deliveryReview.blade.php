@php 
$wo_id = str_pad($wo_id, 4, '0', STR_PAD_LEFT );
if($action == 'Improved')
$info = "please find the marked file(s) attached";
else if($action == 'Accepted')
$info = "they were accepted." ;
else 
$info = "however, they were rejected. Please refer to the instructions and take any necessary action." ;  

$body = "# Project ". $wo_id. " Delivery Update " .
"Thank you for delivering the document(s), ". $info;
@endphp


@component('mail::message')
{{$body}}

@component('mail::button', ['url' =>route("vendor.view-project",$wo_id), 'color' => 'success'])
    View
@endcomponent

Thank You,<br>
Tarjamt LLC 
@endcomponent