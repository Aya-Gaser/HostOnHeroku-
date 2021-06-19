@component('mail::message')
# Project {{str_pad($wo_client, 4, "0", STR_PAD_LEFT )}}-{{str_pad($wo_id, 4, "0", STR_PAD_LEFT )}} has been finalized and sent.

@component('mail::button', ['url' =>route("management.view-wo",$wo_id), 'color' => 'success'])
    View
@endcomponent

Thank You,<br>
Tarjamat LLC 
@endcomponent