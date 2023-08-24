<?php

namespace App\Http\Controllers\API\Meeting\Announcement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index(Request $request)
    {
        return $request->user()->meeting->announcements()->get();
    }
    public function show(Request $request, string $id)
    {
        return $request->user()->meeting->virtualStands()->where('meeting_virtual_stands.id',$id)->first();
    }
}
