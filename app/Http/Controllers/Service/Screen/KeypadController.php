<?php

namespace App\Http\Controllers\Service\Screen;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class KeypadController extends Controller
{
    public function index(string $keypad_id)
    {
        $keypad = Auth::user()->customer->keypads()->findOrFail($keypad_id);
        return view('service.screen.keypad.index', compact(['keypad']));
    }
}
