<?php

namespace App\Http\Controllers\API\Meeting\Announcement;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\Meeting\Announcement\AnnouncementResource;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index(Request $request)
    {
        return [
        'data' => AnnouncementResource::collection($request->user()->meeting->announcements()->get()),
        'status' => true,
        'errors' => null
    ];
    }
    public function show(Request $request, string $id)
    {
        return [
            'data' => new AnnouncementResource($request->user()->meeting->virtualStands()->where('meeting_virtual_stands.id',$id)->first()),
            'status' => true,
            'errors' => null
        ];
    }
}
