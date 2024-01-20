<?php

namespace App\Http\Controllers\API\Meeting\Announcement;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\Meeting\Announcement\AnnouncementResource;
use App\Http\Traits\ParticipantLog;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    use ParticipantLog;
    public function index(Request $request)
    {

        try{
            $meeting = $request->user()->meeting;
            $this->logParticipantAction($request->user()->id, "get-announcements", __('common.meeting') . ': ' . $meeting->title);;
            return [
                'data' => AnnouncementResource::collection($meeting->announcements()->orderBy('created_at', 'desc')->get()),
                'status' => true,
                'errors' => null
            ];
        } catch (\Throwable $e){
            return [
                'data' => null,
                'status' => false,
                'errors' => [$e->getMessage()]
            ];
        }
    }
}
