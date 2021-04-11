@component('mail::message')
# Project {{str_pad($wo_id, 4, "0", STR_PAD_LEFT )}} is successfully graded. 
Please Login To Check Final Grading.  

@component('mail::button', ['url' =>'{{route("vendor.view-project",$project_id)}}', 'color' => 'success'])
    View
@endcomponent

Thank You,<br>
Tarjamt LLC 
@endcomponent