<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Models\Meeting\Participant\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
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
        $log = new \App\Models\Log\Meeting\Participant\Participant();
        $log->participant_id = $participant->id;
        $log->action = "login";
        $log->save();
        return response(['token' => $participant_token], 200);
    }
}
