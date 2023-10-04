<?php

namespace App\Http\Controllers\Service;

use App\Events\Service\Screen\ChairEvent;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OperatorBoardController extends Controller
{
    public function index(string $code, int $program_order)
    {
        $meeting_hall = Auth::user()->customer->halls()->where('meeting_halls.code', $code)->first();
        $programs = $meeting_hall->programs;
        foreach($programs as $program){
            $program->is_started = 0;
            $program->save();
        }
        $programs = $programs->values();
        if($program_order == -1)
            return back()->with('error', __('common.there-is-not-any-program-before'));
        elseif ($program_order == count($programs))
            return back()->with('error', __('common.this-is-the-last-program'));
        else {
            $program = $programs->get($program_order);
            $program->is_started = 1;
            $program->save();
        }
        $meeting_hall_screens = $meeting_hall->screens()->where('type', 'chair')->get();
        foreach ($meeting_hall_screens as $screen){
            event(new ChairEvent($screen));
        }
        if($program->type == 'session'){
            $chairs = Auth::user()->customer->participants()->whereNotIn('meeting_participants.id', $program->programChairs()->pluck('meeting_hall_program_chairs.chair_id'))->whereNot('meeting_participants.type', 'team')->get();
            $program_chairs = $program->programChairs()->get();
            $sessions = $program->sessions()->get();
            return view('service.operator-board.index', compact(['meeting_hall', 'program', 'program_chairs', 'chairs', 'sessions']));
        } elseif($program->type == 'debate'){
            $chairs = Auth::user()->customer->participants()->whereNotIn('meeting_participants.id', $program->programChairs()->pluck('meeting_hall_program_chairs.chair_id'))->whereNot('meeting_participants.type', 'team')->get();
            $program_chairs = $program->programChairs()->get();
            $debates = $program->debates()->get();
            return view('service.operator-board.index',compact(['meeting_hall', 'program', 'program_chairs', 'chairs', 'debates']));
        } else {
            return view('service.operator-board.index',compact(['meeting_hall', 'program']));
        }
    }
}
