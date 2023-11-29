<?php

namespace App\Http\Controllers\Service\Screen;

use App\Http\Controllers\Controller;
use App\Models\Meeting\Hall\Program\Debate\Debate;
use App\Models\Meeting\Hall\Program\Debate\Team\Team;
use App\Models\Meeting\Hall\Screen\Screen;
use Illuminate\Support\Facades\Auth;

class DebateController extends Controller
{
    public function index(string $meeting_hall_screen_code)
    {
        $meeting_hall_screen = Screen::where('code', $meeting_hall_screen_code)->first();
        try {
            if($meeting_hall_screen->current_object_id){
                $debate = Debate::withCount('votes')->findOrFail($meeting_hall_screen->current_object_id);
                $teams = Team::where('debate_id', $debate->id)->withCount('votes')->get();
            } else {
                $debate = null;
                $teams = null;
            }
        } catch (\Exception $e) {
            $debate = null;
            $teams = null;
        }
        return view('service.screen.debate.index', compact(['meeting_hall_screen', 'debate', 'teams']));
    }
}
