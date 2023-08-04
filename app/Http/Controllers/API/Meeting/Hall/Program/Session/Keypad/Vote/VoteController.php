<?php

namespace App\Http\Controllers\API\Meeting\Hall\Program\Session\Keypad\Vote;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\Meeting\Hall\Program\Session\Keypad\Vote\VoteRequest;
use App\Http\Resources\Portal\Meeting\Hall\Program\Session\Keypad\Vote\VoteResource;
use App\Models\Meeting\Hall\Program\Session\Keypad\Vote\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    public function store(Request $request, string $keypad_id)
    {
        $keypad = $request->user()->meeting->keypads()->where('meeting_hall_program_session_keypads.id', $keypad_id)->first();
        if($keypad->votes()->where('meeting_hall_program_session_keypad_votes.participant_id', $request->user()->id)->count() > 0)
            return json_encode(array("error"=> "you can vote once"));
        $vote = new Vote();
        $vote->option_id = $request->option_id;
        $vote->participant_id = $request->user()->id;
        if ($vote->save()) {
            $vote->created_by = $request->user()->id;
            $vote->save();
            return json_encode(array("success"=> "success"));
        } else {
            return json_encode(array("error"=> "error"));
        }

    }

}
