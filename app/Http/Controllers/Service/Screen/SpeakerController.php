<?php

namespace App\Http\Controllers\Service\Screen;

use App\Events\Service\Screen\SpeakerEvent;
use App\Http\Controllers\Controller;
use App\Models\Meeting\Hall\Screen\Screen;

class SpeakerController extends Controller
{
    public function index($meeting_hall_screen_code)
    {
        $meeting_hall_screen = Screen::where('code', $meeting_hall_screen_code)->first();
        try {
            $session = $meeting_hall_screen->hall->programs()->where('is_started', true)->first()->sessions->where('on_air', true)->first();
            $speaker = $session->speaker;
        } catch (\Exception $e) {
            $speaker = null;
        }
        return view('service.screen.speaker.index', compact(['meeting_hall_screen', 'speaker']));
    }
    public function start($meeting_hall_screen_code)
    {
        $meeting_hall_screen = Screen::where('code', $meeting_hall_screen_code)->first();
        event(new SpeakerEvent($meeting_hall_screen));
        return back();
    }
}
