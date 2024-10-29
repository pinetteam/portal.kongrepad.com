<?php

namespace App\Http\Controllers\API\Meeting\Hall\Program\Debate\Vote;

use App\Http\Controllers\Controller;
use App\Http\Traits\ParticipantLog;
use App\Models\Meeting\Hall\Program\Debate\Vote\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VoteController extends Controller
{
    use ParticipantLog;
    public function store(Request $request, int $debate){
        if ($request->user()->meeting->debates()->get()->where('id', $debate)->first()->votes()->get()->where('participant_id', $request->user()->id)->count() > 0) {
            return [
                'data' => null,
                'status' => false,
                'errors' => ["Zaten oy kullandınız!"]
            ];
        }
        $vote = new Vote();
        $vote->team_id = $request->input('team');
        $vote->participant_id = $request->user()->id;
        $vote->debate_id = $debate;
        Log::info('Debate vote has been requested! vote_id="'.$request->input('team').'"+participant_id="'.$request->user()->id.'"+debate_id="'.$debate.'"');
        try{
            $vote->save();
            $this->logParticipantAction($request->user(), "send-debate-vote", $request->user()->meeting->debates()->get()->where('id', $debate)->first()->title);
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

