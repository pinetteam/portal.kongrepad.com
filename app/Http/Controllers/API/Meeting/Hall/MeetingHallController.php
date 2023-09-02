<?php

namespace App\Http\Controllers\API\Meeting\Hall;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\Meeting\Hall\HallResource;
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
    public function active_keypad(Request $request, string $id)
    {
        $meeting_hall =  $request->user()->meeting->halls()->where("meeting_halls.id",$id)->first();
        $keypad = $meeting_hall->programSessions()->where('is_started', 1)->first()->keypads()->where('on_vote', 1)->first();
        if($keypad)
            return $keypad;
        else
            return "";
    }
}
