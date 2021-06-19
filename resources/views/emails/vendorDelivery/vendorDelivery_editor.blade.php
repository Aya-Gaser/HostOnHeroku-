@component('mail::message')
# Project {{str_pad($project_id, 4, "0", STR_PAD_LEFT )}}-{{str_pad($wo_client, 4, "0", STR_PAD_LEFT )}}  Has New Ready Working File.
Please Login To Take Some Action.

@component('mail::button', ['url' =>route("vendor.view-project",$project_id), 'color' => 'success'])
    View
@endcomponent

Thank You,<br>
Tarjamat LLC 
@endcomponent