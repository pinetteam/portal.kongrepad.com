<?php

namespace App\Http\Controllers\API\Meeting\Hall;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MeetingHallController extends Controller
{
    public function index(Request $request)
    {
        return $request->user()->meeting->halls()->get();
    }
    public function show(Request $request, string $meeting_id, string $meeting_hall_id)
    {

        return $request->user()->meeting->halls()->findOrFail($meeting_hall_id) ;
    }
    public function active_document(Request $request, string $meeting_id, string $id)
    {
        $meeting_hall =  $request->user()->meeting->halls()->where('meeting_id',$meeting_id)->where("meeting_halls.id",$id)->first();
        $document = $meeting_hall->programSessions()->where('is_started', 1)->first()->document;
        if($document)
            return storage_path('app/documents/'.$document->file_name.'.'.$document->file_extension);
        else
            return "";
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
