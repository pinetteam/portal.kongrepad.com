<?php

namespace App\Http\Controllers\API\Meeting\Hall\Program\Debate\Team;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index(Request $request, int $debate)
    {

        return $request->user()->meeting->debates()->findOrFail($debate)->teams;
    }
    public function show(Request $request,string $id)
    {
        return $request->user()->meeting->programs()->where('meeting_hall_programs.id', $id)->first();
    }
}
