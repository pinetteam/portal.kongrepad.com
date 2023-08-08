<?php

namespace App\Http\Controllers\Service\Screen;

use App\Events\StartScreen;
use App\Http\Controllers\Controller;
use App\Models\Meeting\Participant\Participant;

class TestController extends Controller
{
    public function index()
    {
        return view('service.screen.index');
    }
    public function start()
    {
        $participant = Participant::findOrFail(1);
        event(new StartScreen($participant));
        return 'We just sent!';
    }
}
