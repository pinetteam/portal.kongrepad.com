<?php

namespace App\Http\Controllers\Service\Screen;

use App\Http\Controllers\Controller;
use App\Models\Meeting\Hall\Screen\Screen;

class TimerController extends Controller
{
    public function index($meeting_hall_screen_code)
    {
        $meeting_hall_screen = Screen::where('code', $meeting_hall_screen_code)->first();
        return view('service.screen.timer.index', compact(['meeting_hall_screen']));
    }
}
