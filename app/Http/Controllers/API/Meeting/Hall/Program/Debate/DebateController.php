<?php

namespace App\Http\Controllers\API\Meeting\Hall\Program\Debate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DebateController extends Controller
{

    public function index(Request $request, $program_id){
        return $request->user()->meeting->programs()->where('meeting_hall_programs.id', $program_id)->first()->debates()->get();
    }
    public function show(Request $request, string $program_id, string $id)
    {
        return $request->user()->customer->debates()->where('meeting_hall_program_debates.id', $id)->first();
    }
}
