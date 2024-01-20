<?php

namespace App\Http\Traits;

use App\Models\Log\Meeting\Participant\Participant;

trait ParticipantLog {
    public function logParticipantAction($userId, $action, $object) {
        $log = new Participant();
        $log->participant_id = $userId;
        $log->action = $action;
        $log->object = $object;
        $log->save();
    }
}
