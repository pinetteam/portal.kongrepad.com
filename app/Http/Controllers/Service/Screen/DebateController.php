<?php

namespace App\Http\Controllers\Service\Screen;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DebateController extends Controller
{
    public function index(string $debate_id)
    {
        $debate = Auth::user()->customer->debates()->findOrFail($debate_id);
        $teams = Auth::user()->customer->teams()->where('debate_id', $debate_id)->paginate(20);
        return view('service.screen.debate.index', compact(['debate', 'teams']));
    }
}
