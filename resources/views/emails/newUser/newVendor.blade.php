@component('mail::message')
# Your User Account has been Created

Please login and complete the registration process.
Use your email as a username and the following temporary password: TarjamatMember@1234

@component('mail::button', ['url' =>route("login"), 'color' => 'success'])
    Login
@endcomponent

Thank You,<br>
Tarjamt LLC 
@endcomponent