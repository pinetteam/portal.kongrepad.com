<?php

namespace App\Http\Controllers\API\Meeting\Hall\Program\Debate\Vote;

use App\Http\Controllers\Controller;

use App\Models\Meeting\Hall\Program\Debate\Vote\Vote;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    public function store(Request $request, int $debate){

            $vote = new Vote();
            $vote->team_id = $request->input('team');
            $vote->participant_id = $request->user()->id;
            $vote->debate_id = $debate;
            try{
                $vote->save();
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

