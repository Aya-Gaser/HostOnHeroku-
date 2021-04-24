
@php

$acceptanceDeadline = ($group == 'GROUP_1') ?  $stage->G1_acceptance_deadline:  $stage->G2_acceptance_deadline;
$unit_count =  ($stage->vendor_unitCount)?  $stage->vendor_unitCount : "Target";
$quality_points =  ($stage->vendor_maxQualityPoints)?  $stage->vendor_maxQualityPoints : "Target";

@endphp
@component('mail::message')
Hello,
<br>
# This is a message from Tarjamat alerting you of a new project offer.
@component('mail::table')
| Project Data                  | Info                                                      |
| ------------------------- | ---------------------------------------------------------------------------:|
| Task Type                 | {{$stage->type}}                                                      |
| Language                  | {{$stage->project->WO->from_language .'▸'.$stage->project->WO->to_language}}                          |
@if($stage->type != 'Dtp')
| Word Count                | {{$unit_count}}                                                  |
| MAX Quality Points        | {{$quality_points}}                                                   |
@endif
| Rate Unit                 | {{$stage['vendor_rateUnit']}}                                                          |
| Rate                      | {{$stage['vendor_rate']}}                                                          |
| Offer Expires on          | {{UTC_To_LocalTime($acceptanceDeadline,$vendor->timezone)}} |
| Final Delivery Deadline   | {{UTC_To_LocalTime($stage->deadline,$vendor->timezone)}}   |
@endcomponent
Please login to the system to view the full project details and Accept or Decline this offer
<br>
If you have any questions, do not hesitate to contact us at this email : Projects.TarjamatLLC@gmail.com.

@component('mail::button', ['url' =>$link, 'color' => 'success'])
    View Full Project Data
@endcomponent

Thank You,<br>
Tarjamt LLC 
@endcomponent