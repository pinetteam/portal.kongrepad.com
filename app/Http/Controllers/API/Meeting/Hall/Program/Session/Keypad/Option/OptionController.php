<?php

namespace App\Http\Controllers\API\Meeting\Hall\Program\Session\Keypad\Option;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    public function index(Request $request, string $keypad_id)
    {
        return $request->user()->meeting->keypads()->findOrFail($keypad_id)->options()->get();
    }
}
