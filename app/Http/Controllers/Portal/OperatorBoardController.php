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
        $programs = $programs->values();
        if($program_order == -1)
            return back()->with('error', __('common.there-is-not-any-program-before'));
        elseif ($program_order == count($programs))
            return back()->with('error', __('common.this-is-the-last-program'));
        else
            $program = $programs->get($program_order);
        if($program->type == 'session'){
            $sessions = $program->programSessions()->get();;
            return view('portal.operator-board.index',compact(['meeting_hall','program','sessions']));
        } elseif($program->type == 'debate'){
            $debates = $program->debates()->get();
            return view('portal.operator-board.index',compact(['meeting_hall','program','debates']));
        } else {
            return view('portal.operator-board.index',compact(['meeting_hall','program']));
        }
    }
}
