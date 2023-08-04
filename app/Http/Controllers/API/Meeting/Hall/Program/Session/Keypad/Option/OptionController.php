<?php

namespace App\Http\Controllers\API\Meeting\Hall\Program\Session\Keypad\Option;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\Meeting\Hall\Program\Session\Keypad\Option\OptionRequest;
use App\Http\Resources\Portal\Meeting\Hall\Program\Session\Keypad\Option\OptionResource;
use App\Models\Meeting\Hall\Program\Session\Keypad\Option\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OptionController extends Controller
{
    public function index(Request $request, string $keypad_id)
    {
        return $request->user()->meeting->keypads()->findOrFail($keypad_id)->options()->get();
    }
}
