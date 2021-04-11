@component('mail::message')
# Project {{str_pad($wo_id, 4, "0", STR_PAD_LEFT )}} has been {{$action}} By Translator : {{$vendor_name}} For the {{$stage_type}} Stage.

@component('mail::button', ['url' =>'{{route("management.view-wo",$wo_id)}}', 'color' => 'success'])
    View
@endcomponent

Thank You,<br>
Tarjamt LLC 
@endcomponent