<?php

namespace App\Http\Controllers\Service\Screen;

use App\Http\Controllers\Controller;
use App\Models\Meeting\Hall\Program\Session\Keypad\Keypad;
use App\Models\Meeting\Hall\Program\Session\Keypad\Option\Option;
use App\Models\Meeting\Hall\Screen\Screen;
use Illuminate\Support\Facades\Auth;

class KeypadController extends Controller
{
    public function index(string $meeting_hall_screen_code)
    {
        $meeting_hall_screen = Screen::where('code', $meeting_hall_screen_code)->first();
        try {
            if($meeting_hall_screen->current_object_id){
                $keypad = Keypad::withCount('votes')->findOrFail($meeting_hall_screen->current_object_id);
                $options = Option::where('keypad_id', $keypad->id)->withCount('votes')->get();
            } else {
                $keypad = null;
                $options = null;
            }
        } catch (\Exception $e) {
            $keypad = null;
            $options = null;
        }
        return view('service.screen.keypad.index', compact(['meeting_hall_screen', 'keypad', 'options']));
    }
}
