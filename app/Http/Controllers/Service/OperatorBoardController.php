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
        $programs = $meeting_hall->programs()->orderBy('sort_order', 'ASC')->orderBy('start_at', 'ASC')->get();
        foreach($programs as $program){
            $program->is_started = 0;
            $program->save();
        }
        $programs = $programs->values();

        $timer_screen = $meeting_hall->screens()->where('type', 'timer')->first();
        if($program_order == -1)
            return back()->with('error', __('common.there-is-not-any-program-before'));
        elseif ($program_order == count($programs))
            return back()->with('error', __('common.this-is-the-last-program'));
        else {
            $program = $programs->get($program_order);
            foreach($programs as $temp_program){
                if ($temp_program->debates->count() > 0 && $temp_program->id != $program->id) {
                    foreach($temp_program->debates as $debate){
                        $debate->on_vote = 0;
                        $debate->save();
                    }
                }
                if ($temp_program->sessions->count() > 0 && $temp_program->id != $program->id) {
                    foreach($temp_program->sessions as $session){
                        if ($session->keypads->count() > 0) {
                            foreach($session->keypads as $keypad){
                                $keypad->on_vote = 0;
                                $keypad->save();
                            }
                        }
                        $session->on_air = 0;
                        $session->save();
                    }
                }
            }
            $program->is_started = 1;
            $program->save();
        }
        $meeting_hall_screens = $meeting_hall->screens()->where('type', 'chair')->get();
        foreach ($meeting_hall_screens as $screen){
            //event(new ChairEvent($screen));
        }
        if($program->type == 'session'){
            $chairs = Auth::user()->customer->participants()->whereNotIn('meeting_participants.id', $program->programChairs()->pluck('meeting_hall_program_chairs.chair_id'))->whereNot('meeting_participants.type', 'team')->get();
            $program_chairs = $program->programChairs()->get();
            $sessions = $program->sessions()->get();
            $chair_types = [
                'chair' => ['value' => 'chair', 'title' => __('common.chair')],
                'moderator' => ['value' => 'moderator', 'title' => __('common.moderator')],
            ];
            return view('service.operator-board.index', compact(['meeting_hall', 'program', 'program_chairs', 'chairs', 'chair_types', 'sessions', 'timer_screen']));
        } elseif($program->type == 'debate'){
            $chairs = Auth::user()->customer->participants()->whereNotIn('meeting_participants.id', $program->programChairs()->pluck('meeting_hall_program_chairs.chair_id'))->whereNot('meeting_participants.type', 'team')->get();
            $program_chairs = $program->programChairs()->get();
            $debates = $program->debates()->get();
            $chair_types = [
                'chair' => ['value' => 'chair', 'title' => __('common.chair')],
                'moderator' => ['value' => 'moderator', 'title' => __('common.moderator')],
            ];
            return view('service.operator-board.index', compact(['meeting_hall', 'program', 'program_chairs', 'chairs', 'chair_types', 'debates', 'timer_screen']));
        } else {
            return view('service.operator-board.index', compact(['meeting_hall', 'program', 'timer_screen']));
        }
    }
}
