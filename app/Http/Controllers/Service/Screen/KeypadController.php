<?php

namespace App\Http\Controllers\Service\Screen;

use App\Http\Controllers\Controller;
use App\Models\Meeting\Hall\Screen\Screen;
use Illuminate\Support\Facades\Auth;

class KeypadController extends Controller
{
    public function index(string $meeting_hall_screen_code)
    {
        $meeting_hall_screen = Screen::where('code', $meeting_hall_screen_code)->first();
        try {
            $keypad = Auth::user()->customer->keypads()->where('on_air', 1)->first();
        } catch (\Exception $e) {
            $keypad = null;
        }
        return view('service.screen.keypad.index', compact(['meeting_hall_screen', 'keypad']));
    }
}
