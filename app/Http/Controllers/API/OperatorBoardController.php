<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OperatorBoardController extends Controller
{
    public function index(string $meeting_hall_id, string $program_order)
    {
        $meeting_hall = Auth::user()->customer->meetingHalls()->findOrFail($meeting_hall_id);
        $programs = $meeting_hall->programs;
        foreach($programs as $program){
            $program->on_air = 0;
            $program->save();
        }
        $programs = $programs->values();
        if($program_order == -1)
            return back()->with('error', __('common.there-is-not-any-program-before'));
        elseif ($program_order == count($programs))
            return back()->with('error', __('common.this-is-the-last-program'));
        else {
            $program = $programs->get($program_order);
            $program->on_air = 1;
            $program->save();
        }
        if($program->type == 'session'){
            $chairs = Auth::user()->customer->participants()->whereNotIn('meeting_participants.id', $program->programChairs()->pluck('meeting_hall_program_chairs.chair_id'))->whereNot('meeting_participants.type', 'team')->get();
            $program_chairs = $program->programChairs()->get();
            $sessions = $program->programSessions()->get();;
            return view('portal.operator-board.index',compact(['meeting_hall', 'program', 'program_chairs', 'chairs', 'sessions']));
        } elseif($program->type == 'debate'){
            $chairs = Auth::user()->customer->participants()->whereNotIn('meeting_participants.id', $program->programChairs()->pluck('meeting_hall_program_chairs.chair_id'))->whereNot('meeting_participants.type', 'team')->get();
            $program_chairs = $program->programChairs()->get();
            $debates = $program->debates()->get();
            return view('portal.operator-board.index',compact(['meeting_hall', 'program', 'program_chairs', 'chairs', 'debates']));
        } else {
            return view('portal.operator-board.index',compact(['meeting_hall', 'program']));
        }
    }
}
