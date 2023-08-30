<?php

namespace App\Http\Controllers\API\Meeting;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\Meeting\MeetingResource;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    public function index(Request $request)
    {
        return [
            'data' => new MeetingResource($request->user()->meeting),
            'status' => true,
            'errors' => null
         ];
    }
}
