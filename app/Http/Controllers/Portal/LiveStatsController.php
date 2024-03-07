<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LiveStatsController extends Controller
{
    public function index()
    {
        $meetings = Auth::user()->customer->meetings()->where('status', '1')->paginate(20);
        return view('portal.live-stats.index', compact(['meetings']));
    }
}
