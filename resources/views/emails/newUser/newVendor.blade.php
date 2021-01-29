@component('mail::message')
# Your Membership Account Successfully Created

Please login to complete registration proccess.<br>
Use this temporary password : tarjamatNewMember@1234

@component('mail::button', ['url' => '/login'])
Login
@endcomponent

Thanks,<br>
Tarjamt LLC 
@endcomponent