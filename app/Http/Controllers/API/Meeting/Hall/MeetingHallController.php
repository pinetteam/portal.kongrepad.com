<?php

namespace App\Http\Controllers\API\Meeting\Hall;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\Meeting\Document\DocumentResource;
use App\Http\Resources\API\Meeting\Hall\HallResource;
use App\Http\Resources\API\Meeting\Hall\Program\Debate\DebateResource;
use App\Http\Resources\API\Meeting\Hall\Program\Session\Keypad\KeypadResource;
use App\Http\Resources\API\Meeting\Hall\Program\Session\SessionResource;
use Illuminate\Http\Request;

class MeetingHallController extends Controller
{
    public function index(Request $request)
    {
        return [
            'data' => HallResource::collection($request->user()->meeting->halls()->get()),
            'status' => true,
            'errors' => null
        ];
    }
    public function show(Request $request, int $id)
    {

        return [
            'data' => new HallResource($request->user()->meeting->halls()->findOrFail($id)),
            'status' => true,
            'errors' => null
        ];
    }
    public function active_keypad(Request $request, int $id)
    {
        $meeting_hall =  $request->user()->meeting->halls()->where("meeting_halls.id", $id)->first();
        $session = $meeting_hall->programSessions()->where('on_air', 1)->first();
        if(!isset($session)){
            $result['data'] = null;
            $result['status'] = false;
            $result['errors'] = [__('common.there-is-not-active-session')];
        }
        $keypad = $session->keypads()->where('on_vote', 1)->first();
        $result = [];
        if(isset($keypad)) {
            $result['data'] = new KeypadResource($keypad);
            $result['status'] = true;
            $result['errors'] = null;
        }
        else{
            $result['data'] = null;
            $result['status'] = false;
            $result['errors'] = [__('common.there-is-not-active-keypad')];
        }
        return $result;
    }
    public function active_debate(Request $request, int $id)
    {
        $meeting_hall =  $request->user()->meeting->halls()->where("meeting_halls.id", $id)->first();
        $debate = $meeting_hall->debates()->where('on_vote', 1)->first();
        $result = [];
        if(isset($debate)) {
            $result['data'] = new DebateResource($debate);
            $result['status'] = true;
            $result['errors'] = null;
        }
        else{
            $result['data'] = null;
            $result['status'] = false;
            $result['errors'] = [__('common.there-is-not-active-debate')];
        }
        return $result;
    }
    public function active_document(Request $request, int $id)
    {
        $meeting_hall = $request->user()->meeting->halls()->findOrFail($id);
        $session = $meeting_hall->programSessions()->where('on_air', 1)->first();
        $result = [];
        if(isset($session)) {
            if(isset($session->document)) {
                $result['data'] = new DocumentResource($session->document);
                $result['status'] = true;
                $result['errors'] = null;
            }
            else{
                $result['data'] = null;
                $result['status'] = false;
                $result['errors'] = [__('common.there-is-not-any-document')];
            }
        } else{
            $result['data'] = null;
            $result['status'] = false;
            $result['errors'] = [__('common.there-is-not-active-session')];
        }
        return $result;
    }
    public function active_session(Request $request, int $id)
    {
        $meeting_hall = $request->user()->meeting->halls()->findOrFail($id);
        $session = $meeting_hall->programSessions()->where('on_air', 1)->first();
        $result = [];
        if(isset($session)) {
            $result['data'] = new SessionResource($session);
            $result['status'] = true;
            $result['errors'] = null;
        } else{
            $result['data'] = null;
            $result['status'] = false;
            $result['errors'] = [__('common.there-is-not-active-session')];
        }
        return $result;
    }
}
