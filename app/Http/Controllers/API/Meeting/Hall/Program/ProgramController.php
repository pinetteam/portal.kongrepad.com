<?php

namespace App\Http\Controllers\API\Meeting\Hall\Program;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\Meeting\Hall\Program\ProgramRequest;
use App\Http\Resources\Portal\Meeting\Hall\Program\ProgramResource;
use App\Models\Customer\Customer;
use App\Models\Meeting\Hall\Program\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

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
