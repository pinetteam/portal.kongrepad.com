<?php

namespace App\Http\Controllers\Portal\Report\Session;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    public function index(int $meeting, int $hall)
    {
        $hall = Auth::user()->customer->halls()->findOrFail($hall);
        $meeting = Auth::user()->customer->meetings()->findOrFail($meeting);
        $programs = $hall->programs()->orderBy('sort_order', 'ASC')->orderBy('start_at', 'ASC')->get();
        return view('portal.meeting.hall.report.session.index', compact(['programs', 'hall', 'meeting']));
    }


    public function show(int $meeting, int $hall, int $id)
    {
        $session = Auth::user()->customer->programSessions()->findOrFail($id);
        $meeting = Auth::user()->customer->meetings()->findOrFail($meeting);
        return view('portal.meeting.hall.report.session.show', compact(['meeting', 'session']));
    }
}
