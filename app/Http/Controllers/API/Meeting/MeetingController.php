<?php

namespace App\Http\Controllers\API\Meeting;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\Meeting\MeetingResource;
use App\Http\Traits\ParticipantLog;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    use ParticipantLog;
    public function index(Request $request)
    {
        try {
            $meeting = $request->user()->meeting;
            $this->logParticipantAction($request->user(), "get-meeting", $meeting->title);
            return [
                'data' => new MeetingResource($meeting),
                'status' => true,
                'errors' => null
            ];
        } catch (\Throwable $e) {
            return [
                'data' => null,
                'status' => false,
                'errors' => [$e->getMessage()]
            ];
        }
    }
}
