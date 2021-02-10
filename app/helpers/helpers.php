<?php

use Carbon\Carbon;

if (!function_exists('isActive')) {
    function isActive($name)
    {
        return request()->routeIs($name) ? 'activeNav' : '';
    }
}

if (!function_exists('UTC_To_LocalTime')) {
    function UTC_To_LocalTime($date, $userTimezone ){
            
        // create a $dt object with the America/Denver timezone
        $dt = new DateTime($date, new DateTimeZone('UTC'));
        // change the timezone of the object without changing it's time
        $dt->setTimezone(new DateTimeZone($userTimezone));
        // format the datetime
       return $dt->format('d-M-y H:i T');
    }
}    
if (!function_exists('LocalTime_To_UTC')) {
    function LocalTime_To_UTC($date, $userTimezone ){
            
        // create a $dt object with the America/Denver timezone
        $dt = new DateTime($date, new DateTimeZone($userTimezone));
        // change the timezone of the object without changing it's time
        $dt->setTimezone(new DateTimeZone('UTC')); 
        // format the datetime
       return $dt->format('Y-m-d H:i:s');
    }
}    

if (!function_exists('customize_date_format')) {
    function customize_date_format($originalDate, $format = 'full')
    {
        $date = date('d F Y', strtotime($originalDate));
        $time = date('h:i a', strtotime($originalDate));

        if ($format == 'date') return $date;
        if ($format == 'time') return $time;
        return $date . ' ' . $time;
    }
}

if (!function_exists('covert_job_time_to_member_timezone')) {
    function covert_job_time_to_member_timezone(\App\projects $project, \App\User $user, $customizeDateFormat = false)
    {
        $jobDeliveryDeadline = $project['delivery_deadline'];
        $group1AcceptanceDeadline = $project['G1_acceptance_deadline'];
        $group2AcceptanceDeadline = $project['G2_acceptance_deadline'];
        $userTimezone = $user['timezone'];
        $userTimezoneHours = $user['timezone_hours'];

        if ($userTimezoneHours > 0) {
            $userTimezoneHours = '+' . $userTimezoneHours;
        }

        if ($userTimezoneHours != null) {
            $finalDeliveryDeadline = date('Y-m-d H:i', strtotime($userTimezoneHours . ' hours', strtotime($jobDeliveryDeadline))) . ' Your local time';
            $group1FinalAcceptanceDeadline = date('Y-m-d H:i', strtotime($userTimezoneHours . ' hours', strtotime($group1AcceptanceDeadline))) . ' Your local time';
            $group2FinalAcceptanceDeadline = date('Y-m-d H:i', strtotime($userTimezoneHours . ' hours', strtotime($group2AcceptanceDeadline))) . ' Your local time';
            if ($customizeDateFormat) {
                $finalDeliveryDeadline = customize_date_format(date('Y-m-d H:i', strtotime($userTimezoneHours . ' hours', strtotime($jobDeliveryDeadline)))) . ' Your local time';
                $group1FinalAcceptanceDeadline = customize_date_format(date('Y-m-d H:i', strtotime($userTimezoneHours . ' hours', strtotime($group1AcceptanceDeadline)))) . ' Your local time';
                $group2FinalAcceptanceDeadline = customize_date_format(date('Y-m-d H:i', strtotime($userTimezoneHours . ' hours', strtotime($group2AcceptanceDeadline)))) . ' Your local time';
            }
        } else {
            $finalDeliveryDeadline = date('Y-m-d H:i', strtotime($jobDeliveryDeadline)) . ' ' . config('app.timezone');
            $group1FinalAcceptanceDeadline = date('Y-m-d H:i', strtotime($group1AcceptanceDeadline)) . ' ' . config('app.timezone');
            $group2FinalAcceptanceDeadline = date('Y-m-d H:i', strtotime($group2AcceptanceDeadline)) . ' ' . config('app.timezone');
            if ($customizeDateFormat) {
                $finalDeliveryDeadline = customize_date_format(date('Y-m-d H:i', strtotime($jobDeliveryDeadline))) . ' ' . config('app.timezone');
                $group1FinalAcceptanceDeadline = customize_date_format(date('Y-m-d H:i', strtotime($group1AcceptanceDeadline))) . ' ' . config('app.timezone');
                $group2FinalAcceptanceDeadline = customize_date_format(date('Y-m-d H:i', strtotime($group2AcceptanceDeadline))) . ' ' . config('app.timezone');
            }
        }
        return [
            'delivery_deadline' => $finalDeliveryDeadline,
            'acceptance_deadline' => $group1FinalAcceptanceDeadline,
            'group2_acceptance_deadline' => $group2FinalAcceptanceDeadline
        ];
    }
}

?>