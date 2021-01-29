@php $user = Auth::user() @endphp
{{dd($user->can('permission-slug'))}}
{{dd($user->hasRole('developer'))}} //will return true, if user has role
{{dd($user->givePermissionsTo('create-tasks'))}}// will return permission, if not null
{{dd($user->can('create-tasks'))}} // will return true, if user has permission

@role('developer')

 Hello developer

@endrole