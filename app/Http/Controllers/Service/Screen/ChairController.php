<?php

namespace App\Http\Controllers\Service\Screen;

use App\Events\Service\Screen\SpeakerEvent;
use App\Http\Controllers\Controller;
use App\Models\Meeting\Hall\Screen\Screen;

class ChairController extends Controller
{
    public function index($meeting_hall_screen_code)
    {
        $meeting_hall_screen = Screen::where('code', $meeting_hall_screen_code)->first();
        try {
            $program = $meeting_hall_screen->hall->programs()->where('is_started', true)->first();
            $chair = $program->programChairs()->get()[$meeting_hall_screen->id%3]->chair;
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
