<?php

namespace App\Http\Controllers\Service\Screen;

use App\Events\Service\Screen\QuestionsEvent;
use App\Http\Controllers\Controller;
use App\Models\Meeting\Hall\Screen\Screen;
use Illuminate\Http\Request;

class QuestionsController extends Controller
{
    public function index($meeting_hall_screen_code)
    {
        $meeting_hall_screen = Screen::where('code', $meeting_hall_screen_code)->first();
        try {
            $session = $meeting_hall_screen->hall->programSessions()->where('on_air', true)->first();
            if($session->questions) {
                $questions = $session->questions()->where('selected_for_show', true)->with('questioner')->get();
            }
        } catch (\Exception $e) {
            $questions = null;
        }
        return view('service.screen.questions.index', compact(['meeting_hall_screen', 'questions']));
    }
    public function start($meeting_hall_screen_code)
    {
        $meeting_hall_screen = Screen::where('code', $meeting_hall_screen_code)->first();
        event(new QuestionsEvent($meeting_hall_screen));
        return back();
    }

}
