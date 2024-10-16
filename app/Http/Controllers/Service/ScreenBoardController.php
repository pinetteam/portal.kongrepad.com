<?php

namespace App\Http\Controllers\Service;

use App\Events\Service\Screen\ChairEvent;
use App\Events\Service\Screen\DebateEvent;
use App\Events\Service\Screen\DocumentEvent;
use App\Events\Service\Screen\KeypadEvent;
use App\Events\Service\Screen\SpeakerEvent;
use App\Events\Service\Screen\TimerEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Service\ScreenBoard\ChairScreenRequest;
use App\Http\Requests\Service\ScreenBoard\DebateScreenRequest;
use App\Http\Requests\Service\ScreenBoard\DocumentScreenRequest;
use App\Http\Requests\Service\ScreenBoard\KeypadScreenRequest;
use App\Http\Requests\Service\ScreenBoard\SpeakerScreenRequest;
use App\Http\Requests\Service\ScreenBoard\TimerScreenRequest;
use App\Http\Resources\Pusher\Meeting\Hall\Program\Debate\DebateResource;
use App\Http\Resources\Pusher\Meeting\Hall\Program\Session\Keypad\KeypadResource;
use App\Models\Meeting\Hall\Hall;
use App\Models\Meeting\Hall\Screen\Screen;
use Carbon\Carbon;

class ScreenBoardController extends Controller
{
    public function index(string $code)
    {
        $hall = Hall::where('code', $code)->first();
        $meeting = $hall->meeting;
        $participants = $meeting->participants()->get()->sortBy('first_name');
        $screens = $hall->screens()->get()->sortBy('title');
        $keypads = $meeting->keypads()->get();
        $documents = $meeting->documents()->get();
        $debates = $meeting->debates()->get();
        return view('service.screen-board.index', compact(['hall', 'debates', 'documents', 'participants', 'screens', 'keypads']));
    }
    public function speaker_screen(SpeakerScreenRequest $request, string $code)
    {
        if ($request->validated()) {
            $screen = Screen::where('code', $code)->first();
            $hall = $screen->hall;
            $meeting = $hall->meeting;
            $participant = null;
            if ($request->input('speaker_id') != null) {
                $participant = $meeting->participants()->findOrFail($request->input('speaker_id'));
            }
            $screen->current_object_id = $participant ? $participant->id : null;
            $screen->save();
            event(new SpeakerEvent($screen, $participant));
            return back()->with('success', __('common.edited-successfully'));
        } else {
            return back()->with('error', __('common.a-system-error-has-occurred'));
        }
    }
    public function chair_screen(ChairScreenRequest $request, string $code)
    {
        if ($request->validated()) {
            $screen = Screen::where('code', $code)->first();
            $hall = $screen->hall;
            $meeting = $hall->meeting;
            $participant = null;
            if ($request->input('chair_id') != null) {
                $participant = $meeting->participants()->findOrFail($request->input('chair_id'));
            }
            $screen->current_object_id = $participant ? $participant->id : null;
            $screen->save();
            event(new ChairEvent($screen, $participant));
            return back()->with('success', __('common.edited-successfully'));
        } else {
            return back()->with('error', __('common.a-system-error-has-occurred'));
        }
    }
    public function keypad_screen(KeypadScreenRequest $request, string $code)
    {
        if ($request->validated()) {
            $screen = Screen::where('code', $code)->first();
            $hall = $screen->hall;
            $meeting = $hall->meeting;
            $keypad = null;
            if ($request->input('keypad_id') != null) {
                $keypad = $meeting->keypads()
                    ->withCount('votes')
                    ->with(['options' => function($query) {
                        $query->withCount('votes');
                    }])
                    ->findOrFail($request->input('keypad_id'));
            }
            $screen->current_object_id = $keypad ? $keypad->id : null;
            $screen->save();
            $keypadResource = new KeypadResource($keypad);
            event(new KeypadEvent($screen, $keypadResource));
            return back()->with('success', __('common.edited-successfully'));
        } else {
            return back()->with('error', __('common.a-system-error-has-occurred'));
        }
    }

    public function debate_screen(DebateScreenRequest $request, string $code)
    {
        if ($request->validated()) {
            $screen = Screen::where('code', $code)->first();
            $hall = $screen->hall;
            $meeting = $hall->meeting;
            $debate = null;
            if ($request->input('debate_id') != null) {
                $debate = $meeting->debates()
                    ->withCount('votes')
                    ->with(['teams' => function($query) {
                        $query->withCount('votes');
                    }])
                    ->findOrFail($request->input('debate_id'));
            }
            $screen->current_object_id = $debate ? $debate->id : null;
            $screen->save();
            $debateResource = new DebateResource($debate);
            event(new DebateEvent($screen, $debateResource));
            return back()->with('success', __('common.edited-successfully'));
        } else {
            return back()->with('error', __('common.a-system-error-has-occurred'));
        }
    }

    public function document_screen(DocumentScreenRequest $request, string $code)
    {
        if ($request->validated()) {
            $screen = Screen::where('code', $code)->first();
            $hall = $screen->hall;
            $meeting = $hall->meeting;
            $document = null;
            if ($request->input('document_id') != null) {
                $document = $meeting->documents()->findOrFail($request->input('document_id'));
            }
            $screen->current_object_id = $document ? $document->id : null;
            $screen->save();
            event(new DocumentEvent($screen, $document));
            return back()->with('success', __('common.edited-successfully'));
        } else {
            return back()->with('error', __('common.a-system-error-has-occurred'));
        }
    }
    public function timer_screen(TimerScreenRequest $request, string $code, string $action)
    {
        if ($request->validated()) {
            $screen = Screen::where('code', $code)->first();
            $timer = $screen->timer;
            if ($action == 'reset') {
                $timer->time_left = $timer->time;
                $timer->status = 0;
                $timer->save();
                event(new TimerEvent($screen, $timer->time_left, 'reset'));
            } else  if ($action == 'start') {
                $timer->started_at = Carbon::now()->timestamp;
                $timer->status = 1;
                $timer->save();
                event(new TimerEvent($screen, $timer->time_left, $action));
            } else  if ($action == 'stop') {
                $now = Carbon::now()->timestamp;
                $timer->time_left = $timer->time_left - $now + $timer->started_at;
                $timer->status = 0;
                $timer->save();
                event(new TimerEvent($screen, $timer->time_left, 'stop'));
            } else  if ($action == 'edit') {
                $timer->time = $request->input('time')*60;
                $timer->time_left = $timer->time;
                $timer->status = 0;
                $timer->save();
                event(new TimerEvent($screen, $timer->time_left, 'reset'));
            }
            return back()->with('success', __('common.edited-successfully'));
        } else {
            return back()->with('error', __('common.a-system-error-has-occurred'));
        }
    }
}
