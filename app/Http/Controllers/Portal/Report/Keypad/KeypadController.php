<?php

namespace App\Http\Controllers\Portal\Report\Keypad;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class KeypadController extends Controller
{
    public function index(string $meeting)
    {
        $meeting = Auth::user()->customer->meetings()->findOrFail($meeting);
        $keypads = $meeting->keypads()->paginate(20);
        $on_vote = [
            'passive' => ['value' => 0, 'title' => __('common.passive'), 'color' => 'danger'],
            'active' => ['value' => 1, 'title' => __('common.active'), 'color' => 'success'],
        ];
        return view('portal.meeting.report.keypad.index', compact(['meeting', 'keypads', 'on_vote']));
    }
    public function showParticipants(string $meeting, string $keypad)
    {
        $meeting = Auth::user()->customer->meetings()->findOrFail($meeting);
        $question = $meeting->keypads()->findOrFail($keypad);
        $votes = Auth::user()->customer->keypadVotes()->where('keypad_id', $keypad)->paginate(20);
        return view('portal.meeting.report.keypad.participant.index', compact(['question', 'votes']));
    }
    public function showReport(string $meeting, string $keypad)
    {
        $meeting = Auth::user()->customer->meetings()->findOrFail($meeting);
        $keypad = $meeting->keypads()->findOrFail($keypad);
        return view('portal.meeting.report.keypad.report', compact(['keypad']));
    }
}
