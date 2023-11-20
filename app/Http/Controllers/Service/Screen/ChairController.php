<?php

namespace App\Http\Controllers\Service\Screen;

use App\Events\Service\Screen\SpeakerEvent;
use App\Http\Controllers\Controller;
use App\Models\Meeting\Hall\Screen\Screen;
use App\Models\Meeting\Participant\Participant;

class ChairController extends Controller
{
    public function index($meeting_hall_screen_code)
    {
        $meeting_hall_screen = Screen::where('code', $meeting_hall_screen_code)->first();
        try {
            if($meeting_hall_screen->current_object_id){
                $chair = Participant::findOrFail($meeting_hall_screen->current_object_id);
            } else {
                $chair = null;
            }
        } catch (\Exception $e) {
            $chair = null;
        }
        return view('service.screen.chair.index', compact(['meeting_hall_screen', 'chair']));
    }
    public function start($meeting_hall_screen_code)
    {
        $meeting_hall_screen = Screen::where('code', $meeting_hall_screen_code)->first();
        //event(new SpeakerEvent($meeting_hall_screen));
        return back();
    }
}
