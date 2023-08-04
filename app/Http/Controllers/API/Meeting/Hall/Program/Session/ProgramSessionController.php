<?php

namespace App\Http\Controllers\API\Meeting\Hall\Program\Session;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProgramSessionController extends Controller
{
    public function index(Request $request, $program_id){
        return $request->user()->meeting->programs()->where('meeting_hall_programs.id', $program_id)->first()->programSessions()->get();
    }
    public function show(Request $request, string $program_id, string $id)
    {
        $request->user()->customer->programSessions()->where('meeting_hall_program_sessions.id', $id)->first();

    }
}
