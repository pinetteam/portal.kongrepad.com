<?php

namespace App\Http\Controllers\API\Meeting\Hall\Program\Session\Keypad;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\Meeting\Hall\Program\Session\Keypad\KeypadRequest;
use App\Http\Resources\Portal\Meeting\Hall\Program\Session\Keypad\KeypadResource;
use App\Models\Meeting\Hall\Program\Session\Keypad\Keypad;
use Illuminate\Support\Facades\Auth;

class KeypadController extends Controller
{
    public function show(string $program_id, string $session_id, string $id)
    {
    }
}
