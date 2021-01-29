@component('mail::message')
# Project : {{str_pad($wo_id, 4, "0", STR_PAD_LEFT )}} Has Been Updated.
@if($isFiles)
#New Working Files Has Been Upload 
@endif
@if($updates)
#Some Data Has Been Updated 
@component('mail::table')
| Data          | From             | To               |
| ------------- |:----------------:| ----------------:|
@foreach($updates as $data=>$update)
| {{$data}}     |  {{$update[0]}}  |   {{$update[1]}} |  
@endforeach
@endcomponent

@endif

Thanks,<br>
Tarjamt LLC 
@endcomponent