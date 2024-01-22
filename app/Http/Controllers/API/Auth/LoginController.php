<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Traits\ParticipantLog;
use App\Models\Meeting\Participant\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use ParticipantLog;
    public function participant(Request $request)
    {
        $participant = Participant::where('username', $request->username)->first();
        if (!$participant) {
            return response([
                'message' => ['The provided credentials are incorrect.']
            ], 500);
        }
        $participant_token = $participant->createToken('api-token')->plainTextToken;
        $participant->gdpr_consent = true;
        $participant->enrolled = true;
        $participant->save();
        $this->logParticipantAction($participant, "login", $participant->full_name);
        return response(['token' => $participant_token], 200);
    }
}
