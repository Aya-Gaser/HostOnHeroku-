<?php

namespace App\Traits;
use App\projectsInvitations;
use App\Mail\newJob;

use Illuminate\Support\Facades\Mail;

trait JobTrait
{
    private function publishJobToSecondGroup($stage)
    {
        $invitations = projectsInvitations::where('stage_id',$stage->id)
                                            ->where('group',2);
        if($invitations){
            $vendorsGroup = $invitations->get();
            foreach ($vendorsGroup as $invitation) {

                $member = User::find($invitation->vendor_id);
                if ($member != null)  {

                    $link =  route('vendor.project-offer', ['stage_id' => $stage->id, 'group'=> 2,'vendor'=> $invitation->vendor]);
                    Mail::to($member->email)->send(new newJob($stage,$member,'GROUP_2', $link));
                }


            }
            $stage->G2_acceptance_deadline= Carbon::now()->addHours($stage->G2_acceptance_hours);
            $stage->save();
        }
    }
}
