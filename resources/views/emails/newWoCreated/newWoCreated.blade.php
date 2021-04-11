@component('mail::message')
# There is a Work Order that was issued with ID {{str_pad($wo_id, 4, "0", STR_PAD_LEFT )}}, please take necessary action. 

@component('mail::button', ['url' =>route("management.view-wo",$wo_id), 'color' => 'success'])
    View
@endcomponent

Thank You,<br>
Tarjamt LLC 
@endcomponent