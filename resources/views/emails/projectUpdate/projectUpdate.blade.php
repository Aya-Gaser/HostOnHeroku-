@component('mail::message')
# Project {{str_pad($wo_id, 4, "0", STR_PAD_LEFT )}} Has Been Updated.
@if($isFiles)
#Please note that there was a change in the file(s).
 Please login to use the new file(s).
@endif
@if($updates)
#Some project details Has Been Updated 
@component('mail::table')
| Data          | From             | To               |
| ------------- |:----------------:| ----------------:|
@foreach($updates as $data=>$update)
| {{$data}}     |  {{$update[0]}}  |   {{$update[1]}} |  
@endforeach
@endcomponent

@endif

@component('mail::button', ['url' =>route("vendor.view-project",$wo_id), 'color' => 'success'])
    View
@endcomponent

Thank You,<br>
Tarjamt LLC 
@endcomponent