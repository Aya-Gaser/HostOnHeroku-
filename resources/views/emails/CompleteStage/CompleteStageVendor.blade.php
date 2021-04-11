@component('mail::message')
# Project {{str_pad($wo_id, 4, "0", STR_PAD_LEFT )}} Is Successfully Completed.
The word count was updated and the project is complete.
You are able to proceed and add it to you invoice. 

@component('mail::button', ['url' =>route("vendor.view-project",$wo_id), 'color' => 'success'])
    View
@endcomponent

Thank You,<br>
Tarjamt LLC 
@endcomponent