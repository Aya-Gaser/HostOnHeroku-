@component('mail::message')
# Project {{str_pad($wo_client, 4, "0", STR_PAD_LEFT )}}-{{str_pad($wo_id, 4, "0", STR_PAD_LEFT )}}  was successfully completed and is ready to be added to your invoice. 

@component('mail::button', ['url' =>route("vendor.view-project",$wo_id), 'color' => 'success'])
    View
@endcomponent

Thank You,<br>
Tarjamat LLC 
@endcomponent