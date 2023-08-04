<?php

namespace App\Http\Controllers\API\Meeting\Hall;

use App\Events\FormSubmitted;
use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\Meeting\Hall\MeetingHallRequest;
use App\Http\Resources\Portal\Meeting\Hall\MeetingHallResource;
use App\Models\Meeting\Hall\MeetingHall;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
