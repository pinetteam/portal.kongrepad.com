<?php

namespace App\Http\Controllers\API\Meeting\Announcement;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\Meeting\Announcement\AnnouncementResource;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index(Request $request)
    {

        try{
            $log = new \App\Models\Log\Meeting\Participant\Participant();
            $log->participant_id = $request->user()->id;
            $log->action = "get-announcements";
            $log->save();
            return [
                'data' => AnnouncementResource::collection($request->user()->meeting->announcements()->orderBy('created_at', 'desc')->get()),
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
