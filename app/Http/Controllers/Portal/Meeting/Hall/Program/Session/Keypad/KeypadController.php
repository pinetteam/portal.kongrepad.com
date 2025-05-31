<?php

namespace App\Http\Controllers\Portal\Meeting\Hall\Program\Session\Keypad;

use App\Events\Service\Keypad\KeypadEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\Meeting\Hall\Program\Session\Keypad\KeypadRequest;
use App\Http\Resources\Portal\Meeting\Hall\Program\Session\Keypad\KeypadResource;
use App\Models\Log\Meeting\Hall\Program\Session\Keypad\Keypad as KeypadLog;
use App\Models\Meeting\Hall\Program\Session\Keypad\Keypad;
use App\Notifications\KeypadNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log as SystemLog;

class KeypadController extends Controller
{
    public function store(KeypadRequest $request, int $meeting, int $hall, int $program, int $session)
    {
        if ($request->validated()) {
            $keypad = new Keypad();
            $keypad->sort_order = $request->input('sort_order');
            $keypad->session_id = $request->input('session_id');
            $keypad->title = $request->input('title');
            $keypad->keypad = $request->input('keypad');
            if ($keypad->save()) {
                $keypad->created_by = Auth::user()->id;
                $keypad->save();
                return back()->with('success', __('common.created-successfully'));
            } else {
                return back()->with('create_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function show(int $meeting, int $hall, int $program, int $session, int $id)
    {
        $keypad = Auth::user()->customer->keypads()->findOrFail($id);
        $meeting = Auth::user()->customer->meetings()->findOrFail($meeting);
        return view('portal.meeting.hall.program.session.keypad.show', compact(['keypad', 'meeting']));
    }
    public function edit(int $meeting, int $hall, int $program, int $session, int $id)
    {
        $keypad = Auth::user()->customer->keypads()->findOrFail($id);
        return new KeypadResource($keypad);
    }
    public function update(KeypadRequest $request, int $meeting, int $hall, int $program, int $session, int $id)
    {
        if ($request->validated()) {
            $keypad = Auth::user()->customer->keypads()->findOrFail($id);
            $keypad->session_id = $request->input('session_id');
            $keypad->sort_order = $request->input('sort_order');
            $keypad->title = $request->input('title');
            $keypad->keypad = $request->input('keypad');
            if ($keypad->save()) {
                $keypad->updated_by = Auth::user()->id;
                $keypad->save();
                return back()->with('success', __('common.edited-successfully'));
            } else {
                return back()->with('edit_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        }
    }
    public function destroy(int $meeting, int $hall, int $program, int $session, int $id)
    {
        $keypad = Auth::user()->customer->keypads()->findOrFail($id);
        if ($keypad->delete()) {
            $keypad->deleted_by = Auth::user()->id;
            $keypad->save();
            return back()->with('success', __('common.deleted-successfully'));
        } else {
            return back()->with('error', __('common.a-system-error-has-occurred'))->withInput();
        }
    }
    public function start_stop_voting(int $meeting, int $hall, int $program, int $session, int $id)
    {
        try {
            $session = Auth::user()->customer->programSessions()->findOrFail($session);
            $hall = Auth::user()->customer->halls()->findOrFail($hall);
            $meeting = Auth::user()->customer->meetings()->findOrFail($meeting);
            event(new KeypadEvent(hall: $hall, on_vote: false));
            
            // Diğer keypadlerin oylama durumunu kapat
            foreach($session->keypads as $keypad){
                if($keypad->id == $id)
                    continue;
                    
                $keypad = Auth::user()->customer->keypads()->findOrFail($keypad->id);
                if ($keypad->on_vote) {
                    // Eğer oylamadaysa, log kaydı oluştur
                    $keypadLog = new KeypadLog();
                    $keypadLog->keypad_id = $keypad->id;
                    $keypadLog->action = 'stop';
                    $keypadLog->started_at = $keypad->voting_started_at;
                    $keypadLog->finished_at = now();
                    $keypadLog->created_by = Auth::user()->id;
                    $keypadLog->save();
                    
                    SystemLog::info('Keypad voting stopped', [
                        'keypad_id' => $keypad->id,
                        'user_id' => Auth::user()->id,
                        'session_id' => $session->id
                    ]);
                }
                
                $keypad->on_vote = 0;
                $keypad->voting_finished_at = now()->format('Y-m-d H:i');
                $keypad->save();
            }
            
            // İlgili keypad'i güncelle
            $keypad = Auth::user()->customer->keypads()->findOrFail($id);
            $keypad->on_vote = !$keypad->on_vote;
            
            if ($keypad->save()) {
                // Log kayıtları
                $keypadLog = new KeypadLog();
                $keypadLog->keypad_id = $keypad->id;
                $keypadLog->action = $keypad->on_vote ? 'start' : 'stop';
                
                if ($keypad->on_vote) {
                    $keypad->voting_started_at = now()->format('Y-m-d H:i');
                    $keypad->voting_finished_at = null;
                    $keypadLog->started_at = now();
                    $keypadLog->finished_at = null;
                    
                    SystemLog::info('Keypad voting started', [
                        'keypad_id' => $keypad->id,
                        'user_id' => Auth::user()->id,
                        'session_id' => $session->id
                    ]);
                } else {
                    $keypad->voting_finished_at = now()->format('Y-m-d H:i');
                    $keypadLog->started_at = $keypad->voting_started_at;
                    $keypadLog->finished_at = now();
                    
                    SystemLog::info('Keypad voting stopped', [
                        'keypad_id' => $keypad->id,
                        'user_id' => Auth::user()->id,
                        'session_id' => $session->id
                    ]);
                }
                
                $keypadLog->created_by = Auth::user()->id;
                $keypadLog->save();
                $keypad->save();
                
                // Event trigger
                event(new KeypadEvent(hall: $hall, on_vote: $keypad->on_vote));
                
                if($keypad->on_vote){
                    if ($meeting->participants->where('type', 'attendee')->count() > 0){
                        $meeting->participants->where('type', 'attendee')->first()->notify(new KeypadNotification($hall));
                    }
                    return back()->with('success', __('common.voting-started'));
                }
                else{
                    return back()->with('success', __('common.voting-stopped'));
                }
            } else {
                SystemLog::error('Keypad voting state change failed', [
                    'keypad_id' => $keypad->id,
                    'user_id' => Auth::user()->id,
                    'session_id' => $session->id
                ]);
                return back()->with('edit_modal', true)->with('error', __('common.a-system-error-has-occurred'))->withInput();
            }
        } catch (\Exception $e) {
            SystemLog::error('Keypad voting error: ' . $e->getMessage(), [
                'keypad_id' => $id,
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', __('common.a-system-error-has-occurred'))->withInput();
        }
    }
    
    public function resend_voting(int $meeting, int $hall, int $program, int $session, int $id)
    {
        try {
            $session_model = Auth::user()->customer->programSessions()->findOrFail($session);
            $hall_model = Auth::user()->customer->halls()->findOrFail($hall);
            $keypad = Auth::user()->customer->keypads()->findOrFail($id);
            
            // Keypad aktif değilse hata döndür
            if (!$keypad->on_vote) {
                return back()->with('error', __('common.keypad-is-not-active'));
            }
            
            // Resend işlemi için log kaydı
            $keypadLog = new KeypadLog();
            $keypadLog->keypad_id = $keypad->id;
            $keypadLog->action = 'resend';
            $keypadLog->started_at = now();
            $keypadLog->created_by = Auth::user()->id;
            $keypadLog->save();
            
            SystemLog::info('Keypad voting resent', [
                'keypad_id' => $keypad->id,
                'user_id' => Auth::user()->id,
                'session_id' => $session
            ]);
            
            // Doğru parametrelerle event tetikle
            event(new KeypadEvent(hall: $hall_model, on_vote: true));
            
            return back()->with('success', __('common.voting-resend'));
        } catch (\Throwable $e) {
            SystemLog::error('Keypad voting resend error: ' . $e->getMessage(), [
                'keypad_id' => $id,
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', __('common.a-system-error-has-occurred') . ': ' . $e->getMessage());
        }
    }
}
