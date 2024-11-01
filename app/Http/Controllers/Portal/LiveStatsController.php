<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\System\PersonalAccessTokens;
use Illuminate\Support\Facades\Auth;

class LiveStatsController extends Controller
{
    public function index()
    {
        $meetings = Auth::user()->customer->meetings()->where('status', '1')->get();
        $personal_access_tokens = PersonalAccessTokens::groupBy('tokenable_id')->orderBy('last_used_at', 'DESC')->get();
        return view('portal.live-stats.index', compact(['meetings', 'personal_access_tokens']));
    }
}
