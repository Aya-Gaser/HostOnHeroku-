@component('mail::message')
# WO {{str_pad($wo_id, 4, "0", STR_PAD_LEFT )}} has been recieved successfully.

@component('mail::button', ['url' =>route("management.view-wo",$wo_id), 'color' => 'success'])
    View
@endcomponent


Thank You,<br>
Tarjamt LLC 
@endcomponent