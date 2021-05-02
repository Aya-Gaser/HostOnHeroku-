@component('mail::message')
# Your Membership Account Successfully Created

Please login to complete registration proccess.<br>
Use this temporary password : tarjamatNewMember@1234


@component('mail::button', ['url' =>route("/"), 'color' => 'success'])
    Login
@endcomponent

Thank You,<br>
Tarjamt LLC 
@endcomponent