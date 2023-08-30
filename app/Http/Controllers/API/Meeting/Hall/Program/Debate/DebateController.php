<?php

namespace App\Http\Controllers\API\Meeting\Hall\Program\Debate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DebateController extends Controller
{
    public function index(Request $request)
    {

        return $request->user()->meeting->debates()->where('on_air', 1)->first();
    }
    public function show(Request $request,string $id)
    {
        return $request->user()->meeting->programs()->where('meeting_hall_programs.id', $id)->first();
    }
}
