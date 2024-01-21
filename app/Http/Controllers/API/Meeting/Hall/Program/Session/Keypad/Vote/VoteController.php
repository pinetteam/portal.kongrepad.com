<?php

namespace App\Http\Controllers\API\Meeting\Hall\Program\Session\Keypad\Vote;

use App\Http\Controllers\Controller;
use App\Http\Traits\ParticipantLog;
use App\Models\Meeting\Hall\Program\Session\Keypad\Vote\Vote;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    use ParticipantLog;
    public function store(Request $request, int $keypad){
        if ($request->user()->meeting->keypads()->get()->where('id', $keypad)->first()->votes()->get()->where('participant_id', $request->user()->id)->count() > 0) {
            return [
                'data' => null,
                'status' => false,
                'errors' => ["Zaten oy kullandınız!"]
            ];
        }
        if ($request->user()->meeting->keypads()->get()->where('id', $keypad)->first()->on_vote == 0) {
            return [
                'data' => null,
                'status' => false,
                'errors' => ["Bu keypad oylaması sona erdi!"]
            ];
        }
            $vote = new Vote();
            $vote->option_id = $request->input('option');
            $vote->participant_id = $request->user()->id;
            $vote->keypad_id = $keypad;
            try{
                $vote->save();
                $this->logParticipantAction($request->user(), "send-keypad-vote", $request->user()->meeting->keypads()->get()->where('id', $keypad)->first()->title);
                return [
                    'data' => null,
                    'status' => true,
                    'errors' => null
                ];
            } catch (\Throwable $e){
                return [
                    'data' => null,
                    'status' => false,
                    'errors' => ['error']
                ];
            }
        }
}

