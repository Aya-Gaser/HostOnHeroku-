
@php

$acceptanceDeadline = ($group == 'GROUP_1') ?  $stage->G1_acceptance_deadline:  $stage->G2_acceptance_deadline;
  


@endphp
@component('mail::message')
Hello,
<br>
This is a message from Tarjamat alerting you of a new project offer available that matched your profile.
@component('mail::table')
| Project Data                  | Info                                                      |
| ------------------------- | ---------------------------------------------------------------------------:|
| Assignment Type           | {{$stage->type}}                                                      |
| Language                  | {{$stage->project->WO->from_language .'▸'.$stage->project->WO->to_language}}                          |
| Word Count                | {{$stage->project->WO->words_count}}                                                  |
| Rate                      | {{$stage['vendor_rate']}}                                                          |
| Offer Expires at          | {{UTC_To_LocalTime($acceptanceDeadline,$vendor->timezone)}} |
| Final Delivery Deadline   | {{UTC_To_LocalTime($stage->deadline,$vendor->timezone)}}   |
@endcomponent
Please login to the system to view the full project details and Accept or Decline this offer
<br>
If you have any questions, do not hesitate to contact us at this email : Projects.TarjamatLLC@gmail.com.
@component('mail::button', ['url' =>$link, 'color' => 'success'])
    View Full Project Data
@endcomponent
@endcomponent