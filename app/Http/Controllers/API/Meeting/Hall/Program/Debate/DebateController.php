<?php

namespace App\Http\Controllers\API\Meeting\Hall\Program\Debate;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\Meeting\Hall\Program\Debate\DebateRequest;
use App\Http\Resources\Portal\Meeting\Hall\Program\Debate\DebateResource;
use App\Models\Meeting\Hall\Program\Debate\Debate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DebateController extends Controller
{

    public function index(Request $request, $program_id){
        return $request->user()->meeting->programs()->where('meeting_hall_programs.id', $program_id)->first()->debates()->get();
    }
    public function show(Request $request, string $program_id, string $id)
    {
        return $request->user()->customer->debates()->where('meeting_hall_program_debates.id', $id)->first();
    }
}
