<?php

namespace App\Http\Controllers\Portal\Report\Registration;

use App\Http\Controllers\Controller;
use App\Models\System\Country\Country;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
class RegistrationController extends Controller
{
    public function index(int $meeting)
    {
        $meeting = Auth::user()->customer->meetings()->findOrFail($meeting);
        $participants = $meeting->participants()->orderBy('last_name')->paginate();
        $phone_countries = Country::get();
        $types = [
            'agent' => ['value' => 'agent', 'title' => __('common.agent')],
            'attendee' => ['value' => 'attendee', 'title' => __('common.attendee')],
            'team' => ['value' => 'team', 'title' => __('common.team')],
        ];
        $statuses = [
            'passive' => ['value' => 0, 'title' => __('common.passive'), 'color' => 'danger'],
            'active' => ['value' => 1, 'title' => __('common.active'), 'color' => 'success'],
        ];
        return view('portal.meeting.report.registration.index', compact(['meeting', 'participants', 'phone_countries', 'types', 'statuses']));
    }
}
