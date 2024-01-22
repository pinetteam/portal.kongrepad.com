<?php

namespace App\Http\Traits;

use App\Models\Log\Meeting\Participant\DailyAccess\DailyAccess;
use App\Models\Log\Meeting\Participant\Participant;

trait ParticipantLog {
    public function logParticipantAction($participant, $action, $object) {
        $log = new Participant();
        $log->participant_id = $participant->id;
        $log->action = $action;
        $log->object = $object;
        $log->save();
        if($participant->dailyAccesses()->where('day', today())->count() == 0){
            $daily_access = new DailyAccess();
            $daily_access->participant_id = $participant->id;
            $daily_access->day = today();
            $daily_access->save();
            $customer = $participant->meeting->customer;
            if($participant->meeting->type == 'standard'){
                $customer->credit = $customer->credit - 10;
            } elseif ($participant->meeting->type == 'premium'){
                $customer->credit = $customer->credit - 12;
            }
            $customer->save();
        }

    }
}
