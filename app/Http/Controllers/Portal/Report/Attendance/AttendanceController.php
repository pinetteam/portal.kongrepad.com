<?php

namespace App\Http\Controllers\Portal\Report\Attendance;

use App\Http\Controllers\Controller;
use App\Models\Log\Meeting\Participant\Participant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    public function index(int $meeting)
    {
        $meeting = Auth::user()->customer->meetings()->findOrFail($meeting);
        $participant_logs = Participant::select('participant_id', DB::raw('count(*) as total_actions'))->groupBy('participant_id')->orderBy('total_actions', 'DESC')->paginate(25);
        return view('portal.meeting.report.attendance.index', compact(['meeting', 'participant_logs']));
    }

}
