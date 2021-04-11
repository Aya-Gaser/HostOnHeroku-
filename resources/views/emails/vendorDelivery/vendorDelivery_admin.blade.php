@component('mail::message')
# Project {{str_pad($project_id, 4, "0", STR_PAD_LEFT )}} Has New Delivery By Translator : {{$vendor_name}}

@component('mail::button', ['url' =>'{{route("management.view-project",$project_id)}}', 'color' => 'success'])
    View
@endcomponent 

Thank You,<br>
Tarjamt LLC 
@endcomponent