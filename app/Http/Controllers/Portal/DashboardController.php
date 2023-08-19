<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $meetings = Auth::user()->customer->meetings()->where('status','1')->paginate(20);
        return view('portal.dashboard.index', compact(['meetings']));
    }
    public function programIndex(int $meeting)
    {
        $meeting = Auth::user()->customer->meetings()->findOrFail($meeting);
        $programs = $meeting->programs()->get();
        return view('portal.dashboard.show-program', compact(['meeting', 'programs']));
    }
}
