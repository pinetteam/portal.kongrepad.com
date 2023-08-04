<?php

namespace App\Http\Controllers\API\Meeting\Hall\Program;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index(Request $request, $meeting_id)
    {

        return $request->user()->meeting->programs()->get();
    }
    public function show(Request $request, $meeting_id, $id)
    {
        return $request->user()->meeting->programs()->where('meeting_hall_programs.id', $id)->first();
    }
}
