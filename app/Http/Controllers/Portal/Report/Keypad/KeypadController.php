<?php

namespace App\Http\Controllers\Portal\Report\Keypad;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class KeypadController extends Controller
{
    public function index(int $meeting)
    {
        $meeting = Auth::user()->customer->meetings()->findOrFail($meeting);
        $keypads = $meeting->keypads()->paginate(20);
        $on_vote = [
            'passive' => ['value' => 0, 'title' => __('common.passive'), 'color' => 'danger'],
            'active' => ['value' => 1, 'title' => __('common.active'), 'color' => 'success'],
        ];
        return view('portal.meeting.report.keypad.index', compact(['meeting', 'keypads', 'on_vote']));
    }
    public function showParticipants(int $meeting, int $id)
    {
        $meeting = Auth::user()->customer->meetings()->findOrFail($meeting);
        $question = $meeting->keypads()->findOrFail($id);
        $votes = Auth::user()->customer->keypadVotes()->where('keypad_id', $id)->paginate(20);
        return view('portal.meeting.report.keypad.participant.index', compact(['question', 'votes']));
    }
    public function showReport(int $meeting, int $id)
    {
        $meeting = Auth::user()->customer->meetings()->findOrFail($meeting);
        $question = $meeting->keypads()->findOrFail($id);
        $options = $question->options;
        return view('portal.meeting.report.keypad.report', compact(['question', 'options']));
    }
}
