@php 
$wo_id = str_pad($wo_id, 4, '0', STR_PAD_LEFT );
$wo_client = str_pad($wo_client, 4, '0', STR_PAD_LEFT );
if($action == 'Improved')
$info = " requires improvements. Please find the marked file(s) attached. ";
else if($action == 'Accepted')
$info = " has been accepted. " ;
else 
$info = " has been rejected. Please refer to the instructions and take necessary action. " ;  

$body = "# Project ". $wo_client."-".$wo_id. " delivery ". $info;

@endphp


@component('mail::message')
{{$body}}

@component('mail::button', ['url' =>route("vendor.view-project",$stage_id), 'color' => 'success'])
    View
@endcomponent

Thank You,<br>
Tarjamat LLC 
@endcomponent