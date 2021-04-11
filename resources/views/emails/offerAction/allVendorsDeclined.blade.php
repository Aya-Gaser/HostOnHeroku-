@component('mail::message')
# All Vendors Has Declined Project {{str_pad($wo_id, 4, "0", STR_PAD_LEFT )}} For the {{$stage_type}} Stage.

@component('mail::button', ['url' =>route("management.view-wo",$wo_id), 'color' => 'success'])
    View
@endcomponent

Thank You,<br>
Tarjamt LLC 
@endcomponent