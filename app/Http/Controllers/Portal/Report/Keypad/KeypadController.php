<?php

namespace App\Http\Controllers\Portal\Report\Keypad;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class KeypadController extends Controller
{
    public function index()
    {
        $keypads = Auth::user()->customer->keypads()->paginate(20);
        $on_vote = [
            'passive' => ['value' => 0, 'title' => __('common.passive'), 'color' => 'danger'],
            'active' => ['value' => 1, 'title' => __('common.active'), 'color' => 'success'],
        ];
        return view('portal.report.keypad-report.index', compact(['keypads', 'on_vote']));
    }
    public function showParticipants(string $keypad)
    {
        $question = Auth::user()->customer->keypads()->findOrFail($keypad);
        $votes = Auth::user()->customer->keypadVotes()->where('keypad_id', $keypad)->paginate(20);
        return view('portal.report.keypad-report.participant.index', compact(['question', 'votes']));
    }
    public function showReport(string $keypad)
    {
        $keypad = Auth::user()->customer->keypads()->findOrFail($keypad);
        return view('portal.report.keypad-report.show-report', compact(['keypad']));
    }
}
